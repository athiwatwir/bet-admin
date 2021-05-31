<!-- Match Add Modal -->
<div class="modal fade" id="matchEditModal" tabindex="-1" role="dialog" aria-labelledby="matchEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/matchs/edit') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขแมทซ์ฟุตบอล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row mb-4">
                        <div class="col-md-6 text-center">
                            <label for="home_team_edit">{{ __('ทีมเหย้า') }}</label>

                            <select required id="home_team_edit" name="home_team" class="form-control">
                                <option value="" selected disabled>-- เลือกทีมเหย้า --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}!{{ $team->logo }}">{{ $team->name }} ({{ $team->name_en }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 text-center">
                            <label for="away_team_edit">{{ __('ทีมเยือน') }}</label>
                            
                            <select required id="away_team_edit" name="away_team" class="form-control">
                                <option value="" selected disabled>-- เลือกทีมเยือน --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}!{{ $team->logo }}">{{ $team->name }} ({{ $team->name_en }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr/>

                    <div id="match_show" class="form-group row">
                        <div class="col-md-3 text-center">
                            <img src="" id="home_team_logo_edit" class="w--150">
                        </div>
                        <div class="col-md-1 px-0 text-center">
                            <input required id="home_score" type="number" class="form-control" name="home_score">
                        </div>
                        <div class="col-md-4 text-center px-4">
                            <label for="match_date_edit">{{ __('วัน-เวลา แข่งขัน') }}</label>
                            <input id="match_date_edit" type="date" class="form-control mb-2" name="match_date">
                            <input id="match_time_edit" type="time" class="form-control" name="match_time">
                        </div>
                        <div class="col-md-1 px-0 text-center">
                            <input required id="away_score" type="number" class="form-control" name="away_score">
                        </div>
                        <div class="col-md-3 text-center">
                            <img src="" id="away_team_logo_edit" class="w--150 mb-2">
                        </div>
                    </div>

                    <input type="hidden" id="match_id" name="match_id">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" id="is-validated" class="btn btn-primary btn-sm">แก้ไขรายละเอียด</button>
                </div>
            </form>
        </div>
    </div>
</div>