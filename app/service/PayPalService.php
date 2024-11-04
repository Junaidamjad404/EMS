<?php

namespace App\service;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srmklive\PayPal\Exceptions\PayPalRequestException;
use Log;
use Exception;

class PayPalService
{
    protected $client;

    public function __construct()
    {
        $this->client = new PayPalClient;
        $this->client->setApiCredentials(config('paypal'));
    }

    /**
     * Create a PayPal order and get approval link.
     *
     * @param float $amount
     * @param string $currency
     * @param string $returnUrl
     * @param string $cancelUrl
     * @return array
     * @throws Exception
     */
    public function createOrder($amount, $currency = 'USD', $returnUrl, $cancelUrl,$eventId,$request)
    {
        try {
            Log::info('Access token response:', $this->client->getAccessToken());

            $this->client->setAccessToken($this->client->getAccessToken());
            
            $order = $this->client->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => $returnUrl,
                    "cancel_url" => $cancelUrl,
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => $currency,
                            "value" => number_format($amount, 2, '.', '')
                        ],
                        // Include custom metadata
                        "custom_id" => json_encode([
                            'ticket_type_id' => (int) $request['ticket_type_id'],
                            'event_id' => $eventId,
                            "paymentMethod"=>$request['payment_method'],
                            "quantity" => (int) $request['quantity']
                        ]),
                    ]
                ]
            ]); 
           
            Log::info('PayPal order created successfully', ['order' => $order]);
            return [
                'orderId' => $order['id'],
                'approvalUrl' => collect($order['links'])->where('rel', 'approve')->first()['href'],
            ];

        } catch (PayPalRequestException $e) {
            Log::error('PayPal API error: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Capture the payment for a PayPal order.
     *
     * @param string $orderId
     * @return array
     * @throws Exception
     */
    public function captureOrder($orderId)
    {
        try {
             Log::info('Access token response:', $this->client->getAccessToken());

            $this->client->setAccessToken($this->client->getAccessToken());
            
            $response = $this->client->capturePaymentOrder($orderId);

            Log::info('PayPal payment captured successfully', ['response' => $response]);
            return $response;

        } catch (PayPalRequestException $e) {
            Log::error('PayPal API error on capture: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error('An unexpected error occurred: ' . $e->getMessage());
            throw $e;
        }
    }
}

