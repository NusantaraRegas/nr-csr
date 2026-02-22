<?php

Route::get('dataProvinsi', 'WilayahController@getProvinsi');
Route::get('dataKabupaten/{prov}', 'WilayahController@getKabupaten');
Route::post('dataKecamatan', 'WilayahController@getKecamatan');
Route::post('dataKelurahan', 'WilayahController@getKelurahan');
Route::post('dataKodePos', 'WilayahController@getKodePos');
