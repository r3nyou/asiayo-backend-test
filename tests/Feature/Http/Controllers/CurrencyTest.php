<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_make_an_api_request()
    {
        $query = [
            'amount' => '1',
            'from' => 'USD',
            'to' => 'USD',
        ];
        $response = $this->get(
            '/api/currency-converter?' . Arr::query($query)
        );

        $response->assertStatus(200);
        $response->assertJson([
            'from' => 'USD',
            'to' => 'USD',
            'amount' => '1',
            'result' => '1',
        ]);
    }
}
