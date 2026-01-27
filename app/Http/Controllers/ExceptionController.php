<?php

namespace App\Http\Controllers;

use App\Models\ErrorException;
use Illuminate\Http\Request;
use DB;
use Exception;

class ExceptionController extends Controller
{
    public function index()
    {
        $data = ErrorException::orderBy('error_id', 'DESC')->get();
        return view('master.data_exception')
            ->with([
                'dataException' => $data,
            ]);
    }
}
