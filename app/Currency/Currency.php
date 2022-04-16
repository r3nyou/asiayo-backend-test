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
        return $this->bcround(bcmul(
            $this->amount,
            $this->forexRate[$this->from][$this->to],
            2
        ));
    }

    protected function bcround(string $num, int $scale = 2): string
    {
        $fix = str_pad('5', $scale + 1, '0', STR_PAD_LEFT);
        $num = bcadd($num, "0.{$fix}", $scale + 1);

        return bcmul($num, '1', $scale);
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
