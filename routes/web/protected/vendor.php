<?php

        Route::group(['prefix' => 'vendor'], function () {
            Route::get('dashboard', 'DashboardVendorController@index')->name('dashboardVendor');
            Route::get('createProfilePerusahaan', 'VendorController@createProfile')->name('createProfilePerusahaan');
            Route::post('storeProfilePerusahaan', 'VendorController@store');
            Route::post('updateProfilePerusahaan', "VendorController@update");

            Route::get('detailVendorProfile/{vendorID}', 'VendorController@view')->name('detailVendor');
            Route::get('dataVendorRegister', 'VendorController@indexRegister')->name('dataVendorRegister');
            Route::get('dataVendorRejected', 'VendorController@indexRejected')->name('dataVendorRejected');
            Route::get('dataVendorProgress', 'VendorController@indexProgress')->name('dataVendorProgress');
            Route::get('dataVendorVerified', 'VendorController@indexVerified')->name('dataVendorVerified');
            Route::get('dataVendorBlackList', 'VendorController@indexBlackList')->name('dataVendorBlackList');
            Route::get('detailVendorMIB/{vendorID}', 'VendorController@viewMIB')->name('detailVendorMIB');
            Route::get('detailVendorSIU/{vendorID}', 'VendorController@viewSIU')->name('detailVendorSIU');
            Route::get('detailVendorPaktaIntegritas/{vendorID}', 'VendorController@viewPaktaIntegritas')->name('detailVendorPaktaIntegritas');
            Route::get('detailVendorStrukturOrganisasi/{vendorID}', 'VendorController@viewStrukturOrganisasi')->name('detailVendorStrukturOrganisasi');
            Route::get('detailVendorSITU/{vendorID}', 'VendorController@viewSITU')->name('detailVendorSITU');
            Route::get('detailVendorPermohonanRekanan/{vendorID}', 'VendorController@viewPermohonanRekanan')->name('detailVendorPermohonanRekanan');
            Route::get('detailVendorPernyataanKebenaran/{vendorID}', 'VendorController@viewPernyataanKebenaran')->name('detailVendorPernyataanKebenaran');
            Route::get('detailVendorPengalamanKerja/{vendorID}', 'VendorController@viewPengalamanKerja')->name('detailVendorPengalamanKerja');
            Route::get('detailVendorPerlengkapanPeralatan/{vendorID}', 'VendorController@viewPerlengkapanPeralatan')->name('detailVendorPerlengkapanPeralatan');
            Route::get('detailVendorDokumentasiPerlengkapan/{vendorID}', 'VendorController@viewDokumentasiPerlengkapan')->name('detailVendorDokumentasiPerlengkapan');
            Route::get('detailVendorDokumentasiBangunan/{vendorID}', 'VendorController@viewDokumentasiBangunan')->name('detailVendorDokumentasiBangunan');
            Route::get('detailVendorBank/{vendorID}', 'VendorController@viewBank')->name('detailVendorBank');
            Route::get('detailVendorNPWP/{vendorID}', 'VendorController@viewNPWP')->name('detailVendorNPWP');
            Route::get('detailVendorSPPKP/{vendorID}', 'VendorController@viewSPPKP')->name('detailVendorSPPKP');
            Route::get('detailVendorKTP/{vendorID}', 'VendorController@viewKTP')->name('detailVendorKTP');
            Route::get('detailVendorAktaPendirian/{vendorID}', 'VendorController@viewAktaPendirian')->name('detailVendorAktaPendirian');
            Route::get('detailVendorPengesahanAktePendirian/{vendorID}', 'VendorController@viewPengesahanAkte')->name('detailVendorPengesahanAkte');
            Route::get('detailVendorAktaPerubahan/{vendorID}', 'VendorController@viewAktaPerubahan')->name('detailVendorAktaPerubahan');
            Route::get('detailVendorPengesahanAktePerubahan/{vendorID}', 'VendorController@viewPengesahanAktePerubahan')->name('detailVendorPengesahanAktePerubahan');
            Route::get('detailVendorKekayaan/{vendorID}', 'VendorController@viewKekayaan')->name('detailVendorKekayaan');
            Route::get('detailVendorSertifikatKontruksi/{vendorID}', 'VendorController@viewSertifikatKontruksi')->name('detailVendorSertifikatKontruksi');
            Route::get('detailVendorSuratIzinKontruksi/{vendorID}', 'VendorController@viewSuratIzinKontruksi')->name('detailVendorSuratIzinKontruksi');
            Route::get('detailVendorSuratKeagenan/{vendorID}', 'VendorController@viewSuratKeagenan')->name('detailVendorSuratKeagenan');

            //Dokumen Vendor
            Route::post('storeKTP', 'VendorController@storeKTP');
            Route::post('updateKTP', 'VendorController@updateKTP');
            Route::delete('deleteKTP/{ktpID}', 'VendorController@deleteKTP');

            Route::post('storePengalaman', 'VendorController@storePengalaman');
            Route::post('updatePengalaman', 'VendorController@updatePengalaman');
            Route::delete('deletePengalaman/{pengalamanID}', 'VendorController@deletePengalaman');

            Route::post('storeSIU', 'VendorController@storeSIU');
            Route::post('updateSIU', 'VendorController@updateSIU');
            Route::delete('deleteSIU/{siuID}', 'VendorController@deleteSIU');

            Route::post('storeKekayaan', 'VendorController@storeKekayaan');
            Route::post('updateKekayaan', 'VendorController@updateKekayaan');
            Route::post('storeBank', 'VendorController@storeBank');
            Route::post('updateBank', 'VendorController@updateBank');
            Route::post('storeNPWP', 'VendorController@storeNPWP');
            Route::post('updateNPWP', 'VendorController@updateNPWP');
            Route::post('storeSertifikat', 'VendorController@storeSertifikat');
            Route::post('updateSertifikat', 'VendorController@updateSertifikat');
            Route::post('storeSPPKP', 'VendorController@storeSPPKP');
            Route::post('updateSPPKP', 'VendorController@updateSPPKP');
            Route::post('storeAkta', 'VendorController@storeAkta');
            Route::post('updateAkta', 'VendorController@updateAkta');
            Route::post('storeDokumenMandatori', 'VendorController@storeDokumenMandatori');
            Route::post('updateDokumenMandatori', 'VendorController@updateDokumenMandatori');
            Route::post('storeDokumen', 'VendorController@storeDokumen');
            Route::post('updateDokumen', 'VendorController@updateDokumen');
            Route::get('createAccount/{vendorID}', 'VendorController@createAccount');
        });


