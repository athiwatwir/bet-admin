<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\ApiGame;

class PgSoftGameController extends Controller
{
    public function getBalance($gamecode)
    {
        return ApiGame::where('gamecode', $gamecode)->where('isactive', 'Y')->with(['api_url', 'api_token'])->get();
    }
}
