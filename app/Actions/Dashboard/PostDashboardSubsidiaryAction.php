<?php

namespace App\Actions\Dashboard;

use App\Http\Requests\PostDashboardSubsidiaryRequest;

class PostDashboardSubsidiaryAction
{
    public function execute(PostDashboardSubsidiaryRequest $request)
    {
        if ($request->perusahaan == 'PT Nusantara Regas') {
            return redirect()->route('dashboardAnnual', ['year' => encrypt($request->tahun)]);
        }

        return redirect()->route('dashboardSubsidiaryAnnual', [
            'year' => encrypt($request->tahun),
            'company' => $request->perusahaan,
        ]);
    }
}
