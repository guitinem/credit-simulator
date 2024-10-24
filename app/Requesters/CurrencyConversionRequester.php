<?php

namespace App\Requesters;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class CurrencyConversionRequester
{
    protected $apiUrl = 'https://api.currencylayer.com';

    /**
     * Get the converted value based on the currency
     * @param mixed $toCurrency
     * @param mixed $amount
     * @return null | string | float
     */
    public function getConversionRate($toCurrency, $amount): null | string | float
    {
        $url = $this->apiUrl . '/convert';
        $apiKey = env('API_KEY');

        try {
            $response = Http::withQueryParameters([
                'access_key' => $apiKey,
                'from' => 'BRL',
                'to' => $toCurrency,
                'amount' => $amount
            ])->get($url);

            if ($response->ok()) {
                $data = $response->object();

                if ($data->success) {
                    return $data->result;
                }

                return $data->error->info ?? 'Unknown error occurred';
            }

            return null;
        } catch (\Throwable $th) {
            Log::error('Error to convert currency: ', ['error' => $th->getMessage()]);
            return null;
        }
    }
}
