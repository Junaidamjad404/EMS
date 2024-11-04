<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use App\Models\TicketPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCreatedForAttendee;
use App\Mail\EventPendingApprovalForAdmin;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\Attendee\LoginRequest;

class AttendeeController extends Controller
{
    protected $user;
    protected $event;
    protected $role;
    protected $category;
    public function __construct(User $user,Event $event,Role $role,Category $category){
        $this->user=$user;
        $this->event = $event;
        $this->role = $role;
        $this->category = $category;
    }
    public function index(){
        $events=$this->event->approved()->get();
        $categories=$this->category->all();
        return view('Attendees.index',compact('events','categories'));
    }
    public function login(LoginRequest $request)
    {
        // Validate the request
        $credentials = $request->validated();
        $user=User::where('email',$request->email)->first();
       
        // Check if the "remember me" checkbox is selected
         $remember = $request->has('remember');
        // Attempt to login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            if($user->hasRole('admin'))
            {
                return redirect()->route('admin.index');
            }else if($user->active_organizer == 1 && $user->hasRole('event_organizer')){
                return redirect()->route('events.index');
            }
            // If login successful, regenerate session ID
            
            // Authentication passed, redirect to the intended page or dashboard
            return redirect()->route('user.index')->with('success', 'You are logged in!');
        }

        // Authentication failed
        return back()->withErrors(['email' => 'Invalid credentials or account not found.']);
    }
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new attendee (user)
        $user = $this->user->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $role=$this->role->where('name','attendee')->first();
        $user->roles()->sync($role->id);
        // Log in the newly registered attendee
        Auth::login($user);

        // Redirect to dashboard or intended page after registration
        return redirect()->route('user.index')->with('success', 'Registration successful!');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to homepage or login page after logout
        return redirect()->route('user.index')->with('success', 'You have been logged out.');
    }
    public function event_detail($eventId){
        $event=$this->event->findOrFail($eventId);
        return view('Attendees.Events.Details',compact('event'));
    }
    public function create_event()
    {   
        $categories=$this->category->all();
        return view('Attendees.Events.create',compact('categories'));
    }
    public function store_event(Request $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            // Validate request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'location' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'address' => 'nullable|string|max:255',
                'promotional_images.*' => 'image|mimes:jpg,jpeg,png|max:2048', // Add size limit
                'promotional_videos.*' => 'file|mimes:mp4,avi,mov|max:10240', // Add size limit
            ]);
            
            // Gather event data and set default status
            $eventData = $validatedData;
            $eventData['status'] = EventStatus::Pending->value;
            $eventData['organizer_id'] = auth()->user()->id;

            // Create the event using the validated data
            $event = $this->event->create($eventData);

            // Handle promotional images
            if ($request->has('promotional_images')) {
                foreach ($request->file('promotional_images') as $image) {
                    $path = $image->store('promotional_images', 'public');
                    $event->images()->create(['image_url' => $path]);
                }
            }

            // Handle promotional videos
            if ($request->has('promotional_videos')) {
                foreach ($request->file('promotional_videos') as $video) {
                    $path = $video->store('promotional_videos', 'public');
                    $event->videos()->create(['video_url' => $path]);
                }
            }

            // Assign the 'event_organizer' role to the user if it exists
            $role = $this->role->where('name', 'event_organizer')->first();
            if ($role) {
                auth()->user()->roles()->sync($role->id);
            }

            // Commit the transaction since everything is successful
            DB::commit();
              // Mail the attendee
            Mail::to(auth()->user()->email)->send(new EventCreatedForAttendee($event, auth()->user()));

            // Mail the admin
            $adminEmail = config('mail.admin_email'); // Define the admin email in your config
            Mail::to($adminEmail)->send(new EventPendingApprovalForAdmin($event, auth()->user()));
            // Return success response
            return redirect()->route('user.index')->with(['message' => 'Event created successfully.']);

        } catch (Exception $e) {
            // Rollback the transaction if something went wrong
            DB::rollBack();

            // Log the error with detailed information
            Log::error('Event creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['_token', 'password', 'promotional_images', 'promotional_videos']), // Log user input except sensitive data
            ]);

            // Return a general error message to the user
            return redirect()->back()->withInput()->withErrors(['error' => 'An error occurred while creating the event. Please try again.']);
        }
    }

    public function events(){
        $events=$this->event->approved()->get();
        $categories=$this->category->all();
        $event_organizers=$this->user->where('active_organizer',1)->get();
        return view('Attendees.Events.index',compact('events','categories','event_organizers'));
    }
    public function orders(Request $request)
    {
        $userId = auth()->id(); // Get the authenticated user ID

        // Fetch past and upcoming events the user has registered for
        $Tickets = TicketPurchase::where('user_id', $userId)
            ->orderBy('created_at', 'desc') // Sort by date
            ->get();
        return view('Attendees.Order', compact('Tickets'));
    }
    public function show(){
         $user = Auth::user(); // Retrieve the logged-in user
         return view('Attendees.Profile.show', compact('user')); // Return the profile view with user data
    }
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        
        // Validate the request
       
        // Update user profile
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile.show')->with('success', 'Profile updated successfully.');
    }   
}
