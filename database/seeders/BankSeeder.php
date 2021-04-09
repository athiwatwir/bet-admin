<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('banks')->insert([
            [
                'name' => 'ธนาคารกสิกรไทย - Kasikorn Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารกรุงไทย - Krung Thai Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารไทยพาณิชย์ - Siam Commercial Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารกรุงเทพ - Bangkok Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารออมสิน - Government Savings Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารทหารไทย - TMB Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารกรุงศรีอยุธยา - Krungsri Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร ซีไอเอ็มบี - CIMB Thai Bank Public Company Limited',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารธนชาต - Thanachart Bank Public Company Limited',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารยูโอบี - United Overseas Bank (Thai) PCL.',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารอาคารสงเคราะห์ - Government Housing Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารเอชเอสบีซี - Hongkong and Shanghai Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารสแตนดาร์ดชาร์เตอร์ด - Standard Charter Bank (Thai) PCL.',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคารแลนด์ แอนด์ เฮ้าส์ - Land and Houses Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธ.ก.ส - BAAC',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร เกียรตินาคิน - Kiatnakin Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร ซิตี้แบ้งค์ - Citibank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร ดอยซ์แบงก์ - Deutsche Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร ทิสโก้ - Tisco Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'ธนาคาร อิสลามแห่งประเทศไทย - Islamic Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'BANQUE POUR LE COMMERCE',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'Bank of China (Thai) PCL',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'BNP Paribas Bangkok Branch',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'MEGA Internation Commercial Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'Mizuho Corporate Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'The Sumitomo Mitsu Banking Corporate',
                'is_active' => 'Y',
                'status' => 'CO'
            ],
            [
                'name' => 'The Thai Credit Retail Bank',
                'is_active' => 'Y',
                'status' => 'CO'
            ]
        ]);
    }
}
