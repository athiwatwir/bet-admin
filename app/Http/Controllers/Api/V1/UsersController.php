<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function view(Request $request)
    {
        $accessToken = auth()->user()->token();
        // Log::debug('user_id = '.$accessToken->user_id);
        $user = User::where('id', '=', $accessToken->user_id)
                    ->select('name', 'username', 'phone', 'line')
                    ->first();
        
        if(isset($user)){
            return response()->json(['user' => $user, 'status' => 200], 200);
        }else{
            return response()->json(['message' => 'เกิดข้อผิดพลาดให้การเรียกข้อมูล กรุณาลองใหม่อีกครั้ง', 'status' => 401], 401);
        }
    }

    public function update(Request $request)
    {
        $accessToken = auth()->user()->token();
        $user = User::where('id', '=', $accessToken->user_id)
                    ->update([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'line' => $request->line,
                    ]);
        
        if($user){
            return response()->json(['status' => 200], 200);
        }else{
            return response()->json(['status' => 401], 401);
        }
    }
}
