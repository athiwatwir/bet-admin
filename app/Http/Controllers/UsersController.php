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
        $users = User::where('status', '!=', 'DL')
                    ->where('is_admin', '=', 'N')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('user.index', ['users' => $users]);
    }

    public function active(Request $request)
    {
        $user = User::find($request->id)->update([
            'is_active' => 'Y'
        ]);

        return redirect()->back()->with('success', 'แก้ไขสถานะผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id)->update([
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }
}
