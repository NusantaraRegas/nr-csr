<?php

namespace App\Services\Tasklist;

use App\Models\Survei;
use App\Models\User;
use App\Models\ViewSurvei;
use Illuminate\Support\Facades\DB;

class TasklistSurveiService
{
    public function indexData(string $username): array
    {
        $evaluator2 = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['evaluator2', $username],
                ['status', 'Forward'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahEvaluator2 = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['evaluator2', $username],
                ['status', 'Forward'],
            ])
            ->first();

        $kadep = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahKadep = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->first();

        $kadiv = DB::table('v_evaluasi')
            ->select('v_evaluasi.*')
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->orderBy('id_evaluasi', 'DESC')
            ->get();

        $jumlahKadiv = DB::table('v_evaluasi')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->first();

        $jumlahTask = $jumlahEvaluator2->jumlah + $jumlahKadep->jumlah + $jumlahKadiv->jumlah;

        $surveyor2 = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['survei2', $username],
                ['status', 'Forward'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahSurveyor2 = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['survei2', $username],
                ['status', 'Forward'],
            ])
            ->first();

        $kadepSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahKadepSurvei = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadep', $username],
                ['status', 'Approved 1'],
            ])
            ->first();

        $kadivSurvei = DB::table('v_survei')
            ->select('v_survei.*')
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahKadivSurvei = DB::table('v_survei')
            ->select(DB::raw('count(*) as jumlah'))
            ->where([
                ['kadiv', $username],
                ['status', 'Approved 2'],
            ])
            ->first();

        $jumlahTaskSurvei = $jumlahSurveyor2->jumlah + $jumlahKadepSurvei->jumlah + $jumlahKadivSurvei->jumlah;

        return [
            'username' => $username,
            'dataEvaluator2' => $evaluator2,
            'jumlahEvaluator2' => $jumlahEvaluator2->jumlah,
            'dataKadep' => $kadep,
            'jumlahKadep' => $jumlahKadep->jumlah,
            'dataKadiv' => $kadiv,
            'jumlahKadiv' => $jumlahKadiv->jumlah,
            'dataSurvei2' => $surveyor2,
            'jumlahSurvei2' => $jumlahSurveyor2->jumlah,
            'dataKadepSurvei' => $kadepSurvei,
            'jumlahKadepSurvei' => $jumlahKadepSurvei->jumlah,
            'dataKadivSurvei' => $kadivSurvei,
            'jumlahKadivSurvei' => $jumlahKadivSurvei->jumlah,
            'jumlahTask' => $jumlahTask,
            'jumlahTaskSurvei' => $jumlahTaskSurvei,
        ];
    }

    public function reviewSurveiData(string $username): array
    {
        $data = ViewSurvei::where('survei2', $username)
            ->where('status', 'Forward')
            ->orderBy('id_survei', 'DESC')
            ->get();

        $jumlahData = ViewSurvei::where('survei2', $username)
            ->where('status', 'Forward')
            ->orderBy('id_survei', 'DESC')
            ->count();

        return [
            'username' => $username,
            'dataSurvei' => $data,
            'jumlahData' => $jumlahData,
        ];
    }

    public function tasklistSurveiData(string $username, string $role): array
    {
        if ($role == 'Manager') {
            $data = ViewSurvei::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = ViewSurvei::where('kadiv', $username)
                ->where('status', 'Approved 2')
                ->count();
        } elseif ($role == 'Supervisor 1') {
            $data = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->count();
        } else {
            $data = ViewSurvei::where('kadep', $username)
                ->where('status', 'Approved 1')
                ->orderBy('id_survei', 'DESC')
                ->get();

            $jumlahData = 0;
        }

        return [
            'username' => $username,
            'dataSurvei' => $data,
            'jumlahData' => $jumlahData,
        ];
    }

    public function review(int $logID, string $hasilSurvei): bool
    {
        $kadep = User::where('role', 'Supervisor 1')
            ->where('status', 'Active')
            ->first();
        $survei = ViewSurvei::where('id_survei', $logID)->first();

        if (! $kadep || ! $survei) {
            return false;
        }

        $dataUpdate = [
            'status' => 'Approved 1',
            'hasil_konfirmasi' => $hasilSurvei,
            'approve_date' => date('Y-m-d'),
        ];

        return Survei::where('id_survei', $logID)->update($dataUpdate) > 0;
    }
}
