<?php

use Illuminate\Http\Request;

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

Route::get('dataProvinsi', "WilayahController@getProvinsi");
Route::get('dataKabupaten/{prov}', "WilayahController@getKabupaten");
Route::post('dataKecamatan', "WilayahController@getKecamatan");
Route::post('dataKelurahan', "WilayahController@getKelurahan");
Route::post('dataKodePos', "WilayahController@getKodePos");

Route::get('dataReceiver', 'APIController@dataReceiver');
Route::post('updateStatus', 'APIController@updateStatus');

Route::get('health', 'HealthController@show');
Route::get('health/dependencies', 'HealthController@dependencies')->middleware('health.token');
