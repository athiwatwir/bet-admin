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
        $users = User::where('is_admin', 'N')
                    ->where('status', 'CO')
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10);

        $deleted = DB::table('users')
                    ->where('is_admin', 'N')
                    ->where('status', 'DL')
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10);

        $is_user = json_decode($users);
        $inactive = [];
        $active = [];
        foreach ($users as $key => $user) {
            // $wallet = $this->getWallets($user->id);
            // $user->is_wallet = json_decode($wallet, true);

            if($user->is_active == 'N') array_push($inactive, $user);
            if($user->is_active == 'Y') array_push($active, $user);

            // Log::debug($active);
            // $users[$key]->data->user_active = $active;

        }
        // $users->user_active = $active;
        // Log::debug($users);

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
            'is_active' => 'N',
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }

    private function getWallets($id)
    {
        return DB::table('wallets')->where('user_id', $id)->get();
    }
}
