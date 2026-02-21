<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;


Route::middleware(['web'])->group(function () {
    //====================LOGIN====================//
    Route::get('/', 'LoginController@auth')->name('auth');
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/login', 'LoginController@index')->name('login');
        Route::post('/login', 'LoginController@login');
        Route::get('/logout', 'LoginController@logout')->name('logout');
        Route::get('/forgot-password', 'LoginController@forgot')->name('forgot');
        Route::post('/forgot-password', 'LoginController@checkEmail');
        Route::get('update-password/{email}/{token}', 'LoginController@perbaruiPassword')->name('update-password');
        Route::post('reset-password', 'LoginController@updatePassword');
        Route::post('editPassword', 'LoginController@editPassword')->name('editPassword');

        Route::get('/otp', 'LoginController@showOtp')->name('showOtp');
        Route::post('/otp', 'LoginController@verifyOtp')->name('verifyOtp');;
        Route::get('/resend-otp', 'LoginController@resendOtp')->name('resend-otp');
    });

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

    Route::group(['middleware' => ['cred.login', 'timeOut']], function () {
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


        Route::group(['prefix' => 'master', 'middleware' => 'isAdmin'], function () {
            Route::get('/makerPopay', 'APIController@dataMaker')->name('makerPopay');

            Route::get('/data-role', 'RoleController@index')->name('data-role');
            Route::post('input-role', 'RoleController@insertRole');
            Route::post('edit-role', "RoleController@editRole");
            Route::delete('delete-role/{loginID}/{nama}', "RoleController@deleteRole")->name('delete-role');

            Route::get('/indexUser', 'UserController@index')->name('indexUser');
            Route::get('/indexUserServerSide', 'UserController@indexServerSide')->name('indexUserServerSide');
            Route::get('/indexUser/json', 'UserController@json')->name('indexUserJson');
            Route::get('/data-user-active', 'UserController@indexActive')->name('data-user-active');
            Route::get('/data-user-nonActive', 'UserController@indexNonActive')->name('data-user-nonActive');
            Route::get('/edit-user/{loginID}', "UserController@ubahUser")->name('edit-user');
            Route::post('storeUser', 'UserController@store');
            Route::post('updateUser', "UserController@update");
            Route::post('updateFotoUser', 'UserController@updateFoto')->name('updateFotoProfile');
            Route::delete('deleteUser/{userID}', "UserController@delete");
            Route::get('profileUser/{id}', "UserController@profile")->name('profileUser');

            Route::get('/data-pengirim', 'PengirimController@index')->name('data-pengirim');
            Route::post('input-pengirim', 'PengirimController@store');
            Route::post('edit-pengirim', "PengirimController@update");
            Route::delete('delete-pengirim/{loginID}', "PengirimController@delete")->name('delete-pengirim');

            Route::get('indexVendor', 'VendorController@index')->name('indexVendor');
            Route::get('createVendor', 'VendorController@create')->name('createVendor');
            Route::get('editVendor/{vendorID}', 'VendorController@edit')->name('editVendor');
            Route::delete('deleteVendor/{vendorID}', "VendorController@delete");

            Route::get('/dataAnggota', 'AnggotaController@index')->name('dataAnggota');
            Route::post('inputAnggota', 'AnggotaController@store');
            Route::post('editAnggota', "AnggotaController@update");
            Route::post('updateFotoAnggota', 'AnggotaController@updateFoto')->name('updateFotoAnggota');
            Route::delete('deleteAnggota/{anggotaID}', "AnggotaController@delete");
            Route::get('profileAnggota/{id}', "AnggotaController@profile")->name('profileAnggota');

            Route::get('indexHirarki', 'HirarkiController@index')->name('indexHirarki');
            Route::post('storeHirarki', 'HirarkiController@store')->name('storeHirarki');
            Route::post('updateHirarki', "HirarkiController@update")->name('updateHirarki');
            Route::delete('deleteHirarki/{anggotaID}', "HirarkiController@delete")->name('deleteHirarki');

            Route::get('/data-sektor', 'SektorController@index')->name('data-sektorBantuan');
            Route::post('input-sektor', 'SektorController@insertSektor');
            Route::post('edit-sektor', "SektorController@editSektor");
            Route::delete('delete-sektor/{loginID}', "SektorController@deleteSektor")->name('delete-sektor');

            Route::get('/data-kebijakan', 'KebijakanController@index')->name('data-kebijakan');
            Route::post('input-kebijakan', 'KebijakanController@insertKebijakan');
            Route::post('edit-kebijakan', "KebijakanController@editKebijakan");
            Route::delete('delete-kebijakan/{loginID}', "KebijakanController@deleteKebijakan")->name('delete-kebijakan');

            Route::get('/dataSDG', 'SDGController@index')->name('dataSDG');
            Route::post('inputSDG', 'SDGController@store');
            Route::post('editSDG', "SDGController@update");
            Route::delete('deleteSDG/{SDGID}', "SDGController@delete");

            Route::get('/dataPilar', 'PilarController@index')->name('dataPilar');
            Route::post('inputPilar', 'PilarController@store');
            Route::post('editPilar', "PilarController@update");
            Route::delete('deletePilar/{pilarID}', "PilarController@delete");

            Route::get('/dataIndikator', 'SubPilarController@index')->name('dataIndikator');
            Route::post('inputIndikator', 'SubPilarController@store');
            Route::post('editIndikator', "SubPilarController@update");
            Route::delete('deleteIndikator/{indikatorID}', "SubPilarController@delete");

            Route::get('indexException', 'ExceptionController@index')->name('indexException');
            Route::post('updateException', "ExceptionController@update");
            Route::delete('deleteException/{exceptionID}', "ExceptionController@delete");

            Route::get('indexPerusahaan', 'PerusahaanController@index')->name('indexPerusahaan');
            Route::post('storePerusahaan', 'PerusahaanController@store');
            Route::post('updatePerusahaan', "PerusahaanController@update");
            Route::post('updateProfilePerusahaan', "PerusahaanController@updateProfile");
            Route::post('updateLogo', 'PerusahaanController@updateLogo');
            Route::delete('deletePerusahaan/{perusahaanID}', "PerusahaanController@delete");
            Route::get('profilePerusahaan/{id}', "PerusahaanController@profile")->name('profilePerusahaan');
        });


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

        Route::group(['prefix' => 'operasional', 'middleware' => 'isUser'], function () {
            Route::get('createOperasional', 'KelayakanController@createOperasional')->name('createOperasional');
             Route::post('storeOperasional', 'KelayakanController@storeOperasional')->name('storeOperasional');
        
        });

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
            // Route::get('exportRealisasi/{year}', 'AnggaranController@exportRealisasi')->name('exportRealisasiProker');

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

        Route::group(['prefix' => 'payment', 'middleware' => 'isUser'], function () {
            Route::post('storePembayaran', 'PembayaranController@store')->name('storePembayaran');
            Route::post('updatePembayaran', 'PembayaranController@update')->name('updatePembayaran');
            Route::delete('deletePembayaran/{id}', 'PembayaranController@delete')->name('deletePembayaran');
        });

        Route::group(['prefix' => 'exportPopay', 'middleware' => 'isFinance'], function () {
            Route::post('updatePaymentRequest', 'APIController@updatePaymentRequest');
            Route::post('updatePaymentRequestPopayV4', 'APIController@updatePaymentRequestPopayV4');

            Route::get('kategoriPembayaran/{category}', 'APIController@kategoriPembayaran');
            Route::get('siteReceiver/{number}', 'APIController@dataSiteReceiver');

            Route::get('taskMapping', 'PembayaranController@taskMapping')->name('taskMapping');
            Route::post('postTaskMappingAnnual', 'PembayaranController@postTaskMappingAnnual');
            Route::get('taskMappingAnnual/{year}', 'PembayaranController@taskMappingAnnual')->name('taskMappingAnnual');

            Route::get('exportPembayaranIdulAdha/{pembayaranID}', 'PembayaranController@exportPembayaranIdulAdha')->name('exportPembayaranIdulAdha');

            Route::get('subProposal/{PR}', 'PembayaranController@subProposal')->name('subProposal');

            Route::get('dataTaxCode/{loginID}', "PembayaranController@dataTaxCode");
            Route::get('dataTaxPut/{loginID}', "PembayaranController@dataTaxPut");
            Route::get('dataTaxGroup/{loginID}', "PembayaranController@dataTaxGroup");

            Route::post('storePaymentRequest', 'APIController@storePaymentRequest')->name('storePaymentRequest');
            Route::post('storePaymentRequestIdulAdha', 'APIController@storePaymentRequestIdulAdha');
            Route::post('storeDetailAccountIdulAdha', 'APIController@storeDetailAccountIdulAdha');

            Route::get('viewPaymentRequest/{PR}', 'APIController@viewPaymentRequest')->name('viewPaymentRequest');

            Route::delete('deletePaymentRequest/{PR}', 'APIController@deletePaymentRequest');

            Route::post('storePaymentRequestIdulAdha', 'APIController@storePaymentRequestIdulAdha');
        });

        Route::group(['prefix' => 'todo', 'middleware' => 'isReport'], function () {
            Route::get('', 'TasklistController@todo')->name('todolist');
        });

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

        Route::group(['prefix' => 'tasklistLegal', 'middleware' => 'isLegal'], function () {
            Route::get('/Legal', 'TasklistLegalController@tasklistLegal')->name('tasklist-legal');
            Route::get('approveBAST/{loginID}', 'TasklistLegalController@approveBAST');
        });

        Route::group(['prefix' => 'DokumenLegal', 'middleware' => 'isReport'], function () {            
            Route::post('storeBASTDana', 'BASTController@store')->name('storeBASTDana');
            Route::post('updateBASTDana', 'BASTController@update')->name('updateBASTDana');
            Route::delete('deleteBAST/{id}', 'BASTController@delete');

            Route::get('/ubah-BASTDana/{loginID}', 'BASTController@ubahBASTDana')->name('ubah-bast-dana');

            Route::get('/SPK/{loginID}', 'SPKController@inputSPK')->name('input-spk');
            Route::post('/insert-SPK', 'SPKController@insertSPK');
            Route::get('/ubah-SPK/{loginID}', 'SPKController@ubahSPK')->name('ubah-spk');
            Route::post('/edit-SPK', 'SPKController@editSPK');
            Route::post('/insert-Header', 'SPKController@insertHeader');
            Route::post('/insert-DetailSPK', 'SPKController@insertDetailSPK');
            Route::delete('/delete-SPK/{loginID}', 'SPKController@deleteSPK');
        });

        Route::group(['prefix' => 'profile', 'middleware' => 'isUser'], function () {
            Route::get('account-setting/{loginID}', 'UserController@profile')->name('profile');
            Route::post('/update-profile', 'UserController@editProfile');
            Route::post('/update-password', 'UserController@editPassword');
            Route::delete('/delete-foto/{loginID}', 'UserController@deleteFotoProfile')->name('delete-foto');
        });

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
    });
});
