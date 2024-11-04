<?php

namespace App\Http\Controllers\Attendee;


use Exception;
use App\Models\Event;
use Stripe\PaymentIntent;
use App\Models\TicketType;
use Illuminate\Http\Request;
use App\Models\TicketPurchase;
use App\service\PayPalService;
use App\service\StripeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use App\Mail\TicketPurchaseConfirmation;
use App\Http\Requests\TicketPurchaseRequest;

class TicketController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService,PayPalService $paypalService)
    {
        $this->stripeService = $stripeService;
        $this->paypalService = $paypalService;
    }
   // Show the available tickets for an event
    public function show($id)
    {
        // Fetch the event and its ticket types
        $event = Event::with('ticketTypes')->findOrFail($id);

        return view('tickets.show', compact('event'));
    }

    // Handle ticket purchase
    public function buy(TicketPurchaseRequest $request, $id)
    {
        // Log the request data for debugging purposes
        Log::info('Creating payment intent', [
            'Data' => $request->all(),
        ]);

        $event = Event::findOrFail($id);

        // Fetch the ticket type with pivot data
        $ticketType = $event->ticketTypes()->withPivot('price', 'quantity')->findOrFail($request->ticket_type_id);
        // Now you can access pivot data
        $availableQuantity = $ticketType->pivot->quantity;
        if ($availableQuantity < $request->quantity) {
            return response()->json(['error' => 'Requested quantity exceeds available tickets.'], 400);
        }

        // Calculate total price
        $totalPrice = $ticketType->pivot->price * $request->quantity *100;
        try {
            if ($request->payment_method == 'paypal') {
                $returnUrl = route('paypal.callback'); // Define these routes for success and cancel URLs

                $cancelUrl = route('event.tickets',['id' => $event->id]);

                $order = $this->paypalService->createOrder(($totalPrice/100)/280, 'USD', $returnUrl, $cancelUrl,$event->id,$request->all());
               
                return response()->json(['approvalUrl' => $order['approvalUrl']]);
            }else if ($request->payment_method == 'stripe') {
                  
                // Create and return payment intent client secret
                $paymentIntent = $this->stripeService->createPaymentIntent($totalPrice, 'pkr', [
                    'email' => $request->email,
                    'name' => $request->name,
                    'quantity' => $request->quantity,
                ]);
                // Log the successful creation of the payment intent
                Log::info('Payment intent created successfully', ['clientSecret' => $paymentIntent->client_secret]);

                return response()->json(['clientSecret' => $paymentIntent->client_secret]);
            }
            

        }catch (Exception $e) {
            // Catch any other exceptions that may occur
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.']);
        }

    }
    public function finalizePurchase(Request $request)
    {
         // Validate the required fields from the request
        $request->validate([
            'paymentMethod' => 'required|string|in:stripe,paypal', // Indicate payment method
            'paymentIntentId' => 'nullable|string', // Stripe payment intent ID, not required for PayPal
            'event_id' => 'required|integer',
            'ticket_type_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
                // Retrieve event and ticket type details
            $event = Event::findOrFail($request->input('event_id'));
            $ticketType = $event->ticketTypes()->withPivot('price', 'quantity')->findOrFail($request->input('ticket_type_id'));

            // Handle Stripe payment verification
            if ($request->paymentMethod === 'stripe') {
                $paymentIntentId = $request->input('paymentIntentId');
                // Verify if payment was successful
                if (!$this->stripeService->isPaymentSuccessful($paymentIntentId)) {
                    throw new Exception("Payment verification failed for Stripe.");
                }
            }

            // Step 4: Create and save the ticket purchase
            $purchase = new TicketPurchase();
            $purchase->user_id = auth()->id();
            $purchase->event_id = $event->id;
            $purchase->ticket_type_id = $ticketType->id;
            $purchase->quantity = $request->input('quantity');
            $purchase->total_price = $ticketType->pivot->price * $request->input('quantity');
            $purchase->save();

            // Step 5: Update ticket quantity in the pivot table
            $newQuantity = $ticketType->pivot->quantity - $request->input('quantity');
            $event->ticketTypes()->updateExistingPivot($ticketType->id, ['quantity' => $newQuantity]);

            // Step 6: Send a confirmation email
            Mail::to(auth()->user()->email)->send(new TicketPurchaseConfirmation($purchase));

            DB::commit();
            if ($request->paymentMethod === 'paypal') {
                return redirect()->route('event.tickets', ['id' => $event->id])
                                ->with(['paypal_session_message' => 'Payment successful via PayPal!']); 
            }

            return response()->json(['success' => true, 'message' => 'Payment successful via Stripe!']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Finalizing purchase failed: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Purchase finalization failed.'], 500);
        }
    }
    public function handlePayPalCallback(Request $request){
       // Capture the order using the token received from PayPal
        $response = $this->paypalService->captureOrder($request->token);
        
        // Retrieve custom metadata
        $customData = json_decode($response['purchase_units'][0]['payments']['captures'][0]['custom_id'], true);
        
        // Check if the response indicates a successful payment
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Prepare the data for finalizing the purchase
            $finalizeData = [
                'paymentMethod' => $customData['paymentMethod'], // The PayPal order ID
                'event_id' => $customData['event_id'], // Retrieve the event ID from the request
                'ticket_type_id' =>  $customData['ticket_type_id'], // Retrieve the ticket type ID from the request
                'quantity' => $customData['quantity'] // Ensure you pass the quantity as well
            ];

            // Call the finalizePurchase method with the prepared data
            return $this->finalizePurchase(new Request($finalizeData));
        } else {
            // Handle the case where the payment was not successful
            return response()->json(['success' => false, 'message' => 'Payment was not successful.'], 400);
        }
    }

    public function getTicketPurchases($eventId)
    {
        // Replace this with your actual logic to fetch ticket purchases
        $ticketPurchases = TicketPurchase::with(['user','ticketType','event'])->where('event_id', $eventId)->get();

        return response()->json($ticketPurchases);
    }
    public function updateAttendance(Request $request, $id)
    {
        $request->validate([
            'attendance_status' => 'required|in:present,absent',
        ]);

        $ticketPurchase = TicketPurchase::findOrFail($id);
        $ticketPurchase->attendance_status = $request->attendance_status;
        $ticketPurchase->save();

        return response()->json(['message' => 'Attendance status updated successfully']);
    }
    
}
