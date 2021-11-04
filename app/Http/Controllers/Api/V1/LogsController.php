<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\UserLog;

class LogsController extends Controller
{
    public function userLogs(Request $request)
    {
        $accessToken = auth()->user()->token();
        $userlog = UserLog::where('user_id', $accessToken->user_id)->first();
        if(isset($userlog)) {
            UserLog::where('user_id', $accessToken->user_id)->update([
                'activity' => $request->activity,
                'url' => $request->url,
                'ipaddress' => request()->getClientIp()
            ]);
        }else{
            UserLog::create([
                'user_id' => $accessToken->user_id,
                'activity' => $request->activity,
                'url' => $request->url,
                'ipaddress' => request()->getClientIp()
            ]);
        }
        // return response()->json(['ip' => request()->getClientIp()], 200);
    }

    public function createUserLog($user_id)
    {
        UserLog::create([
            'user_id' => $user_id,
            'activity' => 'register',
            'url' => '/register',
            'ipaddress' => request()->getClientIp()
        ]);
    }

    public function updateUserLog(Request $request)
    {
        $accessToken = auth()->user()->token();
        UserLog::where('user_id', $accessToken->user_id)->update([
            'activity' => $request->activity,
            'url' => $request->url,
            'ipaddress' => request()->getClientIp()
        ]);
    }
}
