<?php

        Route::group(['prefix' => 'todo', 'middleware' => 'isReport'], function () {
            Route::get('', 'TasklistController@todo')->name('todolist');
        });


