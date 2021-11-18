<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public $ReportTypes = [
        'P001'=>'รายการเคลื่อนไหวทางการเงิน'
    ];

    public function index(){

         return view('reports.index', ['reportTypes' => $this->ReportTypes]);
    }
}
