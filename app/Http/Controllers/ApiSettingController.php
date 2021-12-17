<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\UserLevelController;

class ApiSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userLevelIndex()
    {
        $user_levels = (new UserLevelController)->getAllUserLevel();
        return view('settings.api.userlevel.index', ['user_levels' => $user_levels]);
    }
}
