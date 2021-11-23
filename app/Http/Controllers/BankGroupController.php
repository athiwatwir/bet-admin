<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\BankGroup;
use App\Models\CBankAccount;

class BankGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $b_group = BankGroup::where('isdefault', 'Y')->withCount('banks')->first();
        $b_groups = BankGroup::where('isdefault', 'N')->withCount('banks')->orderBy('created_at', 'DESC')->get();

        return view('bankgroups.index', ['bank_groups' => $b_groups, 'group_default' => $b_group]);
    }

    public function create(Request $request)
    {
        if(!$this->checkNameDuplicate($request->name, NULL)) {
            $bgroup = BankGroup::create([
                'name' => $request->name,
            ]);

            if($bgroup) return redirect()->back()->with('success', 'เพิ่มข้อมูลกลุ่มธนาคาร "'.$request->name.'" เรียบร้อยแล้ว');
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล กรุณาลองใหม่...');
        }

        return redirect()->back()->with('error', '"'. $request->name .'" มีชื่อกลุ่มนี้อยู่ในระบบแล้ว กรุณาแก้ไข...');
    }

    private function checkNameDuplicate($name, $id)
    {
        if(!isset($id)) $check = BankGroup::where('name', $name)->first();
        else $check = BankGroup::where('id', '!=', $id)->where('name', $name)->first();
        
        if(isset($check)) return true;
        return false;
    }

    public function edit(Request $request)
    {
        if(!$this->checkNameDuplicate($request->name, $request->id)) {
            $is_active = $request->isactive ? 'Y' : 'N';
            $is_default = $request->isdefault ? 'Y' : 'N';
            if($request->isdefault) {
                $this->unDefault();
                $is_active = 'Y';
            }

            $bgroup = BankGroup::find($request->id)->update([
                'name' => $request->name,
                'isactive' => $is_active,
                'isdefault' => $is_default
            ]);

            if($bgroup) return redirect()->back()->with('success', 'แก้ไขข้อมูลกลุ่มธนาคาร "'.$request->name.'" เรียบร้อยแล้ว');
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล กรุณาลองใหม่...');
        }

        return redirect()->back()->with('error', '"'. $request->name .'" มีชื่อกลุ่มนี้อยู่ในระบบแล้ว กรุณาแก้ไข...');
    }

    public function active($id)
    {
        $bgroup = BankGroup::find($id);
        $status = $bgroup->isactive == 'Y' ? 'N' : 'Y';
        $bgroup->update(['isactive' => $status]);

        if($bgroup) return redirect()->back()->with('success', 'แก้ไขข้อมูลกลุ่มธนาคาร "'.$bgroup->name.'" เรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล กรุณาลองใหม่...');
    }

    private function unDefault()
    {
        BankGroup::where('isdefault', 'Y')->update(['isdefault' => 'N']);
    }

    public function delete($id)
    {
        $bg_delete = BankGroup::find($id)->delete();
        if($bg_delete) {
            $this->unGroupBank($id);
            return redirect()->route('bankgroups')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว');
        }
        return redirect()->route('bankgroups')->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่...');
    }

    private function unGroupBank($id)
    {
        CBankAccount::where('bank_group_id', $id)->update(['bank_group_id' => NULL]);
    }

    public function view($id)
    {
        // get bank_groups data from id
        $b_group = BankGroup::where('id', $id)->withCount('banks')->first();

        // get bank_groups for dropdown select transfer
        $bt_groups = BankGroup::where('id', '!=', $id)->withCount('banks')->get();

        // get c_bank_accounts in bank_groups
        $c_banks_group = DB::table('c_bank_accounts')
                            ->leftJoin('banks', 'c_bank_accounts.bank_id', '=', 'banks.id')
                            ->where('c_bank_accounts.bank_group_id', $id)
                            ->select('c_bank_accounts.*', 'banks.name as b_name_th')
                            ->get();
                            
        // get c_bank_accounts avaliable
        $c_banks_avaliable = DB::table('c_bank_accounts')
                    ->leftJoin('banks', 'c_bank_accounts.bank_id', '=', 'banks.id')
                    ->where('c_bank_accounts.is_active', 'Y')
                    ->where('c_bank_accounts.bank_group_id', NULL)
                    ->select('c_bank_accounts.*', 'banks.name as b_name_th')
                    ->get();
                    
        return view('bankgroups.view', ['bgroup' => $b_group, 'bt_groups' => $bt_groups, 'cbanks' => $c_banks_avaliable, 'cbgroups' => $c_banks_group]);
    }

    public function add(Request $request)
    {
        foreach($request->bank_select as $bank) {
            CBankAccount::find($bank)->update(['bank_group_id' => $request->group_id]);
        }
        return redirect()->back();
    }

    public function cancle($id)
    {
        $cbank = CBankAccount::find($id)->update(['bank_group_id' => NULL]);

        if($cbank) return redirect()->back()->with('success', 'ลบธนาคารออกจากกลุ่มเรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการลบข้อมูล กรุณาลองใหม่...');
    }

    public function transfer(Request $request)
    {
        $transfer = CBankAccount::find($request->transfer_id)->update(['bank_group_id' => $request->transer_to]);
        
        if($transfer) return redirect()->back()->with('success', 'ย้ายธนาคารออกจากกลุ่มเรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการย้ายธนาคาร กรุณาลองใหม่...');
    }

    public function getAllBankGroups()
    {
        return BankGroup::where('isactive', 'Y')->withCount('banks')->get();
    }

    public function getBankGroupDefault()
    {
        return BankGroup::where('isdefault', 'Y')->first();
    }
}
