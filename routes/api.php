<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/weather', function () {
    //358ddc80063dc1458a6c3aa26348d852
    $apiKey = config('services.weatherApp.key');
    $lat =request('lat') ;
    $lon = request('lon');
    $response = Http::get("http://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey&units=metric");
    return $response->json();
});


Route::get('/dailyweather', function () {
    //OpenWethearApp Appi Key 358ddc80063dc1458a6c3aa26348d852

    $apiKey = config('services.weatherApp.key');
    $lat =request('lat') ;
    $lon = request('lon');
    $response = Http::get("http://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lon&exclude={hourly,daily}&appid=$apiKey&units=metric");
    return $response->json();

});

Route::get('/time',function(){

    $apiKey="1HRYXTJM92ME";
    $lat= request('lat');
    $lon= request('lon');

    $response = Http::get("http://api.timezonedb.com/v2.1/get-time-zone?key=1HRYXTJM92ME&format=json&by=position&lat=$lat&lng=$lon");

    return $response->json();
});
