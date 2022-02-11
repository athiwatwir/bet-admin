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
    
}
