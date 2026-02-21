<?php

        Route::group(['prefix' => 'subsidiary'], function () {
            Route::group(['prefix' => 'dashboard'], function () {
                Route::get('/', 'DashboardSubsidiaryController@index')->name('dashboardSubsidiary');
                Route::post('postDashboardSubsidiaryBudgetYear', 'DashboardSubsidiaryController@postBudgetYear');
                Route::get('/indexYear/{year}/{company}', 'DashboardSubsidiaryController@indexYear')->name('dashboardSubsidiaryYear');
            });

            Route::group(['prefix' => 'master', 'middleware' => 'isSubsidiary'], function () {
                Route::get('/indexStakeholder', 'StakeholderSubsidiaryController@index')->name('indexStakeholderSubsidiary');
                Route::post('createStakeholder', 'StakeholderSubsidiaryController@store');
                Route::post('updateStakeholder', "StakeholderSubsidiaryController@update");
                Route::delete('deleteStakeholder/{stakeholderID}', "StakeholderSubsidiaryController@delete");

                Route::get('/indexLembaga', 'LembagaSubsidiaryController@index')->name('indexLembagaSubsidiary');
                Route::post('createLembaga', 'LembagaSubsidiaryController@store');
                Route::post('updateLembaga', "LembagaSubsidiaryController@update");
                Route::delete('deleteLembaga/{lembagaID}', "LembagaSubsidiaryController@delete");
            });

            Route::group(['prefix' => 'anggaran', 'middleware' => 'isSubsidiary'], function () {
                Route::get('/index', 'AnggaranSubsidiaryController@index')->name('indexBudgetSubsidiary');
                Route::get('/indexProker', 'AnggaranSubsidiaryController@indexProker')->name('indexProkerSubsidiary');
                Route::post('postProkerYear', 'AnggaranSubsidiaryController@postProkerYear');
                Route::get('/indexProkerYear/{year}', 'AnggaranSubsidiaryController@indexProkerYear')->name('indexProkerSubsidiaryYear');
                Route::post('storeProker', 'AnggaranSubsidiaryController@storeProker');
                Route::post('updateProker', 'AnggaranSubsidiaryController@updateProker');
                Route::get('printProker/{year}/{company}', 'AnggaranSubsidiaryController@printProker')->name('printProkerSubsidiary');
                Route::get('exportProker/{year}/{company}', 'AnggaranSubsidiaryController@exportProker')->name('exportProkerSubsidiary');
            });

            Route::group(['prefix' => 'relokasi', 'middleware' => 'isSubsidiary'], function () {
                Route::get('indexRelokasiSubsidiary', 'RelokasiSubsidiaryController@index')->name('indexRelokasiSubsidiary');
                Route::get('createRelokasiSubsidiary', 'RelokasiSubsidiaryController@create')->name('createRelokasiSubsidiary');
                Route::post('storeRelokasiSubsidiary', 'RelokasiSubsidiaryController@store');
            });

            Route::group(['prefix' => 'realisasi', 'middleware' => 'isSubsidiary'], function () {
                Route::get('sisaAnggaran/{prokerID}', "RealisasiSubsidiaryController@sisaAnggaran");

                Route::get('createProposal', 'RealisasiSubsidiaryController@createProposal')->name('createProposalSubsidiary');

                Route::get('editProposal/{realisasiID}', 'RealisasiSubsidiaryController@editProposal')->name('editProposalSubsidiary');
                Route::get('editNonProposal/{realisasiID}', 'RealisasiSubsidiaryController@editNonProposal')->name('editNonProposalSubsidiary');

                Route::post('updateRealisasiProposal', 'RealisasiSubsidiaryController@updateProposal');
                Route::post('updateRealisasiNonProposal', 'RealisasiSubsidiaryController@updateNonProposal');


                Route::get('createNonProposal', 'RealisasiSubsidiaryController@createNonProposal')->name('createNonProposalSubsidiary');
                Route::get('editNonProposal/{realisasiID}', 'RealisasiSubsidiaryController@editNonProposal')->name('editNonProposalSubsidiary');

                Route::post('storeRealisasiProposal', 'RealisasiSubsidiaryController@storeProposal');
                Route::post('storeRealisasiNonProposal', 'RealisasiSubsidiaryController@storeNonProposal');

                Route::delete('deleteRealisasi/{realisasiID}', 'RealisasiSubsidiaryController@delete');
            });

            Route::group(['prefix' => 'report', 'middleware' => 'isSubsidiary'], function () {
                Route::get('indexRealisasiSubsidiary', 'ReportSubsidiaryController@index')->name('indexRealisasiSubsidiary');
                Route::get('viewDetailRealisasiSubsidiary/{realisasiID}', 'ReportSubsidiaryController@view')->name('viewDetailRealisasiSubsidiary');
                Route::get('exportRealisasiProposal/{year}/{company}', 'ReportSubsidiaryController@exportRealisasiProposal')->name('exportRealisasiProposalSubsidiary');
                Route::get('printRealisasiProposal/{year}/{company}', 'ReportSubsidiaryController@printRealisasiProposal')->name('printRealisasiProposalSubsidiary');

                Route::post('postRealisasiSubsidiaryAnnual', 'ReportSubsidiaryController@postRealisasiSubsidiaryAnnual');
                Route::get('indexRealisasiSubsidiaryAnnual/{year}', 'ReportSubsidiaryController@indexAnnual')->name('indexRealisasiSubsidiaryAnnual');

                Route::post('postRealisasiSubsidiaryMonthly', 'ReportSubsidiaryController@postRealisasiSubsidiaryMonthly');
                Route::get('indexRealisasiSubsidiaryMonthly/{bulan1}/{bulan2}/{year}', 'ReportSubsidiaryController@indexMonthly')->name('indexRealisasiSubsidiaryMonthly');
                Route::get('exportRealisasiMonthlySubsidiary/{bulan1}/{bulan2}/{year}', 'ReportSubsidiaryController@exportRealisasiMonthlySubsidiary')->name('exportRealisasiMonthlySubsidiary');
                Route::get('printRealisasiMonthlySubsidiary/{bulan1}/{bulan2}/{year}', 'ReportSubsidiaryController@printRealisasiMonthlySubsidiary')->name('printRealisasiMonthlySubsidiary');

                Route::post('postRealisasiSubsidiaryPeriode', 'ReportSubsidiaryController@postRealisasiSubsidiaryPeriode');
                Route::get('indexRealisasiSubsidiaryPeriode/{tanggal1}/{tanggal2}', 'ReportSubsidiaryController@indexPeriode')->name('indexRealisasiSubsidiaryPeriode');
                Route::get('exportRealisasiPeriodeSubsidiary/{tanggal1}/{tanggal2}/{year}', 'ReportSubsidiaryController@exportRealisasiPeriodeSubsidiary')->name('exportRealisasiPeriodeSubsidiary');
                Route::get('printRealisasiPeriodeSubsidiary/{tanggal1}/{tanggal2}', 'ReportSubsidiaryController@printRealisasiPeriodeSubsidiary')->name('printRealisasiPeriodeSubsidiary');

                Route::post('postRealisasiSubsidiaryRegion', 'ReportSubsidiaryController@postRealisasiSubsidiaryRegion');
                Route::get('indexRealisasiSubsidiaryRegion/{provinsi}/{kabupaten}/{year}', 'ReportSubsidiaryController@indexRegion')->name('indexRealisasiSubsidiaryRegion');
                Route::get('exportRealisasiRegionSubsidiary/{provinsi}/{kabupaten}/{year}', 'ReportSubsidiaryController@exportRealisasiRegionSubsidiary')->name('exportRealisasiRegionSubsidiary');
                Route::get('printRealisasiRegionSubsidiary/{provinsi}/{kabupaten}/{year}', 'ReportSubsidiaryController@printRealisasiRegionSubsidiary')->name('printRealisasiRegionSubsidiary');

                Route::post('postRealisasiSubsidiarySDGs', 'ReportSubsidiaryController@postRealisasiSubsidiarySDGs');
                Route::get('indexRealisasiSubsidiarySDGs/{pilar}/{gols}/{year}', 'ReportSubsidiaryController@indexSDGs')->name('indexRealisasiSubsidiarySDGs');
                Route::get('exportRealisasiSDGsSubsidiary/{pilar}/{gols}/{year}', 'ReportSubsidiaryController@exportRealisasiSDGsSubsidiary')->name('exportRealisasiSDGsSubsidiary');
                Route::get('printRealisasiSDGsSubsidiary/{pilar}/{gols}/{year}', 'ReportSubsidiaryController@printRealisasiSDGsSubsidiary')->name('printRealisasiSDGsSubsidiary');

                Route::post('postRealisasiSubsidiaryPriority', 'ReportSubsidiaryController@postRealisasiSubsidiaryPriority');
                Route::get('indexRealisasiSubsidiaryPriority/{prioritas}/{year}', 'ReportSubsidiaryController@indexPriority')->name('indexRealisasiSubsidiaryPriority');
                Route::get('exportRealisasiPrioritySubsidiary/{prioritas}/{year}', 'ReportSubsidiaryController@exportRealisasiPrioritySubsidiary')->name('exportRealisasiPrioritySubsidiary');
                Route::get('printRealisasiPrioritySubsidiary/{prioritas}/{year}', 'ReportSubsidiaryController@printRealisasiPrioritySubsidiary')->name('printRealisasiPrioritySubsidiary');

                Route::get('indexRealisasiSubsidiaryProker/{prokerID}', 'ReportSubsidiaryController@indexProkerID')->name('indexRealisasiSubsidiaryProker');
                Route::get('exportRealisasiProkerSubsidiary/{prokerID}', 'ReportSubsidiaryController@exportRealisasiProkerSubsidiary')->name('exportRealisasiProkerSubsidiary');
                Route::get('printRealisasiProkerSubsidiary/{prokerID}', 'ReportSubsidiaryController@printRealisasiProkerSubsidiary')->name('printRealisasiProkerSubsidiary');

                Route::get('indexRealisasiProkerSubsidiary', 'ReportSubsidiaryController@indexProker')->name('indexRealisasiProkerSubsidiary');

                Route::post('postRealisasiProkerAnnualSubsidiary', 'ReportSubsidiaryController@postRealisasiProkerAnnualSubsidiary');
                Route::get('indexRealisasiProkerAnnualSubsidiary/{company}/{year}', 'ReportSubsidiaryController@indexProkerAnnual')->name('indexRealisasiProkerAnnualSubsidiary');
                Route::get('exportRealisasiProkerAnnualSubsidiary/{year}', 'ReportSubsidiaryController@exportRealisasiProkerAnnualSubsidiary')->name('exportRealisasiProkerAnnualSubsidiary');
                Route::get('printRealisasiProkerAnnualSubsidiary/{year}', 'ReportSubsidiaryController@printRealisasiProkerAnnualSubsidiary')->name('printRealisasiProkerAnnualSubsidiary');
            });

        });


