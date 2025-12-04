<?php

namespace App\Repositories;

interface StripePaymentRepositoryInterface
{
    public function createCharge(array $data);
}
