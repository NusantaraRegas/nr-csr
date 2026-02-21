<?php

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
            Route::post('postDashboardAnnual', 'DashboardController@postAnnual');
            Route::get('dashboardAnnual/{year}', 'DashboardController@indexAnnual')->name('dashboardAnnual');
            Route::post('postDashboardSubsidiary', 'DashboardController@postSubsidiary');
            Route::get('dashboardSubsidiaryAnnual/{year}/{company}', 'DashboardController@indexSubsidiaryAnnual')->name('dashboardSubsidiaryAnnual');

            Route::get('/dashboard/{tahunAnggaran}', 'DashboardController@tahun')->name('dashboard-tahun');
            Route::post('/input-Periode', 'DashboardController@inputPeriode');
            Route::get('/dashboard-Periode/{awal}/{akhir}', 'DashboardController@dashboardPeriode')->name('dashboard-Periode');

            Route::get('dashboardProposal', 'DashboardProposalController@index')->name('dashboardProposal');
            Route::get('dashboardProposalTahun/{tahun}', 'DashboardProposalController@indexTahun')->name('dashboardProposalTahun');
        });


