<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\UsersController;

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


    public function promotionWalletAmount(Request $request)
    {
        $payment_transaction_id = $this->saveToPaymentTransaction($request->description, $request->amount);
        if($payment_transaction_id != false) {
            if($request->level_user) {
                if(!isset($request->level)) return redirect()->back()->with('error', 'กรุณาเลือกกลุ่มลูกค้า');
                foreach($request->level as $level) {
                    $users = (new UsersController)->getUserByLevelId($level);
                    $this->getUsersWallet($users, $payment_transaction_id);
                }
            }

            if($request->all_user) {
                $users = (new UsersController)->getUserAll();
                $this->getUsersWallet($users, $payment_transaction_id);
            }
            
            return redirect()->back()->with('success', 'เรียบร้อยแล้ว');
        }
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }

    private function getUsersWallet($users, $payment_transaction_id)
    {
        foreach($users as $user) {
            $wallet = DB::table('wallets')->where('user_id', $user->id)->where('is_default', 'Y')->first();
            if(isset($wallet)) {
                // $is_amount = $wallet->amount." + ".$amount." = ".($wallet->amount + $amount);
                // Log::debug($is_amount);
                
                $this->saveToPromotionTransaction($wallet->id, $payment_transaction_id, $user->user_level_id);
            }
        }
    }

    private function saveToPaymentTransaction($promotion, $amount)
    {
        $transId = Str::uuid();
        $inserted = DB::table('payment_transactions')->insert([
                        'id' => $transId,
                        'staff_id' => Auth::user()->id,
                        'action_date' => date('Y-m-d H:i:s'),
                        'code' => 'ADJUST',
                        'code_status' => 'Promo',
                        'amount' => $amount,
                        'description' => $promotion,
                        'status' => 'DR',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

        if($inserted) return $transId;

        return false;
    }

    private function saveToPromotionTransaction($wallet_id, $payment_transaction_id, $user_level_id)
    {
        $transId = Str::uuid();
        DB::table('payment_transaction_promotions')->insert([
            'id' => $transId,
            'wallet_id' => $wallet_id,
            'payment_transaction_id' => $payment_transaction_id,
            'user_level_id' => $user_level_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
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
