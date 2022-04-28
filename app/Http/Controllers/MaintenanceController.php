<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Maintenance;
use App\Models\ApiGame;

class MaintenanceController extends Controller
{
    public function __constructor() {
        $this->middleware(['auth']);
    }

    public function index() {
        $mainten = Maintenance::where('status', 'DR')->with('api_game')->orderBy('created_at', 'DESC')->get();
        $games = ApiGame::where('isactive', 'Y')->where('status', 'CO')->get();
        return view('settings.maintenance.games.index', ['maintenance' => $mainten, 'games' => $games]);
    }

    public function store(Request $request) {
        $startdate = '';
        $now = false;
        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
            $this->setApiGameMaintenance($request->game, 'Y');
        }else{
            $startdate = $request->startdate;
        }

        $mainten = Maintenance::create([
            'api_game_id' => $request->game,
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'เพิ่มรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถเพิ่มรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function complete($id) {
        $mainten = Maintenance::find($id);
        $this->setApiGameMaintenance($mainten->api_game_id, 'N');
        $mainten->update(['status' => 'CO']);

        if($mainten && $game) return redirect()->back()->with('success', 'ปรับปรุงระบบเรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถยกเลิกการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function delete($id) {
        $mainten = Maintenance::find($id)->update(['status' => 'VO']);

        if($mainten) return redirect()->back()->with('success', 'ลบรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถลบรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    private function setApiGameMaintenance($id, $status) {
        ApiGame::find($id)->update(['maintenance' => $status]);
    }
}
