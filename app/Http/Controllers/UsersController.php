<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\DB;
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
                    ->where('status', 'CO')
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10);

        $is_user = json_decode($users);
        $isUser = [];
        $inactive = [];
        $active = [];
        $deleted = [];
        foreach ($users as $key => $user) {
            $wallet = $this->getWallets($user->id);
            $user->is_wallet = json_decode($wallet, true);

            if($user->status == 'DL'){
                array_push($deleted, $user);
            }else{
                if($user->is_active == 'N') array_push($inactive, $user);
                if($user->is_active == 'Y') array_push($active, $user);
            }
            array_push($isUser, $user);
        }
        $combine_user = json_encode($isUser);

        return view('user.index', ['users' => $users, 'inactive' => $inactive, 'active' => $active, 'deleted' => $deleted]);
    }

    public function active(Request $request)
    {
        $user = User::find($request->id);

        $is_active = $user->is_active == 'N' ? 'Y' : 'N';

        $user->update([
            'is_active' => $is_active
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

    private function getWallets($id)
    {
        return DB::table('wallets')->where('user_id', $id)->get();
    }
}
