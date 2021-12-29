<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\ApiGame;
use App\Models\ApiGameUrl;
use App\Models\ApiGameConfig;

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
        $game = ApiGame::create(['name' => $request->name]);
        $this->create_url($game->id, $request->url);
        $this->create_config($game->id, $request->config);
        
        return redirect()->back();
    }

    public function edit($id)
    {
        $api_game = $this->getApiGameById($id);
        return view('settings.api.games.edit', ['game' => $api_game]);
    }

    private function create_url($api_game_id, $urls)
    {
        foreach($urls as $url) {
            ApiGameUrl::create([
                'api_game_id' => $api_game_id,
                'url' => $url['name']
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

    private function getAllApiGames()
    {
        return ApiGame::where('status', 'CO')->with(['api_url', 'api_config'])->get();
    }

    private function getApiGameById($id)
    {
        return ApiGame::where('id', $id)->with(['api_url', 'api_config'])->first();
    }
}
