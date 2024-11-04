<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Events\EventApproved;
use App\Events\OrganizerActivated;
use App\Mail\ActivationStatusMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateEventOrganizer;

class AdminController extends Controller
{
    public function __construct(User $user,Event $event){
        $this->user = $user;
        $this->event = $event;
    }
    public function index(){
        $users=$this->user->where('is_admin',0)->get();

       // Filter users who have the 'event_organizer' role
        $eventOrganizers = $users->filter(function ($user) {
            return $user->hasRole('event_organizer');
        });
        $activeEventOrganizers =$users->filter(function($user){
            return $user->active_organizer;
        });
        $InactiveEventOrganizers =$users->filter(function($user){
            return !$user->active_organizer;
        });
        return view('Admin.index',compact('eventOrganizers','activeEventOrganizers','InactiveEventOrganizers'));
    }
    public function updateStatus($id)
    {
       // Find the event organizer by ID
        $eventOrganizer = $this->user->findOrFail($id);

        // Toggle between active and inactive status
        $eventOrganizer->active_organizer = !$eventOrganizer->active_organizer;
        $eventOrganizer->save();

        // Determine the new status for logging and notification
        $newStatus = $eventOrganizer->active_organizer ? 'activated' : 'deactivated';

        // Log the status update
        Log::info('Organizer status updated', [
            'organizer_id' => $eventOrganizer->id,
            'new_status' => $newStatus, // Use the variable for clarity
        ]);

        // If the organizer is activated, trigger the event
        event(new OrganizerActivated($eventOrganizer));
        

        // Send the activation status email
        Mail::to($eventOrganizer->email)->send(new ActivationStatusMail($eventOrganizer, $newStatus));

        return redirect()->back()->with('success', 'Event Organizer status updated successfully.');
    }
    
    public function edit($id)
    {
        // Fetch the event organizer by ID
        $organizer = $this->user->findOrFail($id); 
        return view('Admin.edit',compact('organizer'));

    }
    public function update(UpdateEventOrganizer $request, $id)
    {
        // Find the event organizer by ID
        $eventOrganizer = $this->user->findOrFail($id);

        // Update the event organizer's details
        $eventOrganizer->update($request->all());

        // Flash message for success
        return  redirect()->route('admin.index')->with('success', 'Organizer updated successfully.');
    }
    public function destroy($id)
    {
        // Find the event organizer by ID
        $eventOrganizer = $this->user->findOrFail($id);
        
        $role = Role::where('name', 'attendee')->first();
        if ($role) {
            $eventOrganizer->roles()->sync($role->id);
        }
        $events=Event::where('organizer_id',$eventOrganizer->id)->get();
        foreach ($events as $event) {
            $event->delete();
        }
        // Flash message for success
        return redirect()->route('admin.index')->with('success', 'Organizer deleted successfully.');
    }
    public function showEvents($id)
    {
        $eventOrganizer = $this->user->findOrFail($id); // Find the organizer
        $events = $this->event->where('organizer_id', $eventOrganizer->id)->get(); // Fetch their events

        return view('admin.event_organizers.events', compact('eventOrganizer', 'events'));
    }
    public function updateEventStatus(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,completed',
        ]);

        $event->status = $request->status;
        $event->save();
        // Event Organizer ID
        $userId = $event->organizer_id; 

            
        
        // Log the status update with a context array
        Log::info('Event status updated', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'new_status' => $event->status,
            'organizer_id' => $userId,
        ]);
        
        // Dispatch the EventApproved event (renamed to EventUpdated for clarity)
        event(new EventApproved($event, $userId));

        return redirect()->back()->with('success', 'Event status updated successfully.');
    }
   
   public function listEventsByStatus(Request $request, $eventOrganizerId)
{
    // Fetch events based on the organizer ID and status
    $status = $request->get('status');
    
    $events = $this->event->where('organizer_id', $eventOrganizerId)
        ->when($status !== 'all', function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->with('images') // Ensure images are eager-loaded
        ->get();

    // Return a partial view with the event cards
    return view('Admin.event_organizers.partials.events', compact('events'))->render();
}



}
