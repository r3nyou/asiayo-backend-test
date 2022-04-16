<?php

namespace Tests\Unit;

use App\Currency\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    private Currency $currency;

    protected function setUp(): void
    {
        $this->currency = new Currency($this->getForexRate()['currencies']);
    }

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
        $result = $this->currency
            ->amount('1')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('111.80', $result);
    }

    public function test_can_convert_from_format_integer()
    {
        $result = $this->currency
            ->amount('1.00')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('111.80', $result);
    }

    public function test_can_convert_from_float()
    {
        $result = $this->currency
            ->amount('0.1')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('11.18', $result);

        $result = $this->currency
            ->amount('0.01')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('1.12', $result);
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
