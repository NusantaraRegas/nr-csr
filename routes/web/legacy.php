<?php

$legacyDataReceiverAction = config('data_receiver.legacy_options.enabled', true)
    && strtolower((string) config('data_receiver.legacy_options.phase', 'phase1')) !== 'phase2'
        ? 'APIController@dataReceiverOptions'
        : 'APIController@dataReceiverOptionsDisabled';

Route::get('/legacy/dataReceiver/options', $legacyDataReceiverAction)
    ->name('legacy.dataReceiver.options');
