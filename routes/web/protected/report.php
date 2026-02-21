<?php

        Route::group(['prefix' => 'report', 'middleware' => 'isReport'], function () {
            Route::get('dataKelayakan', 'KelayakanController@index')->name('dataKelayakan');
            Route::get('editKelayakan/{id}', 'KelayakanController@edit')->name('editKelayakan');
            Route::post('updateKekayaan', 'KelayakanController@update')->name('updateKelayakan');
            Route::delete('deleteKelayakan/{id}', "KelayakanController@delete")->name('deleteKelayakan');

            Route::post('updateProposal', "KelayakanController@updateProposal")->name('updateProposal');
            Route::post('updatePenerima', "KelayakanController@updatePenerima")->name('updatePenerima');
            Route::post('updateInformasiBank', "KelayakanController@updateBank")->name('updateBank');
            Route::post('updateProker', "KelayakanController@updateProker")->name('updateProker');

            Route::get('detailKelayakan/{id}', "KelayakanController@detail")->name('detailKelayakan');
            Route::post('submitKelayakan', "KelayakanController@submit")->name('submitKelayakan');

            Route::get('exportKelayakan', 'KelayakanController@exportKelayakan')->name('exportKelayakan');
            Route::get('exportPenyaluran', 'KelayakanController@exportPenyaluran')->name('exportPenyaluran');

            Route::get('indexPembayaran', 'PembayaranController@index')->name('indexPembayaran');
            Route::get('exportPembayaran', 'PembayaranController@exportPembayaran')->name('exportPembayaran');

            Route::get('indexRealisasiProker', 'PembayaranController@indexRealisasiProker')->name('indexRealisasiProker');
            Route::get('exportRealisasiProker', 'PembayaranController@exportRealisasiProker')->name('exportRealisasiProker');

            Route::get('indexRealisasiPilar', 'PembayaranController@indexPilar')->name('indexRealisasiPilar');
            Route::get('exportRealisasiPilar', 'PembayaranController@exportRealisasiPilar')->name('exportRealisasiPilar');

            Route::get('indexRealisasiPrioritas', 'PembayaranController@indexPrioritas')->name('indexRealisasiPrioritas');
            Route::get('exportRealisasiPrioritas', 'PembayaranController@exportRealisasiPrioritas')->name('exportRealisasiPrioritas');
            
            Route::get('/data-Lampiran/{loginID}', 'LampiranController@index')->name('data-lampiran');

            Route::get('/LaporanKelayakan', 'KelayakanController@cariKelayakan')->name('cari-kelayakan');
            Route::get('/LaporanKelayakanCompleted', 'KelayakanController@cariKelayakanCompleted')->name('cari-kelayakan-completed');

            Route::get('/dataToday', 'KelayakanController@dataToday')->name('dataToday');

            Route::post('cariTahun', "KelayakanController@cariTahun");
            Route::get('/dataTahun/{tahun}', 'KelayakanController@dataTahun')->name('dataTahun');

            Route::post('cariBulan', "KelayakanController@cariBulan");
            Route::get('/dataBulan/{bulan}/{tahun}', 'KelayakanController@dataBulan')->name('dataBulan');

            Route::post('cariPeriode', "KelayakanController@cariPeriode");
            Route::get('/dataPeriode/{tanggal1}/{tanggal2}', 'KelayakanController@dataPeriode')->name('data-periode');

            Route::get('/dataProvinsi/{tanggal1}/{tanggal2}/{provinsi}/{kabupaten}', 'KelayakanController@dataProvinsi')->name('data-provinsi');
            Route::get('/dataProvinsiSDGs/{tanggal1}/{tanggal2}/{provinsi}/{kabupaten}/{pilar}/{gols}', 'KelayakanController@dataProvinsiSDGs')->name('dataProvinsiSDGs');
            Route::get('/dataProvinsiSDGsJenis/{tanggal1}/{tanggal2}/{provinsi}/{kabupaten}/{pilar}/{gols}/{jenis}', 'KelayakanController@dataProvinsiSDGsJenis')->name('dataProvinsiSDGsJenis');
            Route::get('/dataProvinsiJenis/{tanggal1}/{tanggal2}/{provinsi}/{kabupaten}/{jenis}', 'KelayakanController@dataProvinsiJenis')->name('dataProvinsiJenis');

            Route::get('/dataSDGs/{tanggal1}/{tanggal2}/{pilar}/{gols}', 'KelayakanController@dataSDGs')->name('dataSDGs');
            Route::get('/dataSDGsJenis/{tanggal1}/{tanggal2}/{pilar}/{gols}/{jenis}', 'KelayakanController@dataSDGsJenis')->name('dataSDGsJenis');
            Route::get('/dataJenis/{tanggal1}/{tanggal2}/{jenis}', 'KelayakanController@dataJenis')->name('dataJenis');

            Route::post('checklistYKPP', "KelayakanController@checklistYKPP")->name('checklistYKPP');
            Route::get('unchecklistYKPP/{id}', "KelayakanController@unchecklistYKPP")->name('unchecklistYKPP');
            Route::get('unsubmittedYKPP/{id}', "KelayakanController@unsubmittedYKPP")->name('unsubmittedYKPP');
            
            Route::post('updateStatusYKPP', "KelayakanController@updateStatusYKPP");
            Route::get('approveYKPP/{id}', "KelayakanController@approveYKPP");
            Route::post('submitYKPP', "KelayakanController@submitYKPP")->name('submitYKPP');
            Route::get('printPenyaluran/{penyaluran}/{tahun}', "ReportController@printPenyaluran")->name('printPenyaluran');
            Route::post('uploadSuratYKPP', "KelayakanController@uploadSuratYKPP");
            Route::post('updateSuratYKPP', "KelayakanController@updateSuratYKPP");

            Route::post('uploadKelayakan', "LaporanController@uploadKelayakan");

            Route::get('/data-Evaluasi', 'EvaluasiController@index')->name('data-evaluasi');
            Route::delete('delete-evaluasi/{loginID}', "EvaluasiController@deleteEvaluasi");
            Route::get('forward-evaluasi/{loginID}', 'EvaluasiController@forwardEvaluasi');

            Route::get('data-Survei', 'SurveiController@index')->name('data-survei');
            Route::get('proposal-Disetujui', 'SurveiController@setuju')->name('proposal-setuju');

            Route::delete('delete-survei/{loginID}', "SurveiController@deleteSurvei");
            Route::get('forward-survei/{loginID}', 'SurveiController@forwardSurvei');
            Route::post('updateNilaiSurvei', 'SurveiController@updateNilaiSurvei');

            Route::post('exportPopay', 'PembayaranController@exportPopay')->name('export-popay');
            Route::delete('deletePopay/{loginID}', 'PembayaranController@deletePopay');

            //LAPORAN REALISASI
            Route::get('listRealisasiAllAnnualToday/{date}', 'APIController@listRealisasiAllToday')->name('listRealisasiAllAnnualToday');
            Route::get('listRealisasiAll', 'APIController@listRealisasiAll')->name('listRealisasiAll');
            Route::post('postPaymentRequestAnnual', 'APIController@postPaymentRequestAnnual');
            Route::get('listRealisasiAllAnnual/{year}', 'APIController@listRealisasiAllAnnual')->name('listRealisasiAllAnnual');
            Route::post('postRealisasiAllMonthly', 'APIController@postRealisasiAllMonthly');
            Route::get('listRealisasiAllMonthly/{month}/{year}', 'APIController@listRealisasiAllMonthly')->name('listRealisasiAllMonthly');
            Route::post('postRealisasiCustomRange', 'APIController@postRealisasiCustomRange');
            Route::get('listRealisasiCustomRange/{tanggal1}/{tanggal2}', 'APIController@listRealisasiCustomRange')->name('listRealisasiCustomRange');


            Route::get('listProgressAll', 'APIController@listProgressAll')->name('listProgressAll');
            Route::post('postProgressAllAnnual', 'APIController@postProgressAllAnnual');
            Route::get('listProgressAllAnnual/{year}', 'APIController@listProgressAllAnnual')->name('listProgressAllAnnual');

            Route::get('listPaymentRequestAllMonth/{status}/{month}', 'APIController@listPaymentRequestAllMonth')->name('listPaymentRequestAllMonth');

            Route::post('listPaymentRequestAllMonth', 'APIController@listPaymentRequestAllBulan');
            Route::post('listPaymentRequestAllDate', 'APIController@listPaymentRequestAllDate');
            Route::get('listPaymentRequestAll', 'APIController@listPaymentRequestAll')->name('listPaymentRequestAll');
            Route::get('listPaymentRequestAllProgress', 'APIController@listPaymentRequestAllProgress')->name('listPaymentRequestAllProgress');

            Route::get('listPaymentRequest', 'APIController@listPaymentRequest')->name('listPaymentRequest');
            Route::get('listPaymentRequestProgress', 'APIController@listPaymentRequestProgress')->name('listPaymentRequestProgress');
            Route::get('listPaymentRequestPAID', 'APIController@listPaymentRequestPAID')->name('listPaymentRequestPAID');
            Route::get('listPaymentRequestToday/{tanggal1}/{tanggal2}', "APIController@listPaymentRequestToday")->name('listPaymentRequestToday');
            Route::post('listPaymentRequestPeriode', "APIController@listPaymentRequestPeriode");

            Route::get('listPaymentRequestProker/{year}/{prokerID}', 'APIController@listPaymentRequestProker')->name('listPaymentRequestProker');
            Route::get('listRealisasiProker', 'APIController@listRealisasiProker')->name('listRealisasiProker');
            Route::post('postRealisasiProkerAnnual', 'APIController@postRealisasiProkerAnnual');
            Route::get('listRealisasiProkerAnnual/{year}', 'APIController@listRealisasiProkerAnnual')->name('listRealisasiProkerAnnual');

            Route::post('listPaymentRequestPeriode', "APIController@listPaymentRequestPeriode");
            Route::get('listPaymentRequestProvinsi/{year}/{provinsi}', "APIController@listPaymentRequestProvinsi")->name('listPaymentRequestProvinsi');
            Route::get('listPaymentRequestProvinsi/{year}/{provinsi}/{kabupaten}', "APIController@listPaymentRequestKabupaten")->name('listPaymentRequestKabupaten');

            Route::get('listPaymentRequestProposal', 'APIController@listPaymentRequestProposal')->name('listPaymentRequestProposal');
            Route::get('listPaymentRequestProposalPAID', 'APIController@listPaymentRequestProposalPAID')->name('listPaymentRequestProposalPAID');

            Route::get('listPaymentRequestProposalJenis/{jenis}', 'APIController@listPaymentRequestProposalJenis')->name('listPaymentRequestProposalJenis');
            Route::post('listPaymentRequestProposalPeriodeJenis', 'APIController@listPaymentRequestProposalPeriodeJenis');

            //REKAP YKPP
            Route::get('listPaymentYKPP', 'ReportController@listPaymentYKPP')->name('listPaymentYKPP');
            Route::get('listPaymentYKPPOpen', 'ReportController@listPaymentYKPPOpen')->name('listPaymentYKPPOpen');
            Route::get('listPaymentYKPPVerified', 'ReportController@listPaymentYKPPVerified')->name('listPaymentYKPPVerified');
            Route::get('listPaymentYKPPSubmited', 'ReportController@listPaymentYKPPSubmited')->name('listPaymentYKPPSubmited');

            Route::get('printPaymentYKPP', 'ReportController@printPaymentYKPP')->name('printPaymentYKPP');
            Route::get('printPaymentYKPPOpen', 'ReportController@printPaymentYKPPOpen')->name('printPaymentYKPPOpen');
            Route::get('printPaymentYKPPVerified', 'ReportController@printPaymentYKPPVerified')->name('printPaymentYKPPVerified');
            Route::get('printPaymentYKPPSubmited', 'ReportController@printPaymentYKPPSubmited')->name('printPaymentYKPPSubmited');

            Route::post('postPaymentYKPPYear', 'ReportController@postPaymentYKPPYear');
            Route::get('listPaymentYKPPYear/{year}', 'ReportController@listPaymentYKPPYear')->name('listPaymentYKPPYear');

            Route::get('logApproval/{ID}', 'APIController@logApproval')->name('logApproval');
            Route::get('dataBank', 'APIController@dataBank');

            //EXPORT EXCEL
            Route::get('exportPaymentRequest/{tahun}', "LaporanController@exportPaymentRequest")->name('exportPaymentRequest');
            Route::get('exportPaymentRequestMonthly/{bulan}/{tahun}', "LaporanController@exportPaymentRequestMonthly")->name('exportPaymentRequestMonthly');
            Route::get('exportPaymentRequestPeriode/{tanggal1}/{tanggal2}', "LaporanController@exportPaymentRequestPeriode")->name('exportPaymentRequestPeriode');
            Route::get('exportPaymentRequestProvinsi/{tahun}/{provinsi}', "LaporanController@exportPaymentRequestProvinsi")->name('exportPaymentRequestProvinsi');
            Route::get('exportPaymentRequestKabupaten/{tahun}/{provinsi}/{kabupaten}', "LaporanController@exportPaymentRequestKabupaten")->name('exportPaymentRequestKabupaten');
            Route::get('exportPaymentRequestProker/{prokerID}', "LaporanController@exportPaymentRequestProker")->name('exportPaymentRequestProker');


            Route::get('exportPeriodePaymentRequest/{tanggal1}/{tanggal2}/{status}', "LaporanController@exportPeriodePaymentRequest")->name('exportPeriodePaymentRequest');

            Route::get('exportRealisasiProposal/{tahun}', "LaporanController@exportRealisasiProposal")->name('exportRealisasiProposal');
            Route::get('exportRealisasiProposalPeriode/{tanggal1}/{tanggal2}', 'LaporanController@exportRealisasiProposalPeriode')->name('exportRealisasiProposalPeriode');
            Route::get('exportRealisasiProposalProvinsi/{tahun}/{provinsi}', 'LaporanController@exportRealisasiProposalProvinsi')->name('exportRealisasiProposalProvinsi');

            Route::get('exportRealisasiProposalJenis/{tahun}/{jenis}', "LaporanController@exportRealisasiProposalJenis")->name('exportRealisasiProposalJenis');
            Route::get('exportRealisasiProposalPeriodeJenis/{tanggal1}/{tanggal2}/{jenis}', 'LaporanController@exportRealisasiProposalPeriodeJenis')->name('exportRealisasiProposalPeriodeJenis');

            Route::post('/postPeriodePaymentRequest', 'LaporanController@cariPeriode');
            Route::get('/exportAllPaymentRequest/{tanggal1}/{tanggal2}', 'LaporanController@exportAllPaymentRequest')->name('exportAllPaymentRequest');
            Route::get('/exportYearPaymentRequest/{tahun}', 'LaporanController@exportYearPaymentRequest')->name('exportYearPaymentRequest');

            //PRINT
            Route::get('printPaymentRequest/{tahun}', 'LaporanController@printPaymentRequest')->name('printPaymentRequest');
            Route::get('printPaymentRequestPeriode/{tanggal1}/{tanggal2}', 'LaporanController@printPaymentRequestPeriode')->name('printPaymentRequestPeriode');
            Route::get('printPaymentRequestMonthly/{bulan}/{tahun}', 'LaporanController@printPaymentRequestMonthly')->name('printPaymentRequestMonthly');
            Route::get('printPaymentRequestProvinsi/{tahun}/{provinsi}', 'LaporanController@printPaymentRequestProvinsi')->name('printPaymentRequestProvinsi');
            Route::get('printPaymentRequestKabupaten/{tahun}/{provinsi}/{kabupaten}', 'LaporanController@printPaymentRequestKabupaten')->name('printPaymentRequestKabupaten');

            Route::get('printPaymentRequestProposal/{tahun}', 'LaporanController@printPaymentRequestProposal')->name('printPaymentRequestProposal');
            Route::get('printPaymentRequestProposalPeriode/{tanggal1}/{tanggal2}', 'LaporanController@printPaymentRequestProposalPeriode')->name('printPaymentRequestProposalPeriode');

            Route::get('printPaymentRequestProposalJenis/{tahun}/{jenis}', 'LaporanController@printPaymentRequestProposalJenis')->name('printPaymentRequestProposalJenis');
            Route::get('printPaymentRequestProposalPeriodeJenis/{tanggal1}/{tanggal2}/{jenis}', 'LaporanController@printPaymentRequestProposalPeriodeJenis')->name('printPaymentRequestProposalPeriodeJenis');

            //REALISASI SUBSIDIARY
            Route::get('detailRealisasiSubsidiary', 'ReportController@index')->name('detailRealisasiSubsidiary');
            Route::post('postDetailRealisasiSubsidiaryAnnual', 'ReportController@postDetailRealisasiSubsidiaryAnnual');
            Route::get('detailRealisasiSubsidiaryAnnual/{year}/{company}', 'ReportController@indexAnnual')->name('detailRealisasiSubsidiaryAnnual');
        });


