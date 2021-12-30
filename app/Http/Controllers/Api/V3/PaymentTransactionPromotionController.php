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
                    ->leftJoin('users', 'payment_transaction_promotions.user_id', '=', 'users.id')
                    ->select('users.username', 'users.name')
                    ->where('payment_transaction_promotions.payment_transaction_id', $id)
                    ->get();

        $transaction = DB::table('payment_transactions')->where('id', $id)->select('description as name', 'amount')->first();
        $user_level = $this->getUserLevel($id);

        if(sizeof($promotion) > 0) return response()->json(['data' => $promotion, 'description' => $transaction, 'user_level' => $user_level, 'error' => null], 200);

        return response()->json(['data' => null, 'error' => 'no data.'], 404);
    }

    private function getUserLevel($payment_transaction_id)
    {
        $user_level = DB::table('payment_transaction_promotions')
                ->leftJoin('user_levels', 'payment_transaction_promotions.user_level_id', '=', 'user_levels.id')
                ->where('payment_transaction_promotions.payment_transaction_id', $payment_transaction_id)
                ->groupBy('payment_transaction_promotions.user_level_id')
                ->select('user_levels.name')
                ->get();

        $is_user_level = '';
        if($user_level[0]->name != NULL) {
            for($i = 0; $i < count($user_level); $i++) {
                if($i == 0) $is_user_level = $user_level[0]->name;
                else $is_user_level .= ', '.$user_level[$i]->name;
            }
            return $is_user_level;
        }

        return $is_user_level = 'สมาชิกทุกคน';
    }
}
