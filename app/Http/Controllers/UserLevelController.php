<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\UserLevel;
use App\Models\User;
use App\Models\UserLevelApiGame;

class UserLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:level']);
    }

    public function index()
    {
        $level_default = UserLevel::where('isdefault', 'Y')->withCount('users')->first();
        $level = UserLevel::where('status', 'CO')->where('isdefault', 'N')->orderBy('name', 'ASC')->withCount('users')->get();
        return view('userlevel.index', ['default' => $level_default, 'levels' => $level]);
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
        $default_level = UserLevel::where('isdefault', 'Y')->first();
        $users = User::where('user_level_id', $id)->get();
        foreach($users as $user) {
            User::find($user->id)->update(['user_level_id' => $default_level->id]);
        }

        $user_level_deleted = UserLevel::find($id)->update(['status' => 'VO']);
        if($user_level_deleted) return redirect()->back()->with('success', 'ลบกลุ่มลูกคาเรียบร้อยแล้ว');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function getAllUserLevel()
    {
        return UserLevel::where('isactive', 'Y')->where('status', 'CO')->get();
    }

    public function getUserLevelById($id)
    {
        return UserLevel::find($id);
    }

    public function settingApiGame(Request $request)
    {
        $this->beforeSettingApiGame($request->userlevel_id);

        foreach($request->api_game_id as $game) {
            UserLevelApiGame::updateOrCreate(
                [
                    'user_level_id' => $request->userlevel_id,
                    'api_game_id' => $game
                ],
                [
                    'isactive' => 'Y'
                ]
            );
        }

        return redirect()->back();
    }

    private function beforeSettingApiGame($userlevel_id)
    {
        UserLevelApiGame::where('user_level_id', $userlevel_id)->update(['isactive' => 'N']);
    }
}
