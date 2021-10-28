<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function adminLogin(Request $request)
    {
        $admin = Staff::where('username', $request->username)->first();
        if(isset($admin)) {
            if($admin->is_active != 'Y' || $admin->status != 'CO') {
                return redirect()->back()->with('error', 'Invalid Credentials');
            }

            if(Auth::guard('webadmin')->attempt($request->only(['username', 'password']))) {
                return redirect()->route('dashboard');
            }

            return redirect()->back()->with('error', 'Invalid Credentials');
        }
        
        return redirect()->back()->with('error', 'Invalid Credentials');
    }
}
