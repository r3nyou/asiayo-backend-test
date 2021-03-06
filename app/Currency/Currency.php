<?php

namespace App\Currency;

use App\Exceptions\CurrencyException;
use Exception;

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
     * amount 四捨五入到小數點後 2 位
     * forex rate 為小數點後 5 位
     * 轉換取到小數點後 7 位
     * @return string
     * @throws Exception
     */
    public function get(): string
    {
        $this->check();

        return number_format($this->bcround(bcmul(
            $this->bcround($this->amount),
            $this->forexRate[$this->from][$this->to],
            7
        )), 2);
    }

    protected function check(): void
    {
        $validCurrency = array_keys($this->forexRate);
        if (!in_array($this->from ?? '', $validCurrency)) {
            throw new CurrencyException('from is invalid currency');
        }
        if (!in_array($this->to ?? '', $validCurrency)) {
            throw new CurrencyException('to is invalid currency');
        }

        if (!($this->amount || $this->amount == 0)) {
            throw new CurrencyException('amount is not specified');
        }
        if (floatval($this->amount) < 0) {
            throw new CurrencyException('amount must be greater than or equal to 0');
        }
        if (!preg_match('/^[0]*[1-9]*[.]?[0-9]*$/', $this->amount)) {
            throw new CurrencyException('amount is not well-formed');
        }
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
