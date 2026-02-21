<?php

Route::group(['middleware' => ['cred.login', 'timeOut']], function () {
    require __DIR__ . '/protected/dashboard.php';
    require __DIR__ . '/protected/master.php';
    require __DIR__ . '/protected/vendor.php';
    require __DIR__ . '/protected/operasional.php';
    require __DIR__ . '/protected/proposal.php';
    require __DIR__ . '/protected/anggaran.php';
    require __DIR__ . '/protected/report.php';
    require __DIR__ . '/protected/payment.php';
    require __DIR__ . '/protected/export-popay.php';
    require __DIR__ . '/protected/todo.php';
    require __DIR__ . '/protected/tasklist.php';
    require __DIR__ . '/protected/tasklist-legal.php';
    require __DIR__ . '/protected/dokumen-legal.php';
    require __DIR__ . '/protected/profile.php';
    require __DIR__ . '/protected/subsidiary.php';
});
