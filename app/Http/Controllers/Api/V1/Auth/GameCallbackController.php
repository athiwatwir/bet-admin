<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider as ServiceRoute;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GameCallbackController extends Controller
{
    public function requestToPlayGame(Request $request)
    {
        $accessToken = auth()->user()->token();
        $userAccess = DB::table('users')->find($accessToken->id);
        if($accessToken) $this->gameCall();
    }

    private function gameCall()
    {
        
    }

    public function gameCallBack(Request $request)
    {
        // Log::debug($request);
    }
}
