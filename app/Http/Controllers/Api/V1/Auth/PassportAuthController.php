<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider as Route;

use App\Models\User;
use App\Models\Wallet;
use App\Models\UserPgsoftgame;
use App\Models\PasswordOtp;
use App\Models\UserLog;

use Illuminate\Support\Facades\DB;
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
                'is_active' => 'Y',
                "status" => 'CO',
            ]);

            $this->createUserWallet($user->id, $request->currency);
            $this->createPgSoftGameAccount($user->id);
            $this->userLogCreate($user->id, request()->getClientIp());

            $token = $user->createToken('LaravelAuthApp')->accessToken;
    
            return response()->json(['token' => $token, 'status' => 200], 200);
        }

        return response()->json(['message' => 'มีข้อมูลซ้ำกับผู้ใช้อื่น กรุณาตรวจสอบ [ชื่อผู้ใช้] , [หมายเลขโทรศัพท์] , [Line]', 'status' => 400], 400);
    }

    private function createUserWallet($user_id, $currency)
    {
        $wallet = Wallet::create([
            "user_id" => $user_id,
            "amount" => 0,
            "currency" => $currency,
            "is_default" => "Y",
            "status" => 'CO',
        ]);
    }

    private function createPgSoftGameAccount($user_id)
    {
        $pgsoftgame = UserPgsoftgame::create([
            "user_id" => $user_id,
            "player_session" => Str::uuid(),
            "operator_player_session" => Str::uuid()
        ]);
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => 'Y',
            'is_admin' => 'N',
            'status' => 'CO'
        ];

        // Log::debug($data);
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            $name = auth()->user()->name;
            $user = auth()->user()->username;
            $id = auth()->user()->id;

            // $this->userLogCreate($id, request()->getClientIp());
            return response()->json(['token' => $token, 'user' => $user, 'name' => $name, 'id' => $id, 'status' => 200], 200);
        } else {
            return response()->json(['message' => 'ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบ', 'status' => 401], 401);
        }
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        return response()->json(['status' => 200], 200);
    }

    public function forgotPassword(Request $request)
    {
        $checkUserByPhone = $this->getUserByPhone($request->phone);
        if(isset($checkUserByPhone)) {
            $ref = $this->generateRandomString(6, 'string');
            $otp = $this->generateRandomString(8, 'number');
            $message = 'ข้อความจาก Playszone OTP:'.$otp.'  รหัสอ้างอิง:'.$ref;

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. Route::SMS_BEARER,
                ])->asForm()->post(Route::SMS_URL,[
                    'sender' => 'OTP',
                    'msisdn[0]' => $request->phone,
                    'message' => $message
            ]);

            if($response['success']) {
                PasswordOtp::create([
                    'user_id' => $checkUserByPhone->id,
                    'ref' => $ref,
                    'otp' => $otp
                ]);
                // Log::debug($otp);
    
                return response()->json(['phone' => $request->phone, 'ref' => $ref, 'status' => 200], 200);
            }else{
                return response()->json(['message' => 'เกิดข้อผิดพลาดในการส่งข้อความ', 'status' => 404], 404);
            }

        }else{
            return response()->json(['message' => 'หมายเลขโทรศัพท์ไมถูกต้อง หรือ เกิดข้อผิดพลาดบางอย่าง', 'status' => 401], 401);
        }
    }

    public function confirmOtp(Request $request)
    {
        if(isset($request->otp)) {
            $otp = PasswordOtp::where('ref', $request->ref)->where('status', 'DR')->first();
            if(Hash::check($request->otp ,$otp->otp)) {
                $otp->update(['status' => 'CO']);
                return response()->json(['status' => 200, 'user' => $otp->user_id], 200);
            }else{
                $otp->update(['status' => 'VO']);
                return response()->json(['message' => 'รหัส OTP ไม่ถูกต้อง', 'status' => 404], 404);
            }
        }
    }

    public function resetPassword(Request $request)
    {
        if(isset($request->user)) {
            $user = User::find($request->user)->update(['password' => $request->password]);
            if($user) {
                return response()->json(['status' => 200], 200);
            }else{
                return response()->json(['status' => 404, 'เกิดข้อผิดพลาดในการตั้งรหัสใหม่'], 404);
            }
        }
    }

    private function generateRandomString($length, $type) {
        if($type == 'number') $x = '0123456789';
        if($type == 'string') $x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($type == 'all') $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($x, ceil($length/strlen($x)) )),1,$length);
    }

    private function getUserByPhone($phone)
    {
        return User::where('phone', $phone)->where('is_active', 'Y')->where('is_admin', 'N')->first();
    }

    private function userLogCreate($user, $ip)
    {
        UserLog::create([
            'user_id' => $user,
            'activity' => 'register',
            'url' => '/register',
            'ipaddress' => $ip
        ]);
    }
}
