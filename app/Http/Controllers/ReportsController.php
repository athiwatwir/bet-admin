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

    public function index(){

         return view('reports.index', []);
    }
}
