<?php

        Route::group(['prefix' => 'profile', 'middleware' => 'isUser'], function () {
            Route::get('account-setting/{loginID}', 'UserController@profile')->name('profile');
            Route::post('/update-profile', 'UserController@editProfile');
            Route::post('/update-password', 'UserController@editPassword');
            Route::delete('/delete-foto/{loginID}', 'UserController@deleteFotoProfile')->name('delete-foto');
        });


