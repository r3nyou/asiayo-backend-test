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

    /**
     * amount 為小數點後 2 位
     * forex rate 為小數點後 5 位
     * 計算取到小數點後 7 位
     * @return string
     */
    public function get(): string
    {
        return number_format($this->bcround(bcmul(
            $this->amount,
            $this->forexRate[$this->from][$this->to],
            7
        )), 2);
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
