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
            ->select('c_teams.*', 'c_leagues.id as league_id', 'c_leagues.name as league_name', 'c_leagues.name_en as league_en')
            ->paginate(20);

        $leagues = $this->getLeagues();

        return view('football.teams', ['teams' => $teams, 'leagues' => $leagues, 'league_id' => '']);
        
    }

    public function leagueListTeam(Request $request)
    {
        $teams = DB::table('c_teams')
            ->leftJoin('c_leagues', 'c_teams.c_league_id', '=', 'c_leagues.id')
            ->where('c_teams.status', 'CO')
            ->where('c_teams.c_league_id', $request->league_id)
            ->select('c_teams.*', 'c_leagues.id as league_id', 'c_leagues.name as league_name', 'c_leagues.name_en as league_en')
            ->paginate(20);

        $leagues = $this->getLeagues();

        return view('football.leagueteam', ['teams' => $teams, 'leagues' => $leagues, 'is_league' => $request->league_name, 'league_id' => $request->league_id]);
    }

    public function teamCreate(Request $request)
    {
        if(isset($request->name) && isset($request->league) && isset($request->code) && isset($request->logo)) {

            if(!$this->checkDupplicateTeamName($request->name)) {
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
                return redirect()->back()->with('warning', 'มีชื่อทีมนี้อยู่แล้ว กรุณาตรวจสอบ');
            }

            return redirect()->back()->with('danger', 'เกิดข้อผิดพลาด');
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



    // MATCH /////////////////////////////////
    public function matchIndex()
    {
        $matchs = DB::table('football_matchs')
                ->leftJoin('c_teams as home_team', 'football_matchs.home_team', '=', 'home_team.id')
                ->leftJoin('c_teams as away_team', 'football_matchs.away_team', '=', 'away_team.id')
                ->where('football_matchs.status', '!=', 'DL')
                ->select('football_matchs.*', 
                        'home_team.id as home_team_id', 'home_team.name as home_team_name', 'home_team.name_en as home_team_en', 'home_team.logo as home_team_logo', 
                        'away_team.id as away_team_id', 'away_team.name as away_team_name', 'away_team.name_en as away_team_en', 'away_team.logo as away_team_logo')
                ->orderBy('football_matchs.datetime', 'ASC')
                ->paginate(20);

        $leagues = $this->getLeagues();
        $teams = $this->getTeams();

        return view('football.matchs', ['matchs' => $matchs, 'leagues' => $leagues, 'teams' => $teams, 'is_league' => '', 'league_id' => '']);
    }

    public function leagueListMatch(Request $request)
    {
        $matchs = DB::table('football_matchs')
                ->leftJoin('c_teams as home_team', 'football_matchs.home_team', '=', 'home_team.id')
                ->leftJoin('c_teams as away_team', 'football_matchs.away_team', '=', 'away_team.id')
                ->where('home_team.id', $request->league_id)
                ->where('football_matchs.status', '!=', 'DL')
                ->select('football_matchs.*', 
                        'home_team.id as home_team_id', 'home_team.name as home_team_name', 'home_team.name_en as home_team_en', 'home_team.logo as home_team_logo', 
                        'away_team.id as away_team_id', 'away_team.name as away_team_name', 'away_team.name_en as away_team_en', 'away_team.logo as away_team_logo')
                ->orderBy('football_matchs.datetime', 'ASC')
                ->paginate(20);

        $leagues = $this->getLeagues();
        $teams = $this->getTeamsWithLeague($request->league_id);

        return view('football.leagueMatch', ['matchs' => $matchs, 'leagues' => $leagues, 'teams' => $teams, 'is_league' => $request->league_name, 'league_id' => $request->league_id]);
    }

    public function matchCreate(Request $request)
    {
        if(isset($request->home_team) && isset($request->away_team) && isset($request->match_date) && isset($request->match_time)) {

            DB::table('football_matchs')
                ->insert([
                    'home_team' => $this->getHomeAwayTeamId($request->home_team),
                    'away_team' => $this->getHomeAwayTeamId($request->away_team),
                    'datetime' => $request->match_date.' '.$request->match_time,
                    'home_score' => 0,
                    'away_score' => 0
                ]);

            return redirect()->back()->with('success', 'เพิ่มการแข่งขันเรียบร้อย');
        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุรายละเอียดให้ครบ');
        }
    }

    public function matchEdit(Request $request)
    {
        if(isset($request->home_team) && 
            isset($request->away_team) && 
            isset($request->match_date) && 
            isset($request->match_time)
        ) {

            DB::table('football_matchs')->where('id', $request->match_id)
                ->update([
                    'home_team' => $this->getHomeAwayTeamId($request->home_team),
                    'away_team' => $this->getHomeAwayTeamId($request->away_team),
                    'datetime' => $request->match_date.' '.$request->match_time
                ]);

            return redirect()->back()->with('success', 'แก้ไขรายละเอียดแมทซ์เรียบร้อย');
        }else{
            return redirect()->back()->with('warning', 'กรุณาระบุรายละเอียดให้ครบ');
        }
    }

    public function matchUpdateScore(Request $request)
    {
        DB::table('football_matchs')->where('id', $request->match_id)
            ->update([
                'home_score' => $request->home_score,
                'away_score' => $request->away_score
            ]);

        return redirect()->back()->with('success', 'อัพเดทสกอร์เรียบร้อยแล้ว');
    }

    public function matchDelete(Request $request)
    {
        DB::table('football_matchs')->where('id', $request->id)->update(['status' => 'DL']);

        return redirect()->back()->with('success', 'ลบแมทซ์เรียบร้อยแล้ว');
    }

    public function matchEnd(Request $request)
    {
        DB::table('football_matchs')->where('id', $request->id)->update(['status' => 'CO']);

        return redirect()->back()->with('success', 'การแข่งขันได้จบลงแล้ว');
    }



    // Private Func
    private function getTeamFirst($id)
    {
        return DB::table('c_teams')->where('id', $id)->first();
    }

    private function getLeagues()
    {
        return DB::table('c_leagues')->where('status', 'CO')->get();
    }

    private function getTeams()
    {
        return DB::table('c_teams')
                ->leftJoin('c_leagues', 'c_teams.c_league_id', '=', 'c_leagues.id')
                ->where('c_teams.status', 'CO')
                ->select('c_teams.*', 'c_leagues.name as league_name')
                ->get();
    }

    private function getTeamsWithLeague($id)
    {
        return DB::table('c_teams')
                ->leftJoin('c_leagues', 'c_teams.c_league_id', '=', 'c_leagues.id')
                ->where('c_teams.status', 'CO')
                ->where('c_leagues.id', $id)
                ->select('c_teams.*', 'c_leagues.name as league_name')
                ->get();
    }

    private function getHomeAwayTeamId($data)
    {
        $id = explode('!', $data);
        return $id[0];
    }

    private function checkDupplicateTeamName($teamName)
    {
        $checkTeamName = DB::table('c_teams')->where('name', $teamName)->where('status', 'CO')->first();
        return isset($checkTeamName) ? true : false;
    }
}
