<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\PaginateController;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('is_admin', 'N')
                    ->where('status', 'CO')
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10);

        $deleted = DB::table('users')
                    ->where('is_admin', 'N')
                    ->where('status', 'DL')
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10);

        $is_user = json_decode($users);
        $inactive = [];
        $active = [];
        foreach ($users as $key => $user) {
            // $wallet = $this->getWallets($user->id);
            // $user->is_wallet = json_decode($wallet, true);

            if($user->is_active == 'N') array_push($inactive, $user);
            if($user->is_active == 'Y') array_push($active, $user);

            // Log::debug($active);
            // $users[$key]->data->user_active = $active;

        }
        // $users->user_active = $active;
        // Log::debug($users);

        // (new PaginateController)->__invoke($users);

        return view('user.index', ['users' => $users, 'inactive' => $inactive, 'active' => $active, 'deleted' => $deleted]);
    }

    public function view(Request $request)
    {
        $user = DB::table('users')->find($request->id);
        $ubank = $this->getUserBanking($request->id);
        $wallets = $this->getWallets($request->id);
        $default_wallet = $this->getDefaultWallet($request->id);
        $transactions = $this->getPaymentTransaction($request->id);
        $banks = $this->getBanks();

        return view('user.view', [
                    'profile' => $user, 'ubank' => $ubank, 'banks' => $banks, 'username' => $request->username,
                    'wallets' => $wallets, 'default_wallet' => $default_wallet,
                    'transaction' => $transactions
                    ]);
    }

    public function editProfile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
        ],
        [
            'name.required' => 'กรุณาระบุชื่อ-สกุล',
            'phone.required' => 'กรุณาระบุหมายเลขโทรศัพท์',
        ]);

        $user = DB::table('users')->where('id', $request->id)
                ->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'line' => $request->line,
                ]);

        if($user) return redirect()->back()->with('success', 'แก้ไขรายละเอียดผู้ใช้งานเรียบร้อยแล้ว');

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function editBank(Request $request)
    {
        $this->validate($request, [
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required'],
        ],
        [
            'account_name.required' => 'กรุณาระบุชื่อบัญชี',
            'account_number.required' => 'กรุณาระบุเลขบัญชี',
        ]);

        $ubank = DB::table('user_bankings')->where('id', $request->id)
                ->update([
                    'bank_id' => $request->banks,
                    'bank_account_name' => $request->account_name,
                    'bank_account_number' => $request->account_number
                ]);

        if($ubank) return redirect()->back()->with('success', 'แก้ไขธนาคารของผู้ใช้งานเรียบร้อยแล้ว');

        return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่');
    }

    public function active(Request $request)
    {
        $user = User::find($request->id);
        $is_active = $user->is_active == 'N' ? 'Y' : 'N';
        $user->update(['is_active' => $is_active]);

        $message = $is_active == 'Y' ? 'เปิดการใช้งาน' : 'ปิดการใช้งาน';

        return redirect()->back()->with('success', ''. $message .' '. $request->username .' เรียบร้อยแล้ว');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id)->update([
            'is_active' => 'N',
            'status' => 'DL'
        ]);

        return redirect('/users')->with('success', 'ลบผู้ใช้งาน '. $request->username .' เรียบร้อยแล้ว');
    }

    private function getUserBanking($id)
    {
        return DB::table('user_bankings')
                    ->leftJoin('banks', 'user_bankings.bank_id', '=', 'banks.id')
                    ->where('user_bankings.user_id', $id)
                    ->select(['user_bankings.*', 'banks.name', 'banks.name_en'])
                    ->first();
    }

    private function getWallets($id)
    {
        return DB::table('wallets')
                    ->where('user_id', $id)
                    ->where('status', 'CO')
                    ->where('is_default', 'N')
                    ->select(['id', 'game_id', 'amount', 'currency'])
                    ->paginate(10);
    }

    private function getDefaultWallet($id)
    {
        return DB::table('wallets')
                    ->where('user_id', $id)
                    ->where('is_default', 'Y')
                    ->select(['id', 'amount', 'currency'])
                    ->first();
    }

    private function getBanks()
    {
        return DB::table('banks')->where('is_active', 'Y')->where('status', 'CO')->get();
    }

    private function getPaymentTransaction($id)
    {
        return DB::table('payment_transactions')
                    ->leftJoin('users', 'payment_transactions.user_id', '=', 'users.id')
                    ->leftJoin('c_bank_accounts', 'payment_transactions.c_bank_account_id', '=', 'c_bank_accounts.id')
                    ->leftJoin('user_bankings', 'payment_transactions.user_banking_id', '=', 'user_bankings.id')
                    ->leftJoin('wallets as from_wallet', 'payment_transactions.from_wallet_id', '=', 'from_wallet.id')
                    ->leftJoin('wallets as to_wallet', 'payment_transactions.to_wallet_id', '=', 'to_wallet.id')
                    ->leftJoin('banks as ubank', 'user_bankings.bank_id', '=', 'ubank.id')
                    ->leftJoin('banks as cbank', 'c_bank_accounts.bank_id', '=', 'cbank.id')
                    ->where('payment_transactions.user_id', $id)
                    ->select('payment_transactions.*', 
                            'users.username', 'users.name',
                            'c_bank_accounts.bank_id as bank_name', 'c_bank_accounts.account_name', 'c_bank_accounts.account_number',
                            'user_bankings.bank_id as user_bank_name', 'user_bankings.bank_account_name', 'user_bankings.bank_account_number',
                            'from_wallet.game_id as from_game', 'from_wallet.is_default as from_default',
                            'to_wallet.game_id as to_game', 'to_wallet.is_default as to_default',
                            'ubank.name as ubank_name', 'cbank.name as cbank_name',
                            )
                    ->orderBy('payment_transactions.created_at', 'desc')
                    ->paginate(10);
    }
}
