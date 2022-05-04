<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;

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
        return view('settings.maintenance.index', ['maintenance' => $mainten, 'games' => $games]);
    }

    public function delete($id) {
        $mainten = Maintenance::find($id)->update(['status' => 'VO']);

        if($mainten) return redirect()->back()->with('success', 'ลบรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถลบรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    private const PRIVATE_KEY = 'f0df03ef-7814-4b38-8f33-f53a03e69e94';



    // Game //////////////////////////////////

    public function gameStore(Request $request) {
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

    public function gameEdit($id) {
        $mainten = Maintenance::find($id);
        $games = ApiGame::where('isactive', 'Y')->where('status', 'CO')->get();
        return view('settings.maintenance.games.edit', ['mainten' => $mainten, 'games' => $games]);
    }

    public function gameUpdate(Request $request) {
        $startdate = '';
        $now = false;
        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
            $this->setApiGameMaintenance($request->game, 'Y');
        }else{
            $startdate = $request->startdate;
        }

        $mainten = Maintenance::find($request->id)->update([
            'api_game_id' => $request->game,
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'แก้ไขรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถแก้ไขรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function gameComplete($id) {
        $mainten = Maintenance::find($id);
        $this->setApiGameMaintenance($mainten->api_game_id, 'N');
        $mainten->update(['status' => 'CO']);

        if($mainten) return redirect()->back()->with('success', 'ปรับปรุงระบบเรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถยกเลิกการปิดปรับปรุงได้ในตอนนี้...');
    }

    private function setApiGameMaintenance($id, $status) {
        ApiGame::find($id)->update(['maintenance' => $status]);
    }



    // Transaction /////////////////////////////

    public function transactionStore(Request $request) {
        $startdate = '';
        $now = false;
        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
        }else{
            $startdate = $request->startdate;
        }

        $mainten = Maintenance::create([
            'transaction' => $request->type,
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'เพิ่มรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถเพิ่มรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function transactionEdit($id) {
        $mainten = Maintenance::find($id);
        return view('settings.maintenance.transaction.edit', ['mainten' => $mainten]);
    }

    public function transactionUpdate(Request $request) {
        $startdate = '';
        $now = false;
        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
        }else{
            $startdate = $request->startdate;
        }

        $mainten = Maintenance::find($request->id)->update([
            'transaction' => $request->type,
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'แก้ไขรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถแก้ไขรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function transactionComplete($id) {
        $mainten = Maintenance::find($id)->update(['status' => 'CO']);

        if($mainten) return redirect()->back()->with('success', 'ปรับปรุงระบบเรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถยกเลิกการปิดปรับปรุงได้ในตอนนี้...');
    }


    // Website /////////////////////////////////////

    public function websiteStore(Request $request) {
        $startdate = '';
        $now = false;
        $secret_key = Str::uuid();
        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
            $this->setWebsiteMaintenanceDown($secret_key, $startdate, $request->enddate, $request->description);
        }else{
            $startdate = $request->startdate;
        }

        $mainten = Maintenance::create([
            'secretkey' => $secret_key,
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'เพิ่มรายการปิดปรับปรุงเว็บไซต์ เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถเพิ่มรายการปิดปรับปรุงเว็บไซต์ได้ในตอนนี้...');

        return redirect()->back();
    }

    public function websiteEdit($id) {
        $mainten = Maintenance::find($id);
        return view('settings.maintenance.website.edit', ['mainten' => $mainten]);
    }

    public function websiteUpdate(Request $request) {
        $startdate = '';
        $now = false;

        $mainten = Maintenance::find($request->id);

        if(isset($request->now)) {
            $startdate = date('Y-m-d H:i:s');
            $now = true;
            $this->setWebsiteMaintenanceDown($mainten->secretkey, $startdate, $request->enddate, $request->description);
        }else{
            $startdate = $request->startdate;
        }

        $mainten->update([
            'startdate' => $startdate,
            'enddate' => $request->enddate,
            'description' => $request->description,
            'now' => $now
        ]);

        if($mainten) return redirect()->back()->with('success', 'แก้ไขรายการปิดปรับปรุง เรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถแก้ไขรายการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function websiteComplete($id) {
        $mainten = Maintenance::find($id);
        $this->setWebsiteMaintenanceUp($mainten->secretkey);
        $mainten->update(['status' => 'CO']);

        if($mainten) return redirect()->back()->with('success', 'ปรับปรุงระบบเรียบร้อยแล้ว...');
        return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด ไม่สามารถยกเลิกการปิดปรับปรุงได้ในตอนนี้...');
    }

    public function setWebsiteMaintenanceDown($secret_key, $startdate, $enddate, $description) {
        Http::post(RouteServiceProvider::CLIENT_API.'/api/set/the/website/maintenance/down',[
            'secret_key' => $secret_key,
            'private_key' => self::PRIVATE_KEY,
            'start_date' => $startdate,
            'end_date' => $enddate,
            'description' => $description
        ]);
    }

    public function setWebsiteMaintenanceUp($secret_key) {
        Http::post(RouteServiceProvider::CLIENT_API.'/'.$secret_key.'?api/set/the/website/maintenance/up',[
            'private_key' => self::PRIVATE_KEY
        ]);
    }
}
