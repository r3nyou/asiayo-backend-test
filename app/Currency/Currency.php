<?php

namespace App\Currency;

class Currency
{
    protected array $forexRate;

    protected string $amount;

    protected string $from;

    protected string $to;

    public function __construct(array $forexRate)
    {
        $this->forexRate = $forexRate;
    }

    public function get(): string
    {
        return bcmul(
            $this->amount,
            $this->forexRate[$this->from][$this->to],
            2
        );
    }

    public function amount(string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    public function from(string $from): static
    {
        $this->from = $from;
        return $this;
    }

    public function to(string $to): static
    {
        $this->to = $to;
        return $this;
    }
}
