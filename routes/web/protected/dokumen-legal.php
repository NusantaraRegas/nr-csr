<?php

        Route::group(['prefix' => 'DokumenLegal', 'middleware' => 'isReport'], function () {            
            Route::post('storeBASTDana', 'BASTController@store')->name('storeBASTDana');
            Route::post('updateBASTDana', 'BASTController@update')->name('updateBASTDana');
            Route::delete('deleteBAST/{id}', 'BASTController@delete');

            Route::get('/ubah-BASTDana/{loginID}', 'BASTController@ubahBASTDana')->name('ubah-bast-dana');

            Route::get('/SPK/{loginID}', 'SPKController@inputSPK')->name('input-spk');
            Route::post('/insert-SPK', 'SPKController@insertSPK');
            Route::get('/ubah-SPK/{loginID}', 'SPKController@ubahSPK')->name('ubah-spk');
            Route::post('/edit-SPK', 'SPKController@editSPK');
            Route::post('/insert-Header', 'SPKController@insertHeader');
            Route::post('/insert-DetailSPK', 'SPKController@insertDetailSPK');
            Route::delete('/delete-SPK/{loginID}', 'SPKController@deleteSPK');
        });


