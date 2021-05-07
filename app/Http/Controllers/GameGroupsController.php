<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameGroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = DB::table('game_groups')->where('status', 'CO')->get();

        foreach($groups as $key => $group) {
            $games = DB::table('games')->where('game_group_id', $group->id)->where('status', 'CO')->count();
            $groups[$key]->games_count = $games;
        }

        return view('games.groups.index', ['groups' => $groups]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'group_name' => ['required'],
        ],
        [
            'group_name.required' => 'กรุณาระบุกลุ่มเกม'
        ]);

        $groups = DB::table('game_groups')
                ->insert([
                    'name' => $request->group_name,
                    'is_active' => 'Y',
                    'status' => 'CO',
                ]);
        if($groups) {
            return redirect()->back()->with('success', 'เพิ่มกลุ่มเกมเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }


    public function edit(Request $request)
    {
        $this->validate($request, [
            'edit_game_group_name' => ['required'],
        ],
        [
            'edit_game_group_name.required' => 'กรุณาระบุกลุ่มเกม'
        ]);

        $groups = DB::table('game_groups')->where('id', $request->edit_game_group_id)
                ->update([
                    'name' => $request->edit_game_group_name
                ]);

        if($groups) {
            return redirect()->back()->with('success', 'แก้ไขกลุ่มเกมเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }


    public function active(Request $request)
    {
        $group = DB::table('game_groups')->where('id', $request->id)->first();
        
        $is_active = $group->is_active == 'N' ? 'Y' : 'N';

        DB::table('game_groups')->where('id', $request->id)->update(['is_active' => $is_active]);

        return redirect()->back()->with('success', 'แก้ไขสถานะของกลุ่มเกม '. $request->group_name .' เรียบร้อยแล้ว');
    }

    public function groupActive(Request $request)
    {
        $group = DB::table('game_groups')->where('id', $request->active_game_group_id)->first();

        $is_active = $group->is_active == 'N' ? 'Y' : 'N';

        $games = DB::table('games')->where('game_group_id', $request->active_game_group_id)->get();
        foreach($games as $game) {
            DB::table('games')->where('id', $game->id)->update(['is_active' => $is_active]);
        }

        DB::table('game_groups')->where('id', $request->active_game_group_id)->update(['is_active' => $is_active]);

        return redirect()->back()->with('success', 'แก้ไขสถานะของกลุ่มเกม '. $request->group_name .' เรียบร้อยแล้ว');
    }

    
    public function delete(Request $request)
    {
        $games = DB::table('games')->where('game_group_id', $request->id)->count();
        if($games > 0) {
            DB::table('games')->where('game_group_id', $request->id)
                ->update([
                    'is_active' => 'N',
                    'status' => 'DL'
                ]);
        }
        
        DB::table('game_groups')->where('id', $request->id)->update([
            'is_active' => 'N',
            'status' => 'DL'
        ]);

        return redirect()->back()->with('success', 'ลบกลุ่มเกม '. $request->groups_name .' เรียบร้อยแล้ว');
    }

    public function gameList(Request $request)
    {
        $games = DB::table('games')
                ->where('game_group_id', $request->id)
                ->where('status', 'CO')
                ->get();

        $groups = DB::table('game_groups')->where('status', 'CO')->get();

        return view('games.groups.gamelist', ['is_group' => $request->group_name, 'group_id' => $request->id, 'games' => $games, 'groups' => $groups]);
    }

    public function gameTransfer(Request $request)
    {
        $group = DB::table('game_groups')->where('id', $request->group_id)->first();
        $game_active = DB::table('games')->where('id', $request->game_transfer_id)->first();

        $is_active = $group->is_active == 'N' ? 'N' : $game_active->is_active;

        $games = DB::table('games')->where('id', $request->game_transfer_id)
                ->update([
                    'game_group_id' => $request->group_id, 
                    'is_active' => $is_active
                ]);

        if($games) {
            return redirect()->back()->with('success', 'ย้ายกลุ่มเกมเรียบร้อยแล้ว');
        }

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }
}
