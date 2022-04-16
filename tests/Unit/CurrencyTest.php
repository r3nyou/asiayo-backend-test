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

    public function test_currency_bcround()
    {
        $forexRate = $this->getForexRate()['currencies'];
        $currency = new class($forexRate) extends Currency {
            public function publicBcround($num, $scale = 2)
            {
                return $this->bcround($num, $scale) ;
            }
        };

        $this->assertSame('0.00', $currency->publicBcround('0.004'));
        $this->assertSame('0.01', $currency->publicBcround('0.005'));
    }

    public function test_conversion_number_format()
    {
        $result = $this->currency
            ->amount('10000')
            ->from('USD')
            ->to('JPY')
            ->get();
        $this->assertSame('1,118,010.00', $result);
    }

    public function test_from_invalid_currency()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('from is invalid currency');

        $result = $this->currency
            ->amount('1')
            ->from('FOO')
            ->to('JPY')
            ->get();
        $this->assertSame('1', $result);
    }

    public function test_to_invalid_currency()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('to is invalid currency');

        $result = $this->currency
            ->amount('1')
            ->from('USD')
            ->to('FOO')
            ->get();
        $this->assertSame('1', $result);
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
