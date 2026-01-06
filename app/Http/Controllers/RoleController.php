<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InsertRoleValidation;
use App\Http\Requests\EditRoleValidation;
use DB;
use App\Models\Role;
use Exception;
use Symfony\Component\HttpKernel\Tests\KernelTest;

class RoleController extends Controller
{
    public function index(){
        $data = Role::get();
        return view('master.data_role')
            ->with([
                'dataRole' => $data
            ]);
    }

    public function insertRole(InsertRoleValidation $request)
    {
        $dataRole = [
            'role' => $request->role,
            'role_name' => $request->nama,
        ];

        try {
            Role::create($dataRole);
            return redirect()->back()->with('sukses', "Role $request->nama berhasil disimpan");
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Role yang anda input sudah ada');
        }
    }

    public function editRole(EditRoleValidation $request)
    {
        try {
            $logID = decrypt($request->idrole);
        } catch (Exception $e) {
            abort(404);
        }

        $dataUpdate = [
            'role' => $request->role_edit,
            'role_name' => $request->nama_edit,
        ];

        try {
            Role::where('id_role', $logID)->update($dataUpdate);
        } catch (Exception $e) {
            return redirect()->back()->with('peringatan', 'Role yang anda input sudah ada');
        }
        return redirect()->back()->with('sukses', "Role $request->nama berhasil diubah");
    }

    public function deleteRole($loginID,$nama)
    {
        try {
            $logID = decrypt($loginID);
        } catch (Exception $e) {
            abort(404);
        }
        Role::where('id_role', $logID)->delete();
        return redirect()->back()->with('sukses', "Role $nama berhasil dihapus");
    }
}
