<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware(['web'])->group(function () {
    Route::get('/legacy/dataReceiver/options', 'APIController@dataReceiverOptions')
        ->name('legacy.dataReceiver.options');

    require __DIR__ . '/web/public-auth.php';
    require __DIR__ . '/web/public-form.php';
    require __DIR__ . '/web/protected.php';
});
