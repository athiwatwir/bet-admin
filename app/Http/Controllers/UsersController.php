<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('is_admin', '=', 'N')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $inactive = [];
        $active = [];
        $deleted = [];
        foreach ($users as $key => $user) {
            if($user->status == 'DL'){
                array_push($deleted, $user);
            }else{
                if($user->is_active == 'N') array_push($inactive, $user);
                if($user->is_active == 'Y') array_push($active, $user);
            }
        }

        return view('user.index', ['users' => $users, 'inactive' => $inactive, 'active' => $active, 'deleted' => $deleted]);
    }

    public function active(Request $request)
    {
        $user = User::find($request->id)->update([
            'is_active' => 'Y'
        ]);

        return redirect()->back()->with('success', 'แก้ไขสถานะผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }

    public function view(Request $request)
    {

    }

    public function delete(Request $request)
    {
        $user = User::find($request->id)->update([
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }
}
