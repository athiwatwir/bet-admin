<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GamesController extends Controller
{
    public function menuGames()
    {
        $groups = DB::table('game_groups')
                    ->where('is_active', 'Y')
                    ->select('id', 'name')
                    ->get();

        foreach($groups as $key => $group) {
            $games = DB::table('games')
                        ->where('game_group_id', $group->id)
                        ->where('is_active', 'Y')
                        ->select('id', 'name', 'url', 'token', 'logo')
                        ->get();
            $groups[$key]->games = $games;
        }
        // Log::debug($groups);

        return response()->json(['menugames' => $groups], 200);
    }
}
