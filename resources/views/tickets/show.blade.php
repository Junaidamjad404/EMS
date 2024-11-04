@extends('layouts.main')

@section('content')
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 1.25rem;
        }

        .btn-primary {
            background-color: #8c00ff;
            border-color: #8c00ff;
        }

        .payment-method-toggle button {
            margin-right: 5px;
            font-size: 1rem;
            padding: 8px 16px;
        }

        .active-method {
            background-color: #8c00ff !important;
            color: white !important;
        }
    </style>
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <!-- Left Column: Event Details with Image and Video -->
                <div class="col-lg-6">
                    <!-- Event Details -->
                    <div class="card mt-4">
                        <div class="mr-2 mt-2 text-center">
                            <img src="{{ asset(!empty($event->images->first()->image_url) ? $event->images()->first()->image_url : '') }}"
                                class="img-fluid rounded mb-3" alt="Event Image">
                        </div>
                        <div class="card-body shadow-sm">
                            <h4 class="card-title">Event Details</h4>
                            <ul class="list-unstyled">
                                <li><strong>Date:</strong> {{ $event->date->format('F j, Y') }}</li>
                                <li><strong>Time:</strong> {{ $event->date->format('g:i A') }}</li>
                                <li><strong>Location:</strong> {{ $event->location }}</li>
                            </ul>
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Ticket Purchase Form -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #8c00ff;">
                            <h6 style="color: white;">Buy Your Ticket</h6>
                        </div>
                        <div class="card-body">
                            <!-- Display Success/Error Messages -->
                            <div id="alertContainer"></div>

                            <form action="{{ route('tickets.buy', $event->id) }}" method="POST" id="ticketForm">
                                @csrf

                                <!-- Ticket Type Cards -->
                                <div class="form-group mb-2">
                                    <label class="auth-label">Select Ticket Type</label>
                                    <div class="row">
                                        @foreach ($event->ticketTypes as $ticketType)
                                            <div class="col-md-3 mb-1">
                                                <div class="card ticket-type-card"
                                                    data-price="{{ $ticketType->pivot->price }}"
                                                    style="padding: 8px; font-size: 14px;">
                                                    <div class="card-body text-center p-2">
                                                        <h6 class="card-title mb-1"
                                                            style="font-size: 13px; font-weight: bold;">
                                                            {{ $ticketType->name }}</h6>
                                                        <p class="card-text mb-1" style="font-size: 12px;">
                                                            ${{ number_format($ticketType->pivot->price, 2) }}</p>
                                                        <p class="card-text text-muted mb-0" style="font-size: 11px;">
                                                            {{ $ticketType->pivot->quantity }} available</p>
                                                    </div>
                                                    <input type="radio" name="ticket_type_id"
                                                        value="{{ $ticketType->id }}">

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Display Error Message for Ticket Type Selection -->
                                </div>

                                <!-- Quantity -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control form-control-sm" min="1" placeholder="Enter quantity">
                                </div>

                                <!-- Price Display -->
                                <div class="form-group mb-2">
                                    <label>Total Price: </label>
                                    <p id="totalPrice" class="font-weight-bold ">$0.00</p>
                                </div>

                                <!-- Name -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="name">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm"
                                        placeholder="Your full name">
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm"
                                        placeholder="Your email">
                                </div>

                                <!-- Address -->
                                <div class="form-group mb-2">
                                    <label class="auth-label" for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control form-control-sm"
                                        placeholder="Your address">
                                </div>
                                <!-- Payment Method Toggle -->
                                <div class="payment-method-toggle text-center mb-3">
                                    <button type="button" class="btn active-method" id="stripeButton">Pay with
                                        Stripe</button>
                                    <button type="button" class="btn" id="paypalButton">Pay with PayPal</button>
                                </div>
                                <!-- Hidden input for payment method -->
                                <input type="hidden" name="payment_method" id="paymentMethod" value="stripe">
                                <!-- Default to Stripe -->
                                <!-- Stripe Elements Card Input -->
                                <div id="stripe-section">
                                    <div class="form-group mb-2">
                                        <label class="auth-label">Card Details</label>
                                        <div id="card-element" class="form-control py-3"></div>
                                        <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                    </div>
                                </div>

                                <!-- PayPal Button -->
                                <div id="paypal-section" class="d-none">
                                    <!-- Display user input -->
                                    <div id="user-info" class="mt-3">
                                        <h5>User Information</h5>
                                        <p><strong>Name:</strong> <span id="display-name"></span></p>
                                        <p><strong>Email:</strong> <span id="display-email"></span></p>
                                        <p><strong>Total Amount:</strong> <span id="display-total-price"></span></p>
                                    </div>
                                    <!-- Placeholder for PayPal button -->
                                    <div id="paypal-button-container"></div>
                                </div>

                                <!-- Hidden input for Stripe client secret -->
                                <input type="hidden" id="client-secret" name="client_secret" value="">

                                <!-- Submit Button with Loading Spinner -->
                                <div class="text-center">
                                    <button type="submit"
                                        class="vs-btn w-100 mt-3    {{ ucfirst($event->status) === 'Pending' || \Carbon\Carbon::parse($event->date)->isPast() ? 'd-none' : '' }}"
                                        id="submitButton">
                                        <span id="buttonText">Buy Ticket</span>
                                        <div class="spinner-border text-primary ml-2 d-none" role="status"
                                            id="loadingSpinner">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div>
    </section>


    <script src="https://www.paypal.com/sdk/js?client-id={{ config('paypal.sandbox.client_id') }}&currency=USD"></script>

    <script>
        $(document).ready(function() {
            const ticketCards = $('.ticket-type-card');
            const quantityInput = $('#quantity');
            const totalPriceElement = $('#totalPrice');
            const submitButton = $('#submitButton');
            const stripeButton = $('#stripeButton');
            const paypalButton = $('#paypalButton');
            const loadingSpinner = $('#loadingSpinner');
            const paypalSection = $('#paypal-section');
            const stripeSection = $('#stripe-section');
            @if (session('paypal_session_message'))
                toastr.info("{{ session('paypal_session_message') }}", 'New Notification', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right', // Change position as needed
                    timeOut: 10000, // Display for 10 seconds
                    extendedTimeOut: 5000 // Additional time when hovering
                });
            @endif
            let stripe, card;
            // Function to update displayed user information
            function updateUserInfo() {
                const name = $('#name').val();
                const email = $('#email').val();
                const totalPrice = totalPriceElement.text();

                $('#display-name').text(name);
                $('#display-email').text(email);
                $('#display-total-price').text(totalPrice);
            }

            // Event listeners for input changes
            $('#name, #email, #totalPrice').on('input change', updateUserInfo);
            quantityInput.on('input', calculateTotalPrice);

            function initializeStripe() {
                stripe = Stripe('{{ config('services.stripe.key') }}');
                const elements = stripe.elements();
                card = elements.create('card');
                card.mount('#card-element');
            }

            stripeButton.click(function() {
                 paypalSection.addClass('d-none');
                stripeSection.removeClass('d-none');
                stripeSection.show();
                paypalSection.hide();
                $('#paymentMethod').val('stripe');
                stripeButton.addClass('active-method');
                paypalButton.removeClass('active-method');

                initializeStripe();
            });


            $('#paypalButton').on('click', function() {
                $(this).addClass('active-method');
                $('#stripeButton').removeClass('active-method');
                stripeSection.addClass('d-none');
                paypalSection.removeClass('d-none');
                $('#paymentMethod').val('paypal'); // Set payment method to PayPal


                stripeSection.hide();
                paypalSection.show();
                 
               
            });

            // Default to Stripe on load
            stripeButton.click(); // Set Stripe as default

            let selectedPrice = 0;

            ticketCards.on('click', function() {
                ticketCards.removeClass('border-primary');
                $(this).addClass('border-primary');
                $(this).find('input[type="radio"]').prop('checked', true);
                selectedPrice = parseFloat($(this).data('price'));
                calculateTotalPrice();
            });

            quantityInput.on('input', calculateTotalPrice);

            function calculateTotalPrice() {
                const quantity = parseInt(quantityInput.val()) || 0;
                const totalPrice = (quantity * selectedPrice).toFixed(2);
                totalPriceElement.text(`$${totalPrice}`);
            }
            // Handle form submission
            $('#ticketForm').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission


                const paymentMethod = $('#paymentMethod').val();

                submitButton.prop('disabled', true); // Disable button
                $('#buttonText').addClass('d-none'); // Hide button text
                loadingSpinner.removeClass('d-none'); // Show loading spinner

                // First AJAX call to get client_secret for Stripe payment
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'), // URL to your buy route
                    data: $(this).serialize(),
                    success: function(response) {
                        if (paymentMethod === 'stripe') {
                            const clientSecret = response.clientSecret;

                            $('#client-secret').val(clientSecret); // Store the client secret

                            // Confirm payment using Stripe.js with the received client_secret
                            stripe.confirmCardPayment(clientSecret, {
                                payment_method: {
                                    card: card,
                                    billing_details: {
                                        name: $('#name').val(),
                                        email: $('#email').val(),
                                        address: {
                                            line1: $('#address').val(),
                                        },
                                    },
                                },
                            }).then(function(result) {
                                if (result.error) {
                                    $('#card-errors').text(result.error.message);
                                } else {
                                    if (result.paymentIntent.status === 'succeeded') {
                                        finalizeTicketPurchase(paymentMethod,result.paymentIntent.id,
                                            '{{ $event->id }}', $(
                                                'input[name="ticket_type_id"]:checked'
                                                )
                                            .val(), $('#quantity').val());
                                    }
                                }
                            });
                        }else if(paymentMethod==='paypal'){
                            console.log(response);
                            const approvalUrl = response.approvalUrl;
                            window.location.href = approvalUrl; // Redirect to PayPal
                        }

                    },
                    error: function(xhr) {
                        $('.text-danger').remove(); // Remove previous error messages
                        $('#alertContainer').html(''); // Clear previous alert container

                        // Check for JSON response with an error
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            // Show the custom error message
                            const errorHtml =
                                `<div class="alert alert-danger">${xhr.responseJSON.error}</div>`;
                            $('#alertContainer').html(errorHtml);
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // If there are validation errors, show them for each field
                            $.each(xhr.responseJSON.errors, function(field, errors) {
                                const errorMessage = errors[0];
                                $(`[name="${field}"]`).closest('.form-group').append(
                                    `<span class="text-danger">${errorMessage}</span>`
                                );
                            });
                        } else {
                            // General error message for unknown errors
                            const errorHtml =
                                `<div class="alert alert-danger">An unknown error occurred.</div>`;
                            $('#alertContainer').html(errorHtml);
                        }
                    },
                    complete: function() {
                        submitButton.prop('disabled', false); // Enable button
                        $('#buttonText').removeClass('d-none'); // Show button text
                        loadingSpinner.addClass('d-none'); // Hide loading spinner
                    },
                });
            });

            function finalizeTicketPurchase(paymentMethod,paymentIntentId, eventId, ticketTypeId, quantity) {


                $.ajax({
                    url: '/finalize-purchase',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    data: JSON.stringify({paymentMethod,
                        paymentIntentId,
                        event_id: eventId,
                        ticket_type_id: ticketTypeId,
                        quantity
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        // Show the ticket confirmation modal
                        toastr.info(response.message, 'New Notification', {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-top-right', // You can change the position as needed
                            timeOut: 10000, // Display for 10 seconds
                            extendedTimeOut: 5000, // Additional time when hovering
                        });


                        $('#ticketForm')[0].reset();
                        $('#totalPrice').text('$0.00');
                        $('.ticket-type-card').removeClass('border-primary');
                        $('#card-element').remove(); // If you want to completely remove the card input

                    },
                    error: function() {
                        alert("Error in finalizing purchase.");
                    }
                });
            }
        });
    </script>
@endsection
