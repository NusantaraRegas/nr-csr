<?php

namespace App\Actions\API;

use App\Http\Requests\StoreApiPaymentRequestRequest;
use App\Services\API\ApiPaymentRequestService;

class StoreApiPaymentRequestAction
{
    protected $service;

    public function __construct(ApiPaymentRequestService $service)
    {
        $this->service = $service;
    }

    public function execute(StoreApiPaymentRequestRequest $request)
    {
        return $this->service->storePaymentRequest($request);
    }
}
