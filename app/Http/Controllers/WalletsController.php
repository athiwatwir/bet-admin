<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\PaymentTransactionController;

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


    public function increaseWalletAmount(Request $request)
    {
        $this->validate($request, [
            'wallet_amount' => ['required'],
            'is_reason' => ['required', 'string', 'max:255'],
        ]);

        $wallet = DB::table('wallets')->where('id', $request->wallet_id)->first();

        $trans = (new PaymentTransactionController)->insertTransactionByAdmin($request->wallet_amount, $request->is_reason, 'เพิ่ม', $wallet->user_id, $request->wallet_id);
        if($trans) {
            // $wallet_increase = $wallet->amount + $request->wallet_amount;
            // $wallet_query = DB::table('wallets')->where('id', $request->wallet_id)->update(['amount' => $wallet_increase]);

            // if($wallet_query) return redirect()->back()->with('success', 'แก้ไขจำนวนเงินเรียบร้อยแล้ว');

            // return redirect()->back()->with('error', 'เกิดข้อผิดพลาดกรุณาลองใหม่');
            return redirect()->back()->with('success', 'กำลังส่งคำร้องขอไปยังผู้ดูแลระบบที่รับผิดชอบ');
        }
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด Transaction');
    }

    public function decreaseWalletAmount(Request $request)
    {
        $this->validate($request, [
            'wallet_amount' => ['required'],
            'is_reason' => ['required', 'string', 'max:255'],
        ]);

        $wallet = DB::table('wallets')->where('id', $request->wallet_id)->first();
        // Log::debug($wallet);
        if($wallet->amount > $request->wallet_amount) {
            $trans = (new PaymentTransactionController)->insertTransactionByAdmin($request->wallet_amount, $request->is_reason, 'ลด', $wallet->user_id, $request->wallet_id);
            if($trans) {
                // $wallet_decrease = $wallet->amount - $request->wallet_amount;
                // $wallet_query = DB::table('wallets')->where('id', $request->wallet_id)->update(['amount' => $wallet_decrease]);
    
                // if($wallet_query) return redirect()->back()->with('success', 'แก้ไขจำนวนเงินเรียบร้อยแล้ว');
    
                // return redirect()->back()->with('error', 'เกิดข้อผิดพลาดกรุณาลองใหม่');
                return redirect()->back()->with('success', 'กำลังส่งคำร้องขอไปยังผู้ดูแลระบบที่รับผิดชอบ');
            }
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด Transaction');
        }
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดจำนวนเงินไม่ถูกต้อง');
    }



    // For Call Function
    public function getDefaultWalletByUserId($id)
    {
        return DB::table('wallets')
                    ->leftJoin('games', 'wallets.game_id', '=', 'games.id')
                    ->where('wallets.user_id', $id)
                    ->where('wallets.is_default', 'Y')
                    ->select(['wallets.id', 'wallets.amount', 'wallets.currency', 'games.name as game_name'])
                    ->first();
    }

    public function getWalletsByUserId($id)
    {
        return DB::table('wallets')
                    ->leftJoin('games', 'wallets.game_id', '=', 'games.id')
                    ->where('wallets.user_id', $id)
                    ->where('wallets.status', 'CO')
                    ->where('wallets.is_default', 'N')
                    ->select(['wallets.id', 'wallets.amount', 'wallets.currency', 'games.name as game_name'])
                    ->paginate(10);
    }
}
