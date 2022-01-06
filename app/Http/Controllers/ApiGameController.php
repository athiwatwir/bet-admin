<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\ApiGame;
use App\Models\ApiGameUrl;
use App\Models\ApiGameConfig;
use App\Models\ApiGameToken;

class ApiGameController extends Controller
{
    public function __constructor()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $api_game = $this->getAllApiGames();
        return view('settings.api.games.index', ['games' => $api_game]);
    }

    public function create(Request $request)
    {
        $game = ApiGame::create(['name' => $request->name, 'gamecode' => $request->code]);
        $this->create_url($game->id, $request->url);
        // $this->create_config($game->id, $request->config);
        $this->create_token($game->id, $request->token);
        
        return redirect()->back()->with('success', 'เพิ่มรายการเกมเรียบร้อยแล้ว...');
    }

    public function edit($id)
    {
        $api_game = $this->getApiGameById($id);
        return view('settings.api.games.edit', ['game' => $api_game, 'game_id' => $id]);
    }

    public function active($id)
    {
        $game = $this->getApiGameById($id);
        $isactive = $game->isactive == 'Y' ? 'N' : 'Y';
        $game->update([
            'isactive' => $isactive
        ]);

        return redirect()->back()->with('success', 'เปลี่ยนแปลงสถานะของเกม '. $game->name .' เรียบร้อยแล้ว');
    }

    public function updateGameName(Request $request)
    {
        $game = $this->getApiGameById($request->game_id);
        $game->update([
            'name' => $request->edit_game_name, 
            'gamecode' => $request->edit_game_code
        ]);

        if($game) return redirect()->back()->with('success', 'แก้ไขชื่อเกมเรียบร้อยแล้ว...');
        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด...');
    }

    public function updateConfig(Request $request)
    {
        foreach($request->config as $key => $config) {
            ApiGameConfig::find($config['id'])->update([
                'key_name' => $config['key_name'],
                'method' => $config['method'],
                'value' => $config['parameter']
            ]);
        }

        return redirect()->back();
    }

    public function updateApi(Request $request)
    {
        foreach($request->api as $key => $api) {
            ApiGameUrl::find($api['id'])->update([
                'name' => $api['name'],
                'url' => $api['url']
            ]);
        }
        return redirect()->back()->with('success', 'แก้ไขรายการ API Domain เรียบร้อยแล้ว...');
    }

    public function updateToken(Request $request)
    {
        foreach($request->token as $key => $token) {
            ApiGameToken::find($token['id'])->update([
                'name' => $token['name'],
                'value' => $token['value']
            ]);
        }

        return redirect()->back()->with('success', 'แก้ไขรายการ Token Key เรียบร้อยแล้ว...');
    }

    public function addApi(Request $request)
    {
        foreach($request->api as $key => $api) {
            ApiGameUrl::create([
                'api_game_id' => $request->game_id,
                'name' => $api['name'],
                'url' => $api['value']
            ]);
        }
        return redirect()->back()->with('success', 'เพิ่มรายการ API Domain เรียบร้อยแล้ว...');
    }

    public function addToken(Request $request)
    {
        foreach($request->token as $key => $token) {
            ApiGameToken::create([
                'api_game_id' => $request->game_id,
                'name' => $token['name'],
                'value' => $token['value']
            ]);
        }
        return redirect()->back()->with('success', 'เพิ่มรายการ Token Key เรียบร้อยแล้ว...');
    }

    private function create_url($api_game_id, $urls)
    {
        foreach($urls as $url) {
            ApiGameUrl::create([
                'api_game_id' => $api_game_id,
                'name' => $url['name'],
                'url' => $url['url']
            ]);
        }
    }

    private function create_config($api_game_id, $configs)
    {
        foreach($configs as $config) {
            ApiGameConfig::create([
                'api_game_id' => $api_game_id,
                'key_name' => $config['key_name'],
                'method' => $config['method'],
                'value' => $config['parameter']
            ]);
        }
    }

    private function create_token($api_game_id, $tokens)
    {
        foreach($tokens as $token) {
            ApiGameToken::create([
                'api_game_id' => $api_game_id,
                'name' => $token['name'],
                'value' => $token['key']
            ]);
        }
    }

    private function getAllApiGames()
    {
        return ApiGame::where('status', 'CO')->with(['api_url', 'api_config', 'api_token'])->get();
    }

    private function getApiGameById($id)
    {
        return ApiGame::where('id', $id)->with(['api_url', 'api_config', 'api_token'])->first();
    }
}
