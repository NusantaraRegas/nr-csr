<?php

        Route::group(['prefix' => 'anggaran', 'middleware' => 'isFinance'], function () {
            Route::get('indexBudget', 'AnggaranController@index')->name('indexBudget');
            Route::post('storeAnggaran', 'AnggaranController@store')->name('storeAnggaran');
            Route::post('updateAnggaran', "AnggaranController@update")->name('updateAnggaran');
            Route::delete('deleteAnggaran/{id}', "AnggaranController@delete")->name('deleteAnggaran');

            Route::get('/dataProker', 'ProkerController@index')->name('data-proker');
            Route::get('inputProker', 'ProkerController@create')->name('tambahProker');
            Route::post('inputProker', 'ProkerController@store');
            Route::post('editProker', "ProkerController@update");
            Route::delete('deleteProker/{loginID}', "ProkerController@delete")->name('delete-proker');

            Route::get('exportProker', "ProkerController@exportProker")->name('exportProker');
            
            Route::post('filterCompany', 'AnggaranController@cariPerusahaan');
            Route::get('indexCompany/{year}/{company}', "AnggaranController@indexPerusahaan")->name('indexCompany');
            Route::get('printRealisasi/{year}', "AnggaranController@printRealisasi")->name('printRealisasiProker');
            Route::get('monitoring', "AnggaranController@monitoring")->name('monitoringBudget');
            Route::post('postMonitoringAnnual', 'AnggaranController@postMonitoringAnnual');
            Route::get('monitoringAnnual/{year}', "AnggaranController@monitoringAnnual")->name('monitoringBudgetAnnual');

            Route::post('postMonitoringAnnualMonthly', 'AnggaranController@postMonitoringMonthly');
            Route::get('monitoringMonthly/{tanggal1}/{tanggal2}', "AnggaranController@monitoringMonthly")->name('monitoringBudgetMonthly');

            
            Route::get('dataGols/{pilar}', "ProkerController@dataGols")->name('dataGols');
            Route::get('dataGolsPencarian/{pilar}', "ProkerController@dataGolsPencarian")->name('dataGolsPencarian');
            Route::post('filterProker', 'ProkerController@cariPerusahaan');
            Route::get('indexPerusahaan/{year}/{company}', "ProkerController@indexPerusahaan")->name('indexProkerPerusahaan');
            Route::get('printProker/{year}', "ProkerController@printProker")->name('printProker');
            Route::get('sisaAnggaran/{prokerID}', "ProkerController@sisaAnggaran");

            Route::get('data-program/{loginID}/{tahun}', "ProkerController@dataProker")->name('data-program');

            Route::post('input-relokasi', 'AnggaranController@insertRelokasi');
            Route::post('input-alokasi', 'AnggaranController@insertAlokasi');
            Route::delete('delete-alokasi/{loginID}', "AnggaranController@deleteAlokasi")->name('delete-alokasi');
            Route::post('edit-alokasi', "AnggaranController@editAlokasi");
            Route::post('edit-nominal', "AnggaranController@editNominal");

            Route::get('indexRelokasi', 'RelokasiController@index')->name('indexRelokasi');
            Route::get('createRelokasi', 'RelokasiController@create')->name('createRelokasi');
            Route::post('storeRelokasi', 'RelokasiController@store');
            Route::delete('deleteRelokasi/{relokasiID}', "RelokasiController@delete");
        });


