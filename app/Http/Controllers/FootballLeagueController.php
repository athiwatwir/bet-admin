<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FootballLeagueController extends Controller
{
    // LEAGUE ////////////////////////////////////////
    public function leagueIndex()
    {
        $leagues = DB::table('c_leagues')->where('status', 'CO')->paginate(10);

        return view('football.leagues', ['leagues' => $leagues]);
    }

    public function leagueCreate(Request $request)
    {
        if(isset($request->name)) {
            DB::table('c_leagues')
                ->insert([
                    'name' => $request->name,
                    'name_en' => $request->name_en,
                ]);

            return redirect()->back()->with('success', 'เพิ่มลีกฟุตบอลเรียบร้อยแล้ว');
        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุชื่อลีค');
        }
    }

    public function leagueEdit(Request $request)
    {
        if(isset($request->name_edit)) {
            DB::table('c_leagues')->where('id', $request->league_id)
                ->update([
                    'name' => $request->name_edit,
                    'name_en' => $request->name_en_edit
                ]);

            return redirect()->back()->with('success', 'แก้ไขลีกฟุตบอลเรียบร้อยแล้ว');
        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุชื่อลีค');
        }
    }

    public function leagueActive(Request $request)
    {
        $league = DB::table('c_leagues')->where('id', $request->id)->first();
        
        $is_active = $league->is_active == 'N' ? 'Y' : 'N';

        DB::table('c_leagues')->where('id', $request->id)->update(['is_active' => $is_active]);

        return redirect()->back()->with('success', 'แก้ไขสถานะของเกม '. $request->league_name .' เรียบร้อยแล้ว');
    }

    public function leagueDelete(Request $request)
    {
        DB::table('c_leagues')->where('id', $request->id)->update(['is_active' => 'N', 'status' => 'DL']);

        return redirect()->back()->with('success', 'ลบลีก '. $request->league_name .' เรียบร้อยแล้ว');
    }



    // TEAM ////////////////////////////////////////
    public function teamIndex()
    {
        $teams = DB::table('c_teams')
            ->leftJoin('c_leagues', 'c_teams.c_league_id', '=', 'c_leagues.id')
            ->where('c_teams.status', 'CO')
            ->select('c_teams.*', 'c_leagues.name as league_name', 'c_leagues.name_en as league_en')
            ->paginate(10);

        $leagues = $this->getLeagues();

        return view('football.teams', ['teams' => $teams, 'leagues' => $leagues, 'league_id' => '']);
        
    }

    public function leagueListTeam(Request $request)
    {
        $teams = DB::table('c_teams')
            ->leftJoin('c_leagues', 'c_teams.c_league_id', '=', 'c_leagues.id')
            ->where('c_teams.status', 'CO')
            ->where('c_teams.c_league_id', $request->league_id)
            ->select('c_teams.*', 'c_leagues.name as league_name', 'c_leagues.name_en as league_en')
            ->paginate(10);

        $leagues = $this->getLeagues();

        return view('football.leagueteam', ['teams' => $teams, 'leagues' => $leagues, 'is_league' => $request->league_name, 'league_id' => $request->league_id]);
    }

    public function teamCreate(Request $request)
    {
        if(isset($request->name) && isset($request->league) && isset($request->code) && isset($request->logo)) {

            $fileName = time().'_'.$request->logo->getClientOriginalName();
            $request->logo->move(public_path('/logoteams'), $fileName);

            DB::table('c_teams')
                ->insert([
                    'c_league_id' => $request->league,
                    'name' => $request->name,
                    'name_en' => $request->name_en,
                    'code' => $request->code,
                    'logo' => $fileName,
                ]);

            return redirect()->back()->with('success', 'เพิ่มทีม '. $request->name .' เรียบร้อยแล้ว');
        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุรายละเอียดให้ครบ');
        }
    }

    public function teamEdit(Request $request)
    {
        if(isset($request->name_edit) && isset($request->league_edit) && isset($request->code_edit)) {

            DB::table('c_teams')->where('id', $request->team_id)
                ->update([
                    'c_league_id' => $request->league_edit,
                    'name' => $request->name_edit,
                    'name_en' => $request->name_en_edit,
                    'code' => $request->code_edit
                ]);

            if(isset($request->logo_edit)) {
                $getLogo = $this->getTeamFirst($request->team_id);
                if(isset($getLogo->logo)) unlink(public_path('logoteams/'.$getLogo->logo));
    
                $fileName = time().'_'.$request->logo_edit->getClientOriginalName();
                $request->logo_edit->move(public_path('/logoteams'), $fileName);
    
                DB::table('c_teams')->where('id', $getLogo->id)->update(['logo' => $fileName]);
            }

            return redirect()->back()->with('success', 'แก้ไขรายละเอียดทีม '. $request->name_edit .' เรียบร้อยแล้ว');

        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุรายละเอียดให้ครบ');
        }
    }

    public function teamActive(Request $request)
    {
        $team = $this->getTeamFirst($request->id);
        
        $is_active = $team->is_active == 'N' ? 'Y' : 'N';

        DB::table('c_teams')->where('id', $request->id)->update(['is_active' => $is_active]);

        return redirect()->back()->with('success', 'แก้ไขสถานะของเกม '. $request->team_name .' เรียบร้อยแล้ว');
    }

    public function teamDelete(Request $request)
    {
        DB::table('c_teams')->where('id', $request->id)->update(['is_active' => 'N', 'status' => 'DL']);

        return redirect()->back()->with('success', 'ลบทีม '. $request->team_name .' เรียบร้อยแล้ว');
    }

    private function getTeamFirst($id)
    {
        return DB::table('c_teams')->where('id', $id)->first();
    }

    private function getLeagues()
    {
        return DB::table('c_leagues')->where('status', 'CO')->get();
    }
}
