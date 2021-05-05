<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BanksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $banks = DB::table('banks')->where('status', 'CO')->paginate(50);
        return view('banks.index', ['banks' => $banks]);
    }

    public function add(Request $request)
    {
        $bank = DB::table('banks')
                ->insert([
                    'name' => $request->bank_name,
                    'name_en' => $request->bank_name_en,
                    'is_active' => 'Y',
                    'status' => 'CO',
                ]);

        if($bank){
            return redirect()->back()->with('success', 'เพิ่มรายการธนาคารเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function edit(Request $request)
    {
        $bank = DB::table('banks')->where('id', $request->edit_bank_id)
            ->update([
                'name' => $request->edit_bank_name,
                'name_en' => $request->edit_bank_name_en
            ]);

        if($bank){
            return redirect()->back()->with('success', 'แก้ไขรายการธนาคารเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function active(Request $request)
    {
        $bank = DB::table('banks')->where('id', $request->id)->first();
        
        $is_active = $bank->is_active == 'N' ? 'Y' : 'N';

        DB::table('banks')->where('id', $request->id)->update([
            'is_active' => $is_active
        ]);

        return redirect()->back()->with('success', 'แก้ไขสถานะธนาคาร '. $request->bank_name .' เรียบร้อยแล้ว');
    }

    public function delete(Request $request)
    {
        DB::table('banks')->where('id', $request->id)->update([
            'is_active' => 'N',
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบผู้ใช้งาน '. $request->bank_name .' เรียบร้อยแล้ว');
    }
}
