<?php

        Route::group(['prefix' => 'proposal', 'middleware' => 'isUser'], function () {
            Route::get('createProposal', 'KelayakanController@create')->name('createProposal');
        
            Route::get('dataSubProposal/{loginID}', 'SubProposalController@index')->name('dataSubProposal');
            Route::get('inputSubProposal/{loginID}', 'SubProposalController@input')->name('inputSubProposal');
            Route::get('ubahSubProposal/{loginID}', 'SubProposalController@ubah')->name('ubahSubProposal');
            Route::post('storeSubProposal', 'SubProposalController@store');
            Route::post('editSubProposal', "SubProposalController@update");
            Route::delete('deleteSubProposal/{loginID}', "SubProposalController@delete");
            Route::get('exportSubProposal/{loginID}', "SubProposalController@export")->name('exportSubProposal');

            Route::get('indexLembaga', 'LembagaController@index')->name('dataLembaga');
            Route::get('createLembaga', 'LembagaController@input')->name('inputLembaga');
            Route::get('editLembaga/{lembagaID}', 'LembagaController@ubah')->name('ubahLembaga');
            Route::post('storeLembaga', 'LembagaController@store');
            Route::post('updateLembaga', "LembagaController@update");
            Route::post('updateInformasiBank', "LembagaController@updateBank");
            Route::delete('deleteLembaga/{lembagaID}', "LembagaController@delete");

            Route::get('/proposalBulanan', 'KelayakanController@inputKelayakan')->name('input-kelayakan');

            Route::get('/proposalSantunan', 'KelayakanController@proposalSantunan')->name('proposalSantunan');
            Route::get('/proposalIdulAdha', 'KelayakanController@proposalIdulAdha')->name('proposalIdulAdha');
            Route::get('/proposalNatal', 'KelayakanController@proposalNatal')->name('proposalNatal');
            Route::get('/proposalAspirasi', 'KelayakanController@proposalAspirasi')->name('proposalAspirasi');

            Route::post('/storeProposal', 'KelayakanController@store')->name('storeProposal');
            Route::post('/storeSantunan', 'KelayakanController@insertSantunan');
            Route::get('/ubahProposal/{loginID}', "KelayakanController@ubahProposal")->name('ubahProposal');
            Route::post('editkelayakan', "KelayakanController@editKelayakan");
            
            Route::get('data-kabupaten/{provinsi}', "KelayakanController@dataKabupaten")->name('data-kabupaten');
            Route::get('data-kecamatan/{provinsi}/{kabupaten}', "KelayakanController@dataKecamatan")->name('data-kecamatan');
            Route::get('data-kelurahan/{provinsi}/{kabupaten}/{kecamatan}', "KelayakanController@dataKelurahan")->name('data-kelurahan');

            Route::get('data-kabupatenPencarian/{loginID}', "KelayakanController@dataKabupatenPencarian")->name('data-kabupatenPencarian');
            Route::get('dataTPB/{pilar}', "KelayakanController@dataTPB");
            Route::get('dataIndikator/{tpb}', "KelayakanController@dataIndikator");

            Route::post('storeDokumen', "LampiranController@store")->name('storeDokumen');
            Route::post('updateDokumen', "LampiranController@update")->name('updateDokumen');
            Route::delete('deleteDokumen/{id}', "LampiranController@delete");

            Route::post('storeDokumentasi', "LampiranController@storeDokumentasi")->name('storeDokumentasi');

            Route::get('/input-Evaluasi/{loginID}', 'EvaluasiController@inputEvaluasi')->name('input-evaluasi');
            Route::post('/input-evaluasi', 'EvaluasiController@insertEvaluasi');
            Route::post('storeEvaluasi', 'KelayakanController@storeEvaluasi')->name('storeEvaluasi');
            Route::post('updateEvaluasi', 'KelayakanController@updateEvaluasi')->name('updateEvaluasi');
            Route::get('/edit-Evaluasi/{loginID}', "EvaluasiController@ubahEvaluasi")->name('edit-evaluasi');
            Route::post('edit-Evaluasi', "EvaluasiController@editEvaluasi");
            Route::post('edit-kadepEvaluasi', "EvaluasiController@editkadepEvaluasi");
            Route::post('edit-kadepSurvei', "SurveiController@editkadepSurvei");

            Route::post('edit-Tanggal1', "EvaluasiController@editTanggal1");
            Route::post('edit-Tanggal2', "EvaluasiController@editTanggal2");
            Route::post('edit-Tanggal3', "EvaluasiController@editTanggal3");
            Route::post('edit-Tanggal4', "EvaluasiController@editTanggal4");

            Route::post('edit-Tanggal5', "SurveiController@editTanggal1");
            Route::post('edit-Tanggal6', "SurveiController@editTanggal2");
            Route::post('edit-Tanggal7', "SurveiController@editTanggal3");
            Route::post('edit-Tanggal8', "SurveiController@editTanggal4");

            Route::get('/input-Survei/{loginID}', 'SurveiController@inputSurvei')->name('input-survei');
            Route::post('storeSurvei', 'SurveiController@store')->name('storeSurvei');
            Route::get('/edit-Survei/{loginID}', "SurveiController@ubahSurvei")->name('edit-survei');
            Route::post('updateSurvei', "SurveiController@update")->name('updateSurvei');
            Route::post('updateTermin', "SurveiController@updateTermin")->name('updateTermin');

            Route::get('ubahBank/{loginID}', "KelayakanController@ubahBank")->name('ubahBank');
            Route::post('editBank', "KelayakanController@editBank");
        });


