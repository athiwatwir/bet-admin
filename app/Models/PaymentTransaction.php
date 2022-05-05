<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class PaymentTransaction extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id', 'staff_id', 'c_bank_account_id', 'from_bank_id', 'account_name', 'account_number', 'payment_date', '	payment_time',
        'user_banking_id', 'from_wallet_id', 'to_wallet_id', 'action_date', 'code', 'code_status', 'amount', 'slip', 'description', 'status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
