<?php

namespace Tests\Unit;

use App\Currency\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function test_currency_construct_with_params()
    {
        $this->assertTrue(true);

        $forexRate = $this->getForexRate()['currencies'];
        $currency = new class($forexRate) extends Currency {
            public function getForexRate()
            {
                return $this->forexRate;
            }
        };

        $this->assertTrue($forexRate === $currency->getForexRate());
    }

    private function getForexRate(): array
    {
        return [
            'currencies' => [
                'TWD' => [
                    'TWD' => 1,
                    'JPY' => 3.669,
                    'USD' => 0.03281,
                ],
                'JPY' => [
                    'TWD' => 0.26956,
                    'JPY' => 1,
                    'USD' => 0.00885,
                ],
                'USD' => [
                    'TWD' => 30.444,
                    'JPY' => 111.801,
                    'USD' => 1,
                ],
            ],
        ];
    }
}
