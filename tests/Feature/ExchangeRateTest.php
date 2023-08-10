<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ExchangeRateTest extends TestCase
{

    public function testExchangeRates()
    {
        $response = $this->get('/api/convert?source=USD&target=JPY&amount=$170496.53');

        $response->assertStatus(200)
            ->assertJson([
                'msg' => 'success',
            ])
            ->assertJsonStructure([
                'msg',
                'amount',
            ]);

        $arr = json_decode($response->getContent());
        assertEquals($arr->amount, '$19,061,682.55');
    }

    public function testError()
    {
        $response = $this->get('/api/convert?source=ABC&target=XYZ&amount=invalid');

        $response->assertStatus(400);
    }
}
