<?php

        Route::group(['prefix' => 'operasional', 'middleware' => 'isUser'], function () {
            Route::get('createOperasional', 'KelayakanController@createOperasional')->name('createOperasional');
             Route::post('storeOperasional', 'KelayakanController@storeOperasional')->name('storeOperasional');
        
        });


