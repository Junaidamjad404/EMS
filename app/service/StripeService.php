<?php

namespace App\service;

use Exception;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;


class StripeService
{
    public function __construct()
    {
        // Set the Stripe API key from the configuration
        Stripe::setApiKey(config('services.stripe.secret'));
    }


    /**
     * Create a Payment Intent in Stripe
     *
     * @param int $amount Amount in cents
     * @param string $currency Currency code (e.g., "usd" or "pkr")
     * @param array $metadata Metadata to attach to the payment
     * @return \Stripe\PaymentIntent|null
     * @throws \Exception
     */
    public function createPaymentIntent($amount, $currency, $metadata = [])
    {
        try {
            // Log details for debugging purposes
            Log::info("Creating payment intent with amount: {$amount}, currency: {$currency}");

            return PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['card'],
                'metadata' => $metadata,
            ]);
        } catch (ApiErrorException $e) {
            // Log the specific error message for debugging
            Log::error("Stripe payment intent creation failed: " . $e->getMessage());

            // Optionally rethrow or return null
            throw new \Exception('Stripe payment intent creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Check if a payment was successful
     *
     * @param string $paymentIntentId
     * @return bool
     * @throws \Exception
     */
    public function isPaymentSuccessful($paymentIntentId)
    {
        try {
            Log::info("Retrieving payment intent for ID: $paymentIntentId");

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            Log::info("Payment intent retrieved successfully: ", $paymentIntent->toArray());
            
            return $paymentIntent->status === 'succeeded';
        } catch (Exception $e) {
            Log::error("Failed to retrieve payment intent: " . $e->getMessage());
            throw new Exception('Failed to retrieve payment intent: ' . $e->getMessage());
        }
    }
}