<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CBankAccount;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CBankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cbank = CBankAccount::where('status', '!=', 'DL')->get();
        $banks = DB::table('banks')->get();
        return view('cbank.index', ['cbanks'=> $cbank, 'banks' => $banks]);
    }

    public function createCBank(Request $request)
    {
        $cbank = CBankAccount::create([
            "bank_name" => $request->bank_name,
            "account_name" => $request->account_name,
            "account_number" => $request->account_number,
            "is_active" => "Y",
            "status" => "CO"
        ]);

        if($cbank){
            return redirect()->back()->with('success', 'เพิ่มรายการธนาคารเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
    }

    public function editCBank(Request $request)
    {
        $is_active = $request->edit_active ? 'Y' : 'N';

        $cbank = CBankAccount::find($request->edit_id)->update([
            "bank_name" => $request->edit_bank_name,
            "account_name" => $request->edit_account_name,
            "account_number" => $request->edit_account_number,
            "is_active" => $is_active
        ]);

        if($cbank) {
            return redirect()->back()->with('success', 'แก้ไขบัญชีธนาคาร '.$request->edit_bank_name.' เรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่...');
    }

    public function deleteCBank(Request $request)
    {
        $trans = DB::table('payment_transactions')
                    ->where('c_bank_account_id', $request->id)
                    ->where('status', NULL)
                    ->first();

        if(!isset($trans)){
            CBankAccount::find($request->id)->update([
                'is_active' => 'N',
                'status' => 'DL'
            ]);

            return redirect()->back()->with('success', 'ลบบัญชีเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('warning', 'ยังมีรายการเคลื่อนไหวทางการเงินที่ยังไม่ได้ถูกจัดการ กรุณาจัดการก่อนลบบัญชี...');
    }

    public function statementCBank()
    {

    }
}
