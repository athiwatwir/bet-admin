<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

class AccountSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('account-setting');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $user->update([
            'name' => $request->account_name
        ]);

        if($request->account_email != $user->email){
            if (Hash::check($request->account_email_password, $user->password)) {
                $user->update([
                    'email' => $request->account_email
                ]);
            }else{
                return redirect()->back()->with('warning', 'รหัสผ่านทำหรับแก้ไขอีเมล์ไม่ถูกต้อง กรุณาตรวจสอบ...');
            }
        }

        return redirect()->back()->with('success', 'แก้ไขข้อมูลเรียบร้อยแล้ว...');
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (Hash::check($request->account_current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->account_new_password)
            ]);
        }else{
            return redirect()->back()->with('error', 'รหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบ...');
        }

        return redirect()->back()->with('success', 'แก้ไขรหัสผ่านเรียบร้อยแล้ว...');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
