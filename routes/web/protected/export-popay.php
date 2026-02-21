<?php

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


