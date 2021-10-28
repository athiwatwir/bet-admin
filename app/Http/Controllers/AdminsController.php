<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Staff;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admins = Staff::where('status', 'CO')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $deleted = DB::table('staffs')
                    ->where('status', 'DL')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $inactive = [];
        $active = [];
        $all = [];
        foreach ($admins as $key => $admin) {
            if($admin->is_active == 'N') array_push($inactive, $admin);
            if($admin->is_active == 'Y') array_push($active, $admin);
        }

        return view('admin.index', ['admins' => $admins, 'inactive' => $inactive, 'active' => $active, 'deleted' => $deleted]);
    }

    public function view(Request $request)
    {
        $admin = DB::table('staffs')->find($request->id);

        return view('admin.view', ['profile' => $admin, 'username' => $request->username]);
    }

    public function register(Request $request)
    {
        // $random = Str::random(10);

        $this->validate($request, [
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:10'],
        ]);
 
        $checkUser = Staff::where('username', $request->username)
                    ->orWhere('phone', $request->phone)
                    ->orWhere('line', $request->line)
                    ->where('line', '!=', null)
                    ->first();

        if(!isset($checkUser)){
            $user = Staff::create([
                "username" => $request->username,
                "password" => $request->password,
                "name" => $request->name,
                "phone" => $request->phone,
                "line" => $request->line,
                "is_active" => "Y",
                "status" => "CO",
            ]);
        }

        return redirect()->back()->with('success', 'ลงทะเบียนเรียบร้อย');
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'edit_name' => ['required', 'string', 'max:255'],
            'edit_phone' => ['required', 'string', 'min:10', 'max:10'],
        ]);

        $checkUser = Staff::where('phone', $request->phone)
                    ->orWhere('line', $request->line)
                    ->where('line', '!=', null)
                    ->first();

        if(!isset($checkUser)){
            $admin = Staff::find($request->edit_id)->update([
                'name' => $request->edit_name,
                'phone' => $request->edit_phone,
                'line' => $request->edit_line
            ]);

            return redirect()->back()->with('success', 'แก้ไขรายละเอียด Admin '. $request->edit_username .' เรียบร้อยแล้ว');
        }else{
            return redirect()->back()->with('warning', 'มีข้อมูลซ้ำกัน กรุณาตรวจสอบ');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด');
    }

    public function rePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => ['required', 'string', 'max:255'],
        ]);

        $admin = Staff::find($request->admin_id)->update([
            'password' => $request->new_password,
        ]);

        return redirect()->back()->with('success', 'แก้ไขรหัสผ่านเรียบร้อยแล้ว');
    }

    public function active(Request $request)
    {
        $admin = Staff::find($request->id);
        
        $is_active = $admin->is_active == 'N' ? 'Y' : 'N';

        $admin->update([
            'is_active' => $is_active
        ]);

        return redirect()->back()->with('success', 'แก้ไขสถานะ Admin '. $request->username .' เรียบร้อยแล้ว');
    }

    public function delete(Request $request)
    {
        $admin = Staff::find($request->id)->update([
            'is_active' => 'N',
            'status' => 'DL'
        ]);

        return redirect()->route('admins')->with('success', 'ลบผู้ดูแลระบบ '. $request->username .' เรียบร้อยแล้ว');
    }
}
