<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use App\Events\EventCreated;
use Illuminate\Http\Request;
use App\Mail\EventCreatedMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\event\EventStoreRequest;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\Event\EventUpdateRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EventController extends Controller implements HasMiddleware
{
    use AuthorizesRequests; // Ensure this trait is included

    public static function middleware():array{
        return [
            new middleware('permission:create events', only:['create']),
            new middleware('permission:view events', only:['show','index']),
            new middleware('permission:edit events', only:['update','edit']),
            new middleware('permission:delete events', only:['delete'])
        ];
    }
    public function __construct(Event $event,Category $categories,User $organizer){
        $this->event = $event;
        $this->categories = $categories;
        $this->organizer = $organizer;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch events for pagination
        if (!$user->is_admin) {
            // Paginate events for non-admin users
            $events = $this->event
                ->where('organizer_id', $user->id)
                ->orderBy('date', 'DESC')
                ->paginate(10);

            // Fetch all events for the user (not paginated) for counting logic
            $allEvents = $this->event->where('organizer_id', $user->id)->get();
        } else {
            // Paginate all events for admin users
            $events = $this->event
                ->orderBy('date', 'DESC')
                ->paginate(10);

            // Fetch all events (not paginated) for counting logic
            $allEvents = $this->event->all();
        }

        // Initialize arrays
        $eventCounts = [
            'months' => [],
            'completed' => [],
            'uncompleted' => [],
        ];

        // Start from the current month and move backwards or forwards explicitly
        $startMonth = Carbon::now()->subMonths(6);

        // Loop through 12 months starting from 6 months ago up to 5 months in the future
        for ($i = 0; $i < 12; $i++) {
            // Get month and year explicitly by adding months starting from $startMonth
            $month = $startMonth->copy()->addMonths($i)->format('F Y');

            // Add the month to the months array
            $eventCounts['months'][] = $month;

            // Count completed events for the month
            $completedCount = $allEvents->filter(function ($event) use ($startMonth, $i) {
                return Carbon::parse($event->date)->isSameMonth($startMonth->copy()->addMonths($i)) 
                    && $event->status == EventStatus::Completed->value;
            })->count();
            $eventCounts['completed'][] = $completedCount;

            // Count uncompleted events for the month (upcoming events in the future)
            $uncompletedCount = $allEvents->filter(function ($event) use ($startMonth, $i) {
                return Carbon::parse($event->date)->isSameMonth($startMonth->copy()->addMonths($i)) 
                    && ($event->status != EventStatus::Completed->value && Carbon::parse($event->date)->isFuture());
            })->count();
            $eventCounts['uncompleted'][] = $uncompletedCount;
        }

        // Reverse the arrays to show from the oldest to the most recent month
        $eventCounts['months'] = array_reverse($eventCounts['months']);
        $eventCounts['completed'] = array_reverse($eventCounts['completed']);
        $eventCounts['uncompleted'] = array_reverse($eventCounts['uncompleted']);

        // Return the view with paginated events and event counts
        return view('events.index', compact('events', 'eventCounts'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=$this->categories->all();
        $organizer = Auth::user(); // Get the authenticated user as the organizer
        return view('events.create', compact('categories','organizer')); // Return view for creating an event

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request)
    {
        
        // Log the request data for debugging
        Log::info('Creating event with data: ', $request->all());

        try {
            $eventData=$request->all();
            $eventData['status']=EventStatus::Pending->value;
            // Create the event using the validated data
            $event = $this->event->create($eventData);
            if ($request->has('promotional_images')) {
                foreach ($request->file('promotional_images') as $image) {
                    $path = $image->store('promotional_images', 'public');
                    $event->images()->create(['image_url' => $path]);
                }
            }

            if ($request->has('promotional_videos')) {
                foreach ($request->file('promotional_videos') as $video) {
                    $path = $video->store('promotional_videos', 'public');
                    $event->videos()->create(['video_url' => $path]);
                }
            }
            // Admin ID 
            $adminId = 18; 

        // Dispatch the EventCreated event
            event(new EventCreated($event, $adminId));

            Mail::to($event->organizer->email)->send(new EventCreatedMail($event));

            return redirect()->route('events.index')->with('success', 'Event created successfully.');
        } catch (\Exception $e) {
            // Log any exceptions for further investigation
            Log::error('Error creating event: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Failed to create event.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id); // Fetch the event by ID
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update',$event);
        $categories = Category::all(); // Fetch all categories for the dropdown
        return view('events.edit', compact('event', 'categories')); // Pass both event and categories
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info($request->all()); // Log all incoming request data
         try {
            $event = $this->event->findOrFail($id); // Find the event or fail with a 404

            // Update event details
            $event->update($request->only('title', 'location', 'date', 'category_id', 'description','status'));

            // Handle existing image IDs
            $existingImageIds = explode(',', $request->input('existing_image_ids'));
            $existingVideoIds = explode(',', $request->input('existing_video_ids'));

            // Upload new images
            if ($request->hasFile('promotional_images') && count($request->file('promotional_images')) > 0) {
                foreach ($request->file('promotional_images') as $image) {
                    // Prevent duplication
                    if (!in_array($image->hashName(), $existingImageIds)) {
                        $path = $image->store('promotional_images', 'public');
                        $event->images()->create(['image_url' => $path]);
                    }
                }
            }

            // Upload new videos
            if ($request->hasFile('promotional_videos') && count($request->file('promotional_videos')) > 0) {
                foreach ($request->file('promotional_videos') as $video) {
                    // Prevent duplication
                    if (!in_array($video->hashName(), $existingVideoIds)) {
                        $path = $video->store('promotional_videos', 'public');
                        $event->videos()->create(['video_url' => $path]);
                    }
                }
            }
                   

            return redirect()->route('events.index')->with('success', 'Event updated successfully.');
        } catch (\Exception $e) {
            // Log any exceptions for further investigation
            Log::error('Error creating event: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Failed to create event.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Log user details
        $user = auth()->user();
       

        // Authorize deletion
        if ($this->authorize('delete', $event)) {
            $event->delete();
            return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
        }

        // If authorization fails
        Log::error('Authorization failed for user ' . $user->id . ' on event ' . $event->id);
        return redirect()->route('events.index')->with('error', 'You are not authorized to delete this event.');
    }

    public function deleteImage($eventid, $imageId)
    {
        $event = $this->event->findOrFail($eventid);
        $image = $event->images()->findOrFail($imageId);

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image_url);

        // Delete the image record from the database
        $image->delete();

        return response()->json(['success' => true]);
    }
    public function deleteVideo( $eventid, $videoId)
    {
        $event = $this->event->findOrFail($eventid);
        $video = $event->videos()->findOrFail($videoId);

        // Delete the video file from storage
        Storage::disk('public')->delete($video->video_url);

        // Delete the video record from the database
        $video->delete();

        return response()->json(['success' => true]);
    }
    public function notApproved()
    {
        return view('organizer.not_approved');
    }
    public function filter(Request $request)
    {
        $query = $this->event->query();

        if ($request->filled('eventName')) {
            $query->where('title', 'like', '%' . $request->eventName . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }

        if ($request->filled('startDate')) {
            // Convert the startDate from the request to a Carbon instance
                $startDate = Carbon::parse($request->startDate)->format('Y-m-d H:i:s');
                // Use the Carbon instance to filter events
                $query->whereDate('date', '>=', $startDate);
        }

        $events = $query->get();

        return view('Attendees.Events.partials.event-list', compact('events'))->render();
    }

}
