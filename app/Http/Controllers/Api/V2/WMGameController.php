<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WMGameController extends Controller
{
    public function testWMHello()
    {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=Hello&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af');
        return $response;
        // return response()->json(['data' => 'done!'], 200);
    }

    public function testMemberRegister(Request $request)
    {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=MemberRegister&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'password' => $request->password,
            'username' => $request->username,
            'timestamp' => time()
        ]);

        return $response;
    }

    public function testSigninGame(Request $request)
    {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=SigninGame&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'password' => $request->password,
            'lang' => 2,
            'timestamp' => time()
        ]);

        return $response;
    }

    public function testLogoutGame(Request $request)
    {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=LogoutGame&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'timestamp' => time()
        ]);

        return $response;
    }

    public function testChangeBalance(Request $request) {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=ChangeBalance&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'money' => $request->money,
            'timestamp' => time()
        ]);

        return $response;
    }

    public function testGetBalance(Request $request) {
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=GetBalance&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'timestamp' => time()
        ]);

        return $response;
    }

    public function testReport(Request $request) {
        $date_now = date('Ymd');
        $response = Http::asForm()->post('http://tgwb-317.wmapi88.com/api/public/Gateway.php?cmd=GetDateTimeReport&vendorId=pzthbapi&signature=60a45b33b3237957d0c559e0a4faa6af',[
            'user' => $request->user,
            'startTime' => $date_now.'000000',
            'endTime' => $date_now.'230000',
            'timetype' => 1,
            'datatype' => 0,
            'timestamp' => time()
        ]);

        return $response;
    }
    
}
