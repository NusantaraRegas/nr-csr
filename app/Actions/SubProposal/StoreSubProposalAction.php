<?php

namespace App\Actions\SubProposal;

use App\Http\Requests\StoreSubProposalRequest;
use App\Services\SubProposal\StoreSubProposalService;

class StoreSubProposalAction
{
    private $service;

    public function __construct(StoreSubProposalService $service)
    {
        $this->service = $service;
    }

    public function execute(StoreSubProposalRequest $request)
    {
        return $this->service->handle($request->validated());
    }
}
