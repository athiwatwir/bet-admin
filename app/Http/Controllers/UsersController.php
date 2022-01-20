<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Http\Controllers\PaginateController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\WalletsController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\BankGroupController;
use App\Http\Controllers\ReportsController;

use App\Models\UserBanking;

use App\Helpers\PgSoftGameComponent as PgSoft;
use App\Helpers\CoreGameComponent as CoreGame;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:user']);
    }

    public function index()
    {
        $users = DB::table('users')
                    ->leftJoin('user_levels', 'users.user_level_id', '=', 'user_levels.id')
                    ->where('users.is_admin', 'N')
                    ->where('users.status', 'CO')
                    ->select('users.*', 'user_levels.name as level_name')
                    ->orderBy('users.created_at', 'desc')
                    ->get();

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
        $wallets = (new WalletsController)->getWalletsByUserId($request->id);
        $default_wallet = (new WalletsController)->getDefaultWalletByUserId($request->id);
        $transactions = (new PaymentTransactionController)->getPaymentTransactionByUserId($request->id);
        $banks = $this->getBanks();
        $levels = (new UserLevelController)->getAllUserLevel();
        $user_level = (new UserLevelController)->getUserLevelById($user->user_level_id);
        $bankGroups = (new BankGroupController)->getAllBankGroups();

        // $getAllGameBalance = $this->getGameBalance($request->id, $wallets);

        return view('user.view', [
                    'profile' => $user, 'ubank' => $ubank, 'banks' => $banks, 'username' => $request->username, 
                    'wallets' => $wallets, 'default_wallet' => $default_wallet, 'transaction' => $transactions, 
                    'levels' => $levels, 'bank_groups' => $bankGroups, 'user_level' => $user_level
                    ]);
    }

    private function getGameBalance($user_id, $wallets)
    {
        $gameWallets = [];
        foreach($wallets as $wallet) {
            $game = (new CoreGame)->checkpoint($user_id, $wallet->gamecode, 'get-balance');
            array_push($gameWallets, ['user_id' => $user_id, 'game' => $wallet->api_game_name, 'gamecode' => $wallet->gamecode, 'balance' => $game , 'currency' => $wallet->currency]);
        }
        return $gameWallets;
    }

    // get PGSoftGame Wallet Temporary
    private function getPgsoftgameWallet($username)
    {
        $response = Http::asForm()->post('https://api.pg-bo.me/external/Cash/v3/GetPlayerWallet?trace_id='.Str::uuid(),[
            'operator_token' => '32cd845d7701497deaa1bc6458c61b55',
            'secret_key' => '19e16714fab6e147362a18d0cf37c8a4',
            'player_name' => $username,
        ]);

        if($response['error'] == null) {
            return $response['data']['totalBalance'];
        }

        return 100;
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
                    'user_level_id' => $request->level,
                    'bank_group_id' => $request->bank_group
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
        
        $ubank = UserBanking::updateOrCreate(
            [
                'id' => $request->id,
                'user_id' => $request->user_id
            ],
            [
                'bank_id' => $request->banks,
                'bank_account_name' => $request->account_name,
                'bank_account_number' => $request->account_number,
                'is_active' => 'Y',
                'status' => 'CO'
            ]
        );

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



    // PRIVATE FUNCTION /////////////////////////////

    private function getUserBanking($id)
    {
        return DB::table('user_bankings')
                    ->leftJoin('banks', 'user_bankings.bank_id', '=', 'banks.id')
                    ->where('user_bankings.user_id', $id)
                    ->select(['user_bankings.*', 'banks.name', 'banks.name_en'])
                    ->first();
    }

    private function getBanks()
    {
        return DB::table('banks')->where('is_active', 'Y')->where('status', 'CO')->get();
    }


    // CALL FUNCTION ///////////////////////////////////////

    public function getUserAll()
    {
        return DB::table('users')->where('status', 'CO')->where('is_active', 'Y')->get();
    }

    public function getUserById($id)
    {
        return DB::table('users')->where('id', $id)->where('status', 'CO')->where('is_active', 'Y')->first();
    }

    public function getUserByLevelId($level_id)
    {
        return DB::table('users')->where('user_level_id', $level_id)->where('status', 'CO')->where('is_active', 'Y')->get();
    }

    public function getUserByUsername($username)
    {
        return DB::table('users')->where('username', $username)->get();
    }
}
