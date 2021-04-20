<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletsController extends Controller
{
    public function defaultWallet()
    {
        $accessToken = auth()->user()->token();
        return Wallet::where('user_id', '=', $accessToken->user_id)
                                ->where('is_default', '=', 'Y')
                                ->select(['id', 'amount', 'currency'])
                                ->first();
    }


    public function userWallets(Request $request)
    {
        $accessToken = auth()->user()->token();
        $wallet = $this->defaultWallet();

        $wallets = Wallet::where('user_id', '=', $accessToken->user_id)
                            ->where('is_default', '=', 'N')
                            ->where('status', '!=', 'DL')
                            ->select(['id', 'game_id', 'amount', 'currency'])
                            ->get();
        
        if(isset($wallet)){
            return response()->json(['wallet' => $wallet, 'wallets' => $wallets, 'status' => 200], 200);
        }

        return response()->json(['status' => 404], 404);
    }

    public function createWallet(Request $request)
    {
        $accessToken = auth()->user()->token();
        $amount = $request->amount == null ? 0 : $request->amount;

        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $amount) {
            $is_amount = $amount != 0 ? $default_wallet->amount - $amount : $default_wallet->amount;

            $wallet = Wallet::create([
                "user_id" => $accessToken->user_id,
                "game_id" => $request->game_id,
                "amount" => $amount,
                "currency" => $default_wallet->currency,
                "is_default" => "N",
                "status" => 'CO',
            ]);

            if($wallet){
                Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);
                return response()->json(['status' => 200], 200);
            }

            return response()->json(['status' => 404], 404);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function addWallet(Request $request)
    {
        $accessToken = auth()->user()->token();

        $default_wallet = $this->defaultWallet();

        if($default_wallet->amount >= $request->amount) {
            $default_wallet_amount = $default_wallet->amount - $request->amount;

            $wallet = Wallet::find($request->id);

            $is_amount = $wallet->amount + $request->amount;

            $wallet->update(['amount' => $is_amount]);

            if($wallet){
                Wallet::find($default_wallet->id)->update(['amount' => $default_wallet_amount]);
                return response()->json(['status' => 200], 200);
            }

            return response()->json(['status' => 404], 404);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function transferWallet(Request $request)
    {
        $accessToken = auth()->user()->token();

        $from_wallet = Wallet::find($request->id);

        if($from_wallet->amount >= $request->amount) {
            $from_wallet_amount = $from_wallet->amount - $request->amount;

            $wallet = Wallet::find($request->to);

            $is_amount = $wallet->amount + $request->amount;

            $wallet->update(['amount' => $is_amount]);

            if($wallet){
                $from_wallet->update(['amount' => $from_wallet_amount]);
                return response()->json(['status' => 200], 200);
            }

            return response()->json(['status' => 404], 404);

        }else{
            return response()->json(['status' => 301], 301);
        }
    }

    public function deleteWallet(Request $request)
    {
        $default_wallet = $this->defaultWallet();
        $wallet = Wallet::find($request->id);

        $is_amount = $default_wallet->amount + $wallet->amount;

        $wallet->update(['status' => 'DL', 'amount' => 0]);
        Wallet::find($default_wallet->id)->update(['amount' => $is_amount]);

        return response()->json(['status' => 200], 200);
    }
}
