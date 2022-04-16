<?php

namespace App\Currency;

class Currency
{
    protected array $forexRate;

    public function __construct(array $forexRate)
    {
        $this->forexRate = $forexRate;
    }
}
