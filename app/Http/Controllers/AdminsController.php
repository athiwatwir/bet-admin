<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $admins = User::where('is_admin', '=', 'Y')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $inactive = [];
        $active = [];
        $deleted = [];
        foreach ($admins as $key => $admin) {
            if($admin->status == 'DL'){
                array_push($deleted, $admin);
            }else{
                if($admin->is_active == 'N') array_push($inactive, $admin);
                if($admin->is_active == 'Y') array_push($active, $admin);
            }
        }

        return view('admin.index', ['admins' => $admins, 'inactive' => $inactive, 'active' => $active, 'deleted' => $deleted]);
    }

    public function register(Request $request)
    {
        $random = Str::random(10);

        $this->validate($request, [
            'username' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:10'],
        ]);
 
        $checkUser = User::where('username', $request->username)
                    ->orWhere('phone', $request->phone)
                    ->orWhere('line', $request->line)
                    ->where('line', '!=', null)
                    ->first();

        if(!isset($checkUser)){
            $user = User::create([
                "username" => $request->username,
                "password" => $random,
                "name" => $request->name,
                "phone" => $request->phone,
                "line" => $request->line,
                "currency" => "none",
                "how_to_know" => "none",
                "is_active" => "Y",
                "status" => "CO",
                "is_admin" => "Y"
            ]);
        }

        return redirect()->back()->with('success', 'ลงทะเบียนเรียบร้อย');
    }

    public function active(Request $request)
    {
        $admin = User::find($request->id);
        
        $is_active = $admin->is_active == 'N' ? 'Y' : 'N';

        $admin->update([
            'is_active' => $is_active
        ]);

        return redirect()->back()->with('success', 'แก้ไขสถานะ Admin '. $request->username .' เรียบร้อยแล้ว');
    }

    public function delete(Request $request)
    {
        $admin = User::find($request->id)->update([
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }
}
