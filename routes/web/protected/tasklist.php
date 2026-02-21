<?php

        Route::group(['prefix' => 'tasklist', 'middleware' => 'isReport'], function () {
            Route::get('', 'TasklistController@index')->name('tasklist');
            Route::get('TaskSurvei', 'TasklistSurveiController@index')->name('tasklistSurvei');
            Route::get('/Evaluasi', 'TasklistController@tasklistEvaluasi')->name('tasklistEvaluasi');
            Route::get('/approveEvaluator/{evaluasiID}/{catatan}', "TasklistController@approveEvaluator");
            Route::get('/approveKadep/{evaluasiID}/{catatan}/{status}', "TasklistController@approveKadep");
            Route::get('/approveKadiv/{evaluasiID}/{catatan}/{status}', "TasklistController@approveKadiv");

            Route::get('/Survei', 'TasklistSurveiController@tasklistSurvei')->name('tasklist-survei');
            Route::get('/approveSurvei/{loginID}', "TasklistSurveiController@approveSurvei");
            Route::post('/approve-kadep-survei', "TasklistSurveiController@approveKadep");
            Route::post('/approve-kadiv-survei', "TasklistSurveiController@approveKadiv");
            Route::get('/approve-all-kadep-survei/{surveiID}', "TasklistSurveiController@approveAllKadep");
            Route::get('/approveAllKadivSurvei/{surveiID}', "TasklistSurveiController@approveAllKadiv");

            Route::get('reviewSurvei', 'TasklistSurveiController@reviewSurvei')->name('reviewSurvei');
            Route::post('reviewSurvei', 'TasklistSurveiController@review');

            Route::get('/export-Proposal', "LaporanController@index")->name('export-proposal');
            Route::post('/post-Periode', 'LaporanController@cariPeriode');
            Route::get('/export-All/{tanggal1}/{tanggal2}', 'LaporanController@exportAll')->name('export-all');

            Route::get('/export-Realisasi', "LaporanController@indexRealisasi")->name('export-realisasi');
            Route::post('/post-PeriodeRealisasi', 'LaporanController@cariPeriodeRealisasi');
            Route::get('/export-Realisasi/{eb}/{tahun}', 'LaporanController@exportRealisasi')->name('export-all-realisasi');
        });


