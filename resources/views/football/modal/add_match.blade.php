<!-- Match Add Modal -->
<div class="modal fade" id="matchCreateModal" tabindex="-1" role="dialog" aria-labelledby="matchCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-60" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/matchs/create') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มแมทซ์ฟุตบอล {{ $is_league }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row mb-4">
                        <div class="col-md-6 text-center mt-2">
                            <label for="home_team">{{ __('ทีมเหย้า') }}</label>

                            <select required id="home_team" name="home_team" class="form-control">
                                <option value="" selected disabled>-- เลือกทีมเหย้า --</option>
                                @foreach($teams as $team)
                                    @if($league_id == $team->c_league_id)
                                        <option value="{{ $team->id }}!{{ $team->logo }}">{{ $team->name }} ({{ $team->name_en }})</option>
                                    @else
                                        <option value="{{ $team->id }}!{{ $team->logo }}">{{ $team->name }} ({{ $team->name_en }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 text-center mt-2">
                            <label for="away_team">{{ __('ทีมเยือน') }}</label>
                            
                            <select required id="away_team" name="away_team" class="form-control">
                                <option value="" selected disabled>-- เลือกทีมเยือน --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}!{{ $team->logo }}">{{ $team->name }} ({{ $team->name_en }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr/>

                    <div id="match_show" class="form-group row">
                        <div class="hidden-lg-down col-md-4 text-center">
                            <img src="" id="home_team_logo" class="w--150">
                        </div>
                        <div class="col-md-4 text-center px-4">
                            <label for="match_date_edit">{{ __('วัน-เวลา แข่งขัน') }}</label>
                            <input required id="add_match_date" type="date" class="form-control mb-2" name="match_date">
                            <input required id="add_match_time" type="time" class="form-control" name="match_time">
                        </div>
                        <div class="hidden-lg-down col-md-4 text-center">
                            <img src="" id="away_team_logo" class="w--150">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" onClick="clearDataCreateMatch()">ยกเลิก</button>
                    <button type="submit" id="is-validated" class="btn btn-primary btn-sm">เพิ่มแมทซ์</button>
                </div>
            </form>
        </div>
    </div>
</div>