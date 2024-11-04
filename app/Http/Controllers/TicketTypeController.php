<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketTypeRequest;
use App\Http\Requests\UpdateTicketTypeRequest;

class TicketTypeController extends Controller
{

    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes;
        return view('events.ticket_types.index', compact('ticketTypes', 'event'));
    }

    public function create(Event $event)
    {
        return view('events.ticket_types.create', compact('event'));
        
    }

    public function store(StoreTicketTypeRequest $request, Event $event)
    {
        $ticketType = TicketType::create($request->validated());

        // Attach the new ticket type to the event with additional pivot data
        $event->ticketTypes()->attach($ticketType->id, [
            'price' => $request->input('price'), // Ensure to validate price in the request
            'quantity' => $request->input('quantity') // Ensure to validate quantity in the request
        ]);


        return redirect()->route('ticket_types.index', $event->id)->with('success', 'Ticket Type Created');
    }

    public function edit(Event $event, TicketType $ticketType)
    {
       // Load the pivot data using the event's relationship
        $eventTicketType = $event->ticketTypes()->withPivot('quantity', 'price')->find($ticketType->id);

        // Check if the ticket type is associated with the event
        if (!$eventTicketType) {
            abort(404, 'Ticket Type not found for this event.');
        }

        return view('events.ticket_types.edit', compact('event', 'eventTicketType'));
    }

    public function update(UpdateTicketTypeRequest $request, Event $event, TicketType $ticketType)
    {
        $ticketType->update($request->validated());
         // Update pivot table entry for this ticket type in the event
        $event->ticketTypes()->updateExistingPivot($ticketType->id, [
            'price' => $request->input('price'), // Ensure to validate price in the request
            'quantity' => $request->input('quantity') // Ensure to validate quantity in the request
        ]);
        return redirect()->route('ticket_types.index', $event->id)->with('success', 'Ticket Type Updated');
    }

    public function destroy(Event $event, TicketType $ticketType)
    {
        $ticketType->delete();
        return redirect()->route('ticket_types.index', $event->id)->with('success', 'Ticket Type Deleted');
    }
   

    public function syncTicketTypes(Request $request,  $eventId)
    {
        Log::error("message", $request->validate([
            'ticket_types' => 'array', // Ensure ticket_types is an array
            'ticket_types.*' => 'array', // Each ticket type should be an array
            'ticket_types.*.id' => 'required|exists:ticket_types,id', // Ensure id exists in the ticket_types table
            'ticket_types.*.price' => 'required|numeric', // Ensure price is present and is numeric
            'ticket_types.*.quantity' => 'required|integer|min:1' // Ensure quantity is present, is an integer, and is at least 1
        ]));
        
       $request->validate([
            'ticket_types' => 'array', // Ensure ticket_types is an array
            'ticket_types.*' => 'array', // Each ticket type should be an array
            'ticket_types.*.id' => 'required|exists:ticket_types,id', // Ensure id exists in the ticket_types table
            'ticket_types.*.price' => 'required|numeric', // Ensure price is present and is numeric
            'ticket_types.*.quantity' => 'required|integer|min:1', // Ensure quantity is present, is an integer, and is at least 1
        ]);

       
        $event = Event::findOrFail($eventId);
        if(!$event){
             return redirect()->route('events.index');
        }
         // Prepare the data for syncing
        $syncData = [];
        foreach ($request->ticket_types as $ticketType) {
            $syncData[$ticketType['id']] = [
                'price' => $ticketType['price'],
                'quantity' => $ticketType['quantity'],
            ];
        }
        // Sync the ticket types with the event
        $event->ticketTypes()->sync($syncData);
        return redirect()->route('events.index')->with('success', 'Ticket Types Updated');
    }
    public function getTicketTypesForEvent($eventId)
    {
        // Fetch all ticket types
        $allTicketTypes = TicketType::all();

        // Fetch assigned ticket types for the event
        $event = Event::findOrFail($eventId);
       // Get the ticket types associated with the event along with pivot data (price, quantity)
        $eventTicketTypes = $event->ticketTypes->map(function($ticketType) {
            return [
                'id' => $ticketType->id,
                'name' => $ticketType->name,
                'price' =>  $ticketType->pivot->price, // Access pivot price
                'quantity' => $ticketType->pivot->quantity // Access pivot quantity
            ];
        });
        return response()->json([
            'availableTicketTypes' => $allTicketTypes,
            'eventTicketTypes' => $eventTicketTypes,
        ]);
    }

}
