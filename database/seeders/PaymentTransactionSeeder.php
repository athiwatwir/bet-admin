<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_transactions')->insert([
            [
                'c_bank_account_id' => 1,
                'action_date' => date('Y-m-d h:i:s'),
                'type' => 'ฝาก',
                'amount' => 20000,
                'slip' => 'https://cdn.pixabay.com/photo/2020/09/07/17/40/birds-5552482_960_720.jpg',
            ],
            [
                'c_bank_account_id' => 1,
                'action_date' => date('Y-m-d h:i:s'),
                'type' => 'ฝาก',
                'amount' => 7000,
                'slip' => 'https://cdn.pixabay.com/photo/2019/10/03/18/30/iceland-4524112_960_720.jpg',
            ],
            [
                'c_bank_account_id' => 1,
                'action_date' => date('Y-m-d h:i:s'),
                'type' => 'ถอน',
                'amount' => 1000,
                'slip' => 'https://cdn.pixabay.com/photo/2021/02/02/16/41/flower-5974552_960_720.jpg',
            ],
            [
                'c_bank_account_id' => 1,
                'action_date' => date('Y-m-d h:i:s'),
                'type' => 'ย้าย',
                'amount' => 700,
                'slip' => 'https://cdn.pixabay.com/photo/2020/07/16/00/54/hands-5409293_960_720.jpg',
            ],
        ]);
    }
}
