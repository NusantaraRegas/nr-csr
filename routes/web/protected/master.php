<?php

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


