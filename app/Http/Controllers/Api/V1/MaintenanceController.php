<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Maintenance;

class MaintenanceController extends Controller
{
    public function transactionMaintenance() {
        $mainten = Maintenance::whereIn('transaction', ['deposit', 'withdraw', 'deposit-withdraw'])
                                ->where('status', 'DR')
                                ->where('now', true)
                                ->first();

        return response()->json(['data' => $mainten], 200);
    }

    public function websiteMaintenance() {
        $mainten = Maintenance::where('secretkey', '!=', '')
                                ->where('status', 'DR')
                                ->where('now', false)
                                ->first();

        return response()->json(['data' => $mainten]);
    }
}
