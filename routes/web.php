<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::middleware(['web'])->group(function () {
    $legacyDataReceiverAction = config('data_receiver.legacy_options.enabled', true)
        && strtolower((string) config('data_receiver.legacy_options.phase', 'phase1')) !== 'phase2'
            ? 'APIController@dataReceiverOptions'
            : 'APIController@dataReceiverOptionsDisabled';

    Route::get('/legacy/dataReceiver/options', $legacyDataReceiverAction)
        ->name('legacy.dataReceiver.options');

    require __DIR__ . '/web/public-auth.php';
    require __DIR__ . '/web/public-form.php';
    require __DIR__ . '/web/protected.php';
});
