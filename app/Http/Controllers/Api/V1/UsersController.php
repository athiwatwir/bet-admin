<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserBanking;

use Illuminate\Support\Facades\DB;
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

    public function changePassword(Request $request)
    {
        $accessToken = auth()->user()->token();
        $user = User::find($accessToken->user_id);
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => $request->new_password,
            ]);
        }else{
            return response()->json(['message' => 'รหัสผ่านเดิมไม่ถูกต้อง กรุณาตรวจสอบ...', 'status' => 401], 401);
        }

        return response()->json(['status' => 200], 200);
    }

    public function userBanking(Request $request)
    {
        $accessToken = auth()->user()->token();
        $bank = DB::table('user_bankings')
                            ->join('banks', 'user_bankings.bank_id', '=', 'banks.id')
                            ->select([
                                'user_bankings.bank_account_number', 'user_bankings.bank_account_name', 'user_bankings.is_active', 
                                'banks.id as bank_id','banks.name as bank_name', 'banks.name_en as bank_name_en'
                            ])
                            ->where('user_bankings.user_id', '=', $accessToken->user_id)
                            ->where('user_bankings.status', '!=', 'DL')
                            ->first();

        $bankList = DB::table('banks')
                        ->where('is_active', '=', 'Y')
                        ->where('status', '=', 'CO')
                        ->select(['id', 'name', 'name_en'])
                        ->get();
        
        if(isset($bank)){
            return response()->json(['bank' => $bank, 'b_list' => $bankList, 'status' => 200], 200);
        }

        return response()->json(['bank' => null, 'b_list' => $bankList, 'status' => 404], 404);
    }

    public function userBankingUpdate(Request $request)
    {
        // Log::debug($request);
        $accessToken = auth()->user()->token();
        $bank = UserBanking::create([
            "user_id" => $accessToken->user_id,
            "bank_id" => $request->bank_name,
            "bank_account_name" => $request->bank_account_name,
            "bank_account_number" => $request->bank_account_number,
            "is_active" => 'Y',
            "status" => 'CO',
        ]);

        if($bank) {
            return response()->json(['status' => 200], 200);
        }
        
        return response()->json(['status' => 401], 401);
    }

    public function userBankingEdit(Request $request)
    {
        $accessToken = auth()->user()->token();
        $bank = DB::table('user_bankings')
                    ->where('user_id', '=', $accessToken->user_id)
                    ->update([
                        'bank_id' => $request->bank_name,
                        'bank_account_name' => $request->bank_account_name,
                        'bank_account_number' => $request->bank_account_number
                    ]);

        if($bank) {
            return response()->json(['status' => 200], 200);
        }
        
        return response()->json(['status' => 401], 401);
    }
}
