<?php

namespace App\Http\Controllers;

use App\Services\OpenWeatherMapService;

class AjaxController extends Controller
{
    public function getWeather($cityId)
    {
        $data = (new OpenWeatherMapService())->getByCityID($cityId);

        return response()->json($data);
    }
}
