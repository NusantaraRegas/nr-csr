<?php

        Route::group(['prefix' => 'payment', 'middleware' => 'isUser'], function () {
            Route::post('storePembayaran', 'PembayaranController@store')->name('storePembayaran');
            Route::post('updatePembayaran', 'PembayaranController@update')->name('updatePembayaran');
            Route::delete('deletePembayaran/{id}', 'PembayaranController@delete')->name('deletePembayaran');
        });


