<?php

namespace App\Actions\Dashboard;

use App\Http\Requests\PostDashboardAnnualRequest;

class PostDashboardAnnualAction
{
    public function execute(PostDashboardAnnualRequest $request)
    {
        return redirect()->route('dashboardAnnual', ['year' => encrypt($request->tahun)]);
    }
}
