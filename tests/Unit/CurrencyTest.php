<?php

namespace Tests\Unit;

use App\Currency\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function test_currency_construct_with_params()
    {
        $forexRate = $this->getForexRate()['currencies'];
        $currency = new class($forexRate) extends Currency {
            public function getForexRate()
            {
                return $this->forexRate;
            }
        };

        $this->assertTrue($forexRate === $currency->getForexRate());
    }

    public function test_can_convert_from_integer()
    {
        $forexRate = $this->getForexRate()['currencies'];
        $result = (new Currency($forexRate))
            ->amount('1')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('111.80', $result);
    }

    public function test_can_convert_from_format_integer()
    {
        $forexRate = $this->getForexRate()['currencies'];
        $result = (new Currency($forexRate))
            ->amount('1.00')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('111.80', $result);
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
