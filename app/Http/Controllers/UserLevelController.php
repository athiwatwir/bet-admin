<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\UserLevel;

class UserLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $level = UserLevel::orderBy('name', 'ASC')->paginate(10);
        return view('userlevel.index', ['levels' => $level]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'levelname' => ['required', 'string', 'max:255'],
            'limit_deposit' => ['required', 'max:255'],
            'limit_withdraw' => ['required', 'max:255'],
            'limit_transfer' => ['required']
        ],
        [
            'levelname.required' => 'กรุณาระบุชื่อเลเวล',
            'limit_deposit.required' => 'กรุณาระบุยอดฝากได้สูงสุด',
            'limit_withdraw.required' => 'กรุณาระบุยอดถอนได้สูงสุด',
            'limit_transfer.required' => 'กรุณาระบุยอดโอนได้สูงสุด',
        ]);

        $default = isset($request->is_default) ? 'Y' : 'N';

        $level = UserLevel::create([
            'name' => $request->levelname,
            'limit_deposit' => $request->limit_deposit,
            'limit_withdraw' => $request->limit_withdraw,
            'limit_transfer' => $request->limit_transfer,
            'isdefault' => $default
        ]);

        if($level) {
            return redirect()->back()->with('success', 'เพิ่มเลเวลผู้ใช้เรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'levelname' => ['required', 'string', 'max:255'],
            'limit_deposit' => ['required', 'max:255'],
            'limit_withdraw' => ['required', 'max:255'],
            'limit_transfer' => ['required']
        ],
        [
            'levelname.required' => 'กรุณาระบุชื่อเลเวล',
            'limit_deposit.required' => 'กรุณาระบุยอดฝากได้สูงสุด',
            'limit_withdraw.required' => 'กรุณาระบุยอดถอนได้สูงสุด',
            'limit_transfer.required' => 'กรุณาระบุยอดโอนได้สูงสุด',
        ]);

        if(isset($request->is_default)) {
            $this->setDefault($request->id);
        }

        $level = UserLevel::find($request->id)->update([
            'name' => $request->levelname,
            'limit_deposit' => $request->limit_deposit,
            'limit_withdraw' => $request->limit_withdraw,
            'limit_transfer' => $request->limit_transfer
        ]);

        if($level) {
            return redirect()->back()->with('success', 'แก้ไขเลเวลผู้ใช้เรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function active($id, $name)
    {
        $user_level = UserLevel::find($id);
        $status = $user_level->isactive == 'Y' ? 'N' : 'Y';
        $user_level->update(['isactive' => $status]);

        if($user_level) return redirect()->back()->with('success', 'ปรับการแสดงผลกลุ่มลูกค้า '.$name.' เรียบร้อยแล้ว...');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    private function setDefault($id)
    {
        UserLevel::where('isdefault', 'Y')->update(['isdefault' => 'N']);
        UserLevel::find($id)->update(['isactive' => 'Y', 'isdefault' => 'Y']);
    }

    public function delete($id)
    {
        UserLevel::find($id)->delete();
    }

    public function getAllUserLevel()
    {
        return UserLevel::where('isactive', 'Y')->get();
    }

    public function getUserLevelById($id)
    {
        return UserLevel::find($id)->get();
    }
}
