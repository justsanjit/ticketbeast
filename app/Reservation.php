<?php

namespace App;

class Reservation
{
    private $tickets;
    private $email;

    public function __construct($tickets, $email)
    {
        $this->tickets = $tickets;
        $this->email = $email;
    }

    public function totalCharges()
    {
        return $this->tickets->sum('price');
    }

    public function cancel()
    {
        foreach ($this->tickets as $ticket) {
            $ticket->release();
        }
    }

    public function complete()
    {
        return Order::forTickets($this->tickets(), $this->email(), $this->totalCharges());
    }

    public function tickets()
    {
        return $this->tickets;
    }

    public function email()
    {
        return $this->email;
    }
}