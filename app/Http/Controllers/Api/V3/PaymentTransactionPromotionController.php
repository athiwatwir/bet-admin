<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentTransactionPromotionController extends Controller
{
    public function walletList($id)
    {
        $promotion = DB::table('payment_transaction_promotions')
                    ->leftJoin('wallets', 'payment_transaction_promotions.wallet_id', '=', 'wallets.id')
                    ->leftJoin('users', 'wallets.user_id', '=', 'users.id')
                    ->select('users.username', 'users.name')
                    ->where('payment_transaction_promotions.payment_transaction_id', $id)
                    ->get();

        $transaction = DB::table('payment_transactions')->where('id', $id)->select('description as name', 'amount')->first();

        if(sizeof($promotion) > 0) return response()->json(['data' => $promotion, 'description' => $transaction, 'error' => null], 200);

        return response()->json(['data' => null, 'error' => 'no data.'], 404);
    }
}
