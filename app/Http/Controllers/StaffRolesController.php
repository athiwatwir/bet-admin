<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\StaffRole;
use App\Models\StaffRolePermission;

class StaffRolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role');
    }

    public function index()
    {
        $role = StaffRole::where('status', 'CO')->orderBy('isactive', 'DESC')->get();
        return view('staffroles.index', ['roles' => $role]);
    }

    public function create()
    {
        return view('staffroles.create');
    }

    public function store(Request $request)
    {
        $check_name = $this->checkRoleName($request->name);
        if($check_name) {
            $permission = $this->setPermisstion($request);

            $role = StaffRole::create([
                'name' => $request->name,
                'staff_role_permission_id' => $permission,
                'isactive' => 'Y'
            ]);

            if($role) return redirect()->route('role')->with('success', 'เพิ่มตำแหน่ง '.$request->name.' เรียบร้อยแล้ว');
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
        }else{
            return redirect()->back()->with('error', 'ชื่อตำแหน่ง "'.$request->name.'" มีอยู่แล้ว กรุณาตรวจสอบ...');
        }
    }

    private function checkRoleName($name)
    {
        $checked = StaffRole::where('name', $name)->first();
        if($checked) return false;
        return true;
    }

    private function setPermisstion($request)
    {
        $permission = StaffRolePermission::create([
                        'user' => $this->setStatusPermission($request->user_check),
                        'admin' => $this->setStatusPermission($request->admin_check),
                        'level' => $this->setStatusPermission($request->level_check),
                        'role' => $this->setStatusPermission($request->role_check),
                        'payment_transaction' => $this->setStatusPermission($request->payment_transaction_check),
                    ]);

        return $permission->id;
    }

    private function setStatusPermission($status)
    {
        return $status == 'on' ? true : false;
    }

    public function edit($id)
    {
        $role = DB::table('staff_roles')
                    ->leftJoin('staff_role_permissions', 'staff_roles.staff_role_permission_id', '=', 'staff_role_permissions.id')
                    ->where('staff_roles.id', $id)
                    ->select(
                        'staff_roles.name', 'staff_roles.id as role_id', 'staff_roles.isactive', 
                        'staff_role_permissions.user', 'staff_role_permissions.level', 'staff_role_permissions.admin', 
                        'staff_role_permissions.role', 'staff_role_permissions.payment_transaction')
                    ->first();

        return view('staffroles.edit', ['role' => $role]);
    }

    public function update(Request $request)
    {
        $role = StaffRole::find($request->role_id);
        $check_name = $this->checkRoleName($request->name);

        if($check_name) {
            $permission = $this->updatePermission($role->staff_role_permission_id, $role->isactive, $request);

            if($permission) {
                if($role->isactive != 'EX') {
                    $role->update([
                        'name' => $request->name
                    ]);
                }

                return redirect()->route('role')->with('success', 'แก้ไขตำแหน่ง '.$request->name.' เรียบร้อยแล้ว');
            }

            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
        }else{
            return redirect()->back()->with('error', 'ชื่อตำแหน่ง "'.$request->name.'" มีอยู่แล้ว กรุณาตรวจสอบ...');
        }
    }

    private function updatePermission($id, $isactive,$request)
    {
        $permission = StaffRolePermission::where('id', $id)->update([
            'user' => $this->setStatusPermission($request->user_check),
            'admin' => $this->setStatusPermission($request->admin_check),
            'level' => $this->setStatusPermission($request->level_check),
            'role' => $isactive == 'EX' ? true : $this->setStatusPermission($request->role_check),
            'payment_transaction' => $this->setStatusPermission($request->payment_transaction_check)
        ]);

        if($permission) return true;
        return false;
    }

    public function delete($id)
    {
        $role = StaffRole::find($id);
        $role->update(['status' => 'VO', 'isactive' => 'N']);

        if($role) return redirect()->route('role')->with('success', 'ลบตำแหน่ง '.$role->name.' เรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }

    public function active($id)
    {
        $role = StaffRole::find($id);
        $isactive = $role->isactive == 'Y' ? 'N' : 'Y';
        $role->update(['isactive' => $isactive]);

        if($role) return redirect()->route('role')->with('success', 'แก้ไขสถานะตำแหน่ง '.$role->name.' เรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }
}
