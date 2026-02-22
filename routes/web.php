<?php

Route::middleware(['web'])->group(function () {
    require __DIR__ . '/web/legacy.php';
    require __DIR__ . '/web/public-auth.php';
    require __DIR__ . '/web/public-form.php';
    require __DIR__ . '/web/protected.php';
});
