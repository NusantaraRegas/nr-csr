<?php

namespace App\Actions\Pembayaran;

use App\Http\Requests\UpdatePembayaranRequest;
use App\Services\Pembayaran\PembayaranUpsertService;
use Exception;

class UpdatePembayaranAction
{
    private $service;

    public function __construct(PembayaranUpsertService $service)
    {
        $this->service = $service;
    }

    public function execute(UpdatePembayaranRequest $request)
    {
        try {
            $pembayaranID = decrypt($request->pembayaranID);
        } catch (Exception $e) {
            abort(404);
        }

        return $this->service->update($pembayaranID, $request->validated());
    }
}
