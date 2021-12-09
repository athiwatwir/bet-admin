<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $admin = Staff::where('username', $request->username)->first();
        if(isset($admin)) {
            if($admin->is_active != 'Y' || $admin->status != 'CO') {
                return redirect()->back()->with('error', 'Invalid Credentials');
            }

            if(Auth::guard('webadmin')->attempt($request->only(['username', 'password']))) {
                $permission = $this->adminPermission($admin->id);
                $this->setPermission($permission);
                return redirect()->route('dashboard');
            }

            return redirect()->back()->with('error', 'Invalid Credentials');
        }
        
        return redirect()->back()->with('error', 'Invalid Credentials');
    }

    private function adminPermission($id)
    {
        $admin = DB::table('staffs')
                    ->leftJoin('staff_roles', 'staffs.staff_role_id', '=', 'staff_roles.id')
                    ->leftJoin('staff_role_permissions', 'staff_roles.staff_role_permission_id', '=', 'staff_role_permissions.id')
                    ->where('staffs.id', $id)
                    ->select(
                        'staff_roles.name', 'staff_role_permissions.user', 'staff_role_permissions.level',
                        'staff_role_permissions.admin', 'staff_role_permissions.role', 'staff_role_permissions.payment_transaction')
                    ->first();

        return $admin;
    }

    private function setPermission($permission)
    {
        session(['_p' => [
            'position' => $permission->name,
            'user' => $permission->user,
            'level' => $permission->level,
            'admin' => $permission->admin,
            'role' => $permission->role,
            'payment_transaction' => $permission->payment_transaction
        ]]);
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        session()->forget(['_p']);

        return redirect()->route('login');
    }
}
