<?php

namespace App\Billing;

class FakePaymentGateway implements PaymentGateway
{
    private $charges;
    private $beforeFirstCharge;

    public function __construct()
    {
        $this->charges = collect();
    }

    public function beforeFirstCharge($callback)
    {
        $this->beforeFirstCharge = $callback;
    }

    public function getValidTestToken()
    {
        return 'test-token';   
    }

    public function charge(int $amount, String $token) : void
    {
        if ($this->beforeFirstCharge) {
            $callback = $this->beforeFirstCharge;
            $this->beforeFirstCharge = null;
            $callback($this);
        }

        if ($token !== $this->getValidTestToken()) {
            throw new PaymentFailedException;
        }
        $this->charges->push($amount);
    }

    public function totalCharges()
    {
        return $this->charges->sum();
    }

}