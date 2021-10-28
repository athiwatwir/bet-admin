<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class PaymentTransactionLog extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'payment_transaction_id', 'user_id', 'staff_id', 'from_wallet_id', 'to_wallet_id', 'c_bank_account_id', 'user_banking_id',
        'code', 'status', 'amount', 'description'
    ];

    protected $hidden = [
        'payment_transaction_id', 'user_id', 'staff_id', 'from_wallet_id', 'to_wallet_id', 'c_bank_account_id', 'user_banking_id', 'status'
    ];
}
