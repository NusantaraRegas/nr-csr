<?php

namespace App\Actions\Pembayaran;

use App\Http\Requests\StorePembayaranRequest;
use App\Services\Pembayaran\PembayaranUpsertService;
use Exception;

class StorePembayaranAction
{
    private $service;

    public function __construct(PembayaranUpsertService $service)
    {
        $this->service = $service;
    }

    public function execute(StorePembayaranRequest $request, $username)
    {
        try {
            $kelayakanID = decrypt($request->kelayakanID);
        } catch (Exception $e) {
            abort(404);
        }

        return $this->service->store($kelayakanID, $request->validated(), $username);
    }
}
