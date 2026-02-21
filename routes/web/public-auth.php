<?php

    //====================LOGIN====================//
    Route::get('/', 'LoginController@auth')->name('auth');
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/login', 'LoginController@index')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/forgot-password', 'LoginController@forgot')->name('forgot');
        Route::post('/forgot-password', 'LoginController@checkEmail');
        Route::get('update-password/{email}/{token}', 'LoginController@perbaruiPassword')->name('update-password');
        Route::post('reset-password', 'LoginController@updatePassword');
        Route::post('editPassword', 'LoginController@editPassword')->name('editPassword');

        Route::get('/otp', 'LoginController@showOtp')->name('showOtp');
        Route::post('/otp', 'LoginController@verifyOtp')->name('verifyOtp');;
        Route::get('/resend-otp', 'LoginController@resendOtp')->name('resend-otp');
    });


