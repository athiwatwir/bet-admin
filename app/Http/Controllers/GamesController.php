<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $games = DB::table('games')
                ->leftJoin('game_groups', 'games.game_group_id', '=', 'game_groups.id')
                ->where('games.status', 'CO')
                ->select(['games.*', 'game_groups.id as group_id', 'game_groups.name as group_name'])
                ->paginate(10);

        $groups = DB::table('game_groups')->where('status', 'CO')->where('is_active', 'Y')->get();

        return view('games.index', ['games' => $games, 'groups' => $groups]);
    }


    public function create(Request $request)
    {
        // Log::debug($request);
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255'],
            'game_group_id' => ['required']
        ],
        [
            'name.required' => 'กรุณาระบุชื่อเกม',
            'url.required' => 'กรุณาระบุ url',
            'token.required' => 'กรุณาระบุ token',
            'game_group_id.required' => 'กรุณาเลือกกลุ่มเกม',
        ]);

        $fileName = time().'_'.$request->logo->getClientOriginalName();
        $request->logo->move(public_path('/logogames'), $fileName);

        $games = DB::table('games')
                ->insert([
                    'id' => Str::uuid(),
                    'game_group_id' => $request->game_group_id,
                    'name' => $request->name,
                    'url' => $request->url,
                    'token' => $request->token,
                    'logo' => $fileName,
                    'is_active' => 'Y',
                    'status' => 'CO'
                ]);

        if($games) {
            return redirect()->back()->with('success', 'เพิ่มเกมเข้าสู่ระบบเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'edit_game_name' => ['required', 'string', 'max:255'],
            'edit_game_url' => ['required', 'string', 'max:255'],
            'edit_game_token' => ['required', 'string', 'max:255'],
        ],
        [
            'name.required' => 'กรุณาระบุชื่อเกม',
            'url.required' => 'กรุณาระบุ url',
            'token.required' => 'กรุณาระบุ token',
        ]);

        // Log::debug($request);
        $games = DB::table('games')->where('id', $request->edit_game_id)
                ->update([
                    'name' => $request->edit_game_name,
                    'url' => $request->edit_game_url,
                    'token' => $request->edit_game_token,
                ]);
        if(isset($request->logo)) {
            $getLogo = DB::table('games')->where('id', $request->edit_game_id)->first();
            if(isset($getLogo->logo)) unlink(public_path('logogames/'.$getLogo->logo));

            $fileName = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move(public_path('/logogames'), $fileName);

            DB::table('games')->where('id', $getLogo->id)->update(['logo' => $fileName]);
        }

        if($games) {
            return redirect()->back()->with('success', 'แก้ไขเกม '. $request->edit_game_name .' เรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }


    public function active(Request $request)
    {
        $game = DB::table('games')->where('id', $request->id)->first();
        
        $is_active = $game->is_active == 'N' ? 'Y' : 'N';

        DB::table('games')->where('id', $request->id)->update(['is_active' => $is_active]);

        return redirect()->back()->with('success', 'แก้ไขสถานะของเกม '. $request->game_name .' เรียบร้อยแล้ว');
    }


    public function delete(Request $request)
    {
        DB::table('games')->where('id', $request->id)->update(['is_active' => 'N','status' => 'DL']);

        return redirect()->back()->with('success', 'ลบเกม '. $request->game_name .' ออกจากระบบเรียบร้อยแล้ว');
    }
}
