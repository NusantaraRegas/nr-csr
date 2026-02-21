<?php

        Route::group(['prefix' => 'tasklistLegal', 'middleware' => 'isLegal'], function () {
            Route::get('/Legal', 'TasklistLegalController@tasklistLegal')->name('tasklist-legal');
            Route::get('approveBAST/{loginID}', 'TasklistLegalController@approveBAST');
        });


