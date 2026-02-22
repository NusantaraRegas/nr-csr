<?php

Route::get('health', 'HealthController@show');
Route::get('health/dependencies', 'HealthController@dependencies')->middleware('health.token');
