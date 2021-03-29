<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        if(isset($request)) {
            $menber = Member::create([
            "username" => $request->username,
            "password" => $request->password,
            "name" => $request->name,
            "phone" => $request->phone,
            "line" => $request->line,
            "currency" => $request->currency,
            "how_to_know" => $request->how_to_know,
            "how_to_know_desc" => $request->how_to_know_desc
            
            ]);

            return response()->json(['status' => 200]);
        }else{
            return abort(404);
        }
    }
}
