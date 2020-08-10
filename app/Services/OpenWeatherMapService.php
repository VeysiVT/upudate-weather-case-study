<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class OpenWeatherMapService
{
    protected $apiBaseUrl = 'http://api.openweathermap.org/data/2.5';
    protected $appId = '62556cb094f086b5396c6f306f8b24aa';

    public function getByCityID($id)
    {
        $uri = '/weather';

        $response = Http::get($this->apiBaseUrl . $uri, [
            'id' => $id,
            'appid' => $this->appId,
            'lang' => 'en',
            'units' => 'metric',
        ]);

        return $response->json();
    }
}
