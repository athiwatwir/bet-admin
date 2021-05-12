<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $wallets = DB::table('wallets')
                ->where('user_id', $request->id)
                ->where('status', 'CO')
                ->where('is_default', 'N')
                ->select(['id', 'game_id', 'amount', 'currency'])
                ->paginate(10);

        $default_wallet = DB::table('wallets')
                ->where('user_id', $request->id)
                ->where('is_default', 'Y')
                ->select(['id', 'amount', 'currency'])
                ->first();

        return view('user.wallets', ['wallets' => $wallets, 'default_wallet' => $default_wallet,'username' => $request->username]);
    }

    public function editWalletAmount(Request $request)
    {
        $this->validate($request, [
            'wallet_amount' => ['required'],
        ],
        [
            'wallet_amount.required' => 'กรุณาระบุตัวเลข'
        ]);

        DB::table('wallets')->where('id', $request->wallet_id)->update(['amount' => $request->wallet_amount]);
        return redirect()->back()->with('success', 'แก้ไขจำนวนเงินเรียบร้อยแล้ว');
    }
}
