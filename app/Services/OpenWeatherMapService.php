<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class OpenWeatherMapService
{
    protected $apiBaseUrl = 'http://api.openweathermap.org/data/2.5';
    protected $appId;

    public function __construct()
    {
        $this->appId = env('OPEN_WEATHER_MAP_APPID');
    }

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
