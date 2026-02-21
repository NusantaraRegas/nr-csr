<?php

    //====================Form====================//
    Route::group(['prefix' => 'Form'], function () {
        Route::get('/Evaluasi/{loginID}', 'EvaluasiController@formEvaluasi')->name('form-evaluasi');
        Route::get('/Survei/{loginID}', 'SurveiController@formSurvei')->name('form-survei');
        Route::get('/SuratPenolakan/{loginID}', 'SurveiController@suratPenolakan')->name('surat-penolakan');

        Route::get('/BASTDana/{loginID}', 'BASTController@formBASTDana')->name('formBASTDana');
        Route::get('/BASTDana2/{loginID}', 'BASTController@formBASTDana2')->name('formBASTDana2');

        Route::get('/BASTIdulAdha/{loginID}', 'BASTController@formBASTIdulAdha')->name('formBASTIdulAdha');
        Route::get('/SPK/{loginID}', 'SPKController@formSPK')->name('form-SPK');
        Route::get('/Kwitansi/{loginID}', 'SurveiController@kwitansi')->name('kwitansi');
    });


