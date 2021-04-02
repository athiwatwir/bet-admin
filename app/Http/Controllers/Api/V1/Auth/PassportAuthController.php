<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'string', 'max:255', 'regex:/(^([a-zA-Z]+)(\d+)?$)/u'],
            'password' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:10'],
            'currency' => ['required', 'string', 'max:5'],
            'how_to_know' => ['required', 'string', 'max:255'],
        ]);
 
        $checkUser = User::where('username', $request->username)
                    ->orWhere('phone', $request->phone)
                    ->orWhere('line', $request->line)
                    ->where('line', '!=', null)
                    ->first();

        if(!isset($checkUser)){
            $user = User::create([
                "username" => $request->username,
                "password" => $request->password,
                "name" => $request->name,
                "phone" => $request->phone,
                "line" => $request->line,
                "currency" => $request->currency,
                "how_to_know" => $request->how_to_know,
                "how_to_know_desc" => $request->how_to_know_desc,
                "status" => 'CO',
            ]);

            // Log::debug($user);
        
            $token = $user->createToken('LaravelAuthApp')->accessToken;
    
            return response()->json(['token' => $token, 'status' => 200], 200);
        }

        return response()->json(['message' => 'มีข้อมูลซ้ำกับผู้ใช้อื่น กรุณาตรวจสอบ [ชื่อผู้ใช้] , [หมายเลขโทรศัพท์] , [Line]', 'status' => 400], 400);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   
}
