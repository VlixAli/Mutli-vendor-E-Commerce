<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apikey;

    protected $baseUrl = 'https://api.currencyapi.com/v3';

    /**
     * @param $apikey
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }

    public function convert( string $from, string $to, float $amount = 1)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'apikey' => $this->apikey
            ])
            ->get('/latest', [
                'base_currency' => $from,
                'currencies' => $to
            ]);

        $result = $response->json();
        return $result['data'][$to]['value'] * $amount;
    }
}
