<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
Use \Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        
        $date = Carbon::now();
        $dateArr =  $date->toArray();
        $monthYearStr = sprintf('%s%s',$dateArr['month'],$dateArr['year']);

        $userCount = DB::table('users')->count();

        $newUserCount = DB::table('users')
                            ->whereMonth('created_at', $dateArr['month'])
                            ->whereYear('created_at', $dateArr['year'])
                            ->count();

        $depositAmt = DB::table('payment_transactions')
                            ->select(DB::raw('SUM(amount) as total_amt'),DB::raw("DATE_FORMAT(created_at, '%m%Y') as mmyyyy"))
                            ->where([[DB::raw("DATE_FORMAT(created_at, '%m%Y')"),$monthYearStr],['type','ฝาก'],['status','CO']])
                            ->groupBy('mmyyyy')
                            ->first();

        $withdrawAmt = DB::table('payment_transactions')
                            ->select(DB::raw('SUM(amount) as total_amt'),DB::raw("DATE_FORMAT(created_at, '%m%Y') as mmyyyy"))
                            ->where([[DB::raw("DATE_FORMAT(created_at, '%m%Y')"),$monthYearStr],['type','ถอน'],['status','CO']])
                            ->groupBy('mmyyyy')
                            ->first();

        //Log::info((array)$depositAmt);

        $cardInfo = [
            'userTotalAmt'=>$userCount,
            'newUserTotalAmt'=>$newUserCount,
            'depositAmt'=>isset($depositAmt->total_amt)?$depositAmt->total_am:0,
            'withdrawAmt'=>isset($withdrawAmt->total_amt)?$withdrawAmt->total_amt:0
        ];


        return view('dashboard', ['cardInfo' => $cardInfo]);
    }
}
