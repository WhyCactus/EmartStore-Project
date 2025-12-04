<?php

namespace App\Repositories;

use Exception;
use Stripe\Charge;
use Stripe\Stripe;

class StripePaymentRepository implements StripePaymentRepositoryInterface
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createCharge(array $data)
    {
        try {
            return Charge::create([
                'amount'=> $data['amount'],
                'currency'=> $data['currency'],
                'source'=> $data['source'],
                'description'=> $data['description'] ?? 'Charge for order payment',
                'metadata'=> $data['metadata'] ?? [],
            ]);
        } catch (Exception $e) {
            throw new Exception('Stripe Charge Error: ' . $e->getMessage());
        }
    }
}
