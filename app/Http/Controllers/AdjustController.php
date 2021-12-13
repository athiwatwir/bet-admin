<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PaymentTransactionController;
use App\Models\Wallet;

class AdjustController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:adjust']);
    }

    public function index()
    {
        $adjust = (new PaymentTransactionController)->isRequestAdjust();
        return view('adjust.index', ['adjusts' => $adjust]);
    }

    public function update($id)
    {
        $trans = (new PaymentTransactionController)->getPaymentTransactionById($id)[0];
        $wallet = $this->getWalletById($trans->to_wallet_id);
        if($trans->code_status == 'Plus') {
            $wallet_increase = $wallet->amount + $trans->amount;
            $wallet->update(['amount' => $wallet_increase]);
        }else if($trans->code_status == 'Minus') {
            $wallet_decrease = $wallet->amount - $trans->amount;
            $wallet->update(['amount' => $wallet_decrease]);
        }

        $update_trans = $this->updatePaymentTransaction($id, 'CO');

        if($update_trans) {
            $this->updatePaymentTransactionLog($id, 'CO');
            return redirect()->back()->with('success', 'ยืนยันจำนวนเงินเรียบร้อยแล้ว');
        }
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดกรุณาลองใหม่');
    }

    public function void($id)
    {
        $this->updatePaymentTransaction($id, 'VO');
        $this->updatePaymentTransactionLog($id, 'VO');
        return redirect()->back()->with('success', 'ยกเลิกคำร้องเรียบร้อยแล้ว');
    }

    private function getWalletById($id)
    {
        return Wallet::find($id);
    }

    private function updatePaymentTransaction($id, $status)
    {
        return DB::table('payment_transactions')->where('id', $id)->update(['status' => $status]);
    }

    private function updatePaymentTransactionLog($id, $status)
    {
        DB::table('payment_transaction_logs')->where('payment_transaction_id', $id)
                ->update([
                    'status' => $status,
                    'admin_id' => Auth::user()->id
                ]);
    }
}
