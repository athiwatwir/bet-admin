<div class="table-responsive">

    <table class="table table-align-middle border-bottom mb-6">

        <thead>
            <tr class="text-muted fs--13 bg-light">
                <th class="hidden-lg-down text-center" style="width: 40%;">ทีมเหย้า</th>
                <th class="hidden-lg-down text-center" style="width: 20%;">สกอร์ / วัน-เวลา</th>
                <th class="hidden-lg-down text-center" style="width: 40%;">ทีมเยือน</th>
            </tr>
        </thead>

        <tbody id="item_list">

            @foreach($matchs as $key => $match)
            <tr id="message_id_{{ $key }}" class="text-dark">
                <td class="text-center text-mobile" style="line-height: 17px;">
                    <img id="home_logo_{{ $key }}" src="{{ asset('logoteams/'.$match->home_team_logo) }}" alt="{{ $match->home_team_logo }}" width="60" class="mb-2"><br/>
                    <p class="mb-0 text-dark">{{ $match->home_team_name }}</p>
                    <small>{{ $match->home_team_en }}</small>
                </td>

                <td style="line-height: 17px;" class="text-center">
                    <form method="POST" id="frm_match_{{ $match->id }}" action="{{ url('/football/matchs/update-score') }}">
                    @csrf
                        @if($match->status == 'CO')
                        <p class="mb-0">
                            <h2 class="text-dark mb-1 mt-4" style="line-height: 0px;">
                                {{ $match->home_score }} - {{ $match->away_score }}
                            </h2> 
                        </p>
                        @elseif($match->status == 'DR')
                            <div class="row">
                                <div class="col-5 px-2 text-center">
                                    <h2 class="text-dark">
                                        <input type="number" id="home_score_{{ $key }}" class="form-control text-center input-score-style" name="home_score" value="{{ $match->home_score }}" 
                                            onKeyup="scoreUpdate({{ $key }})"
                                        >
                                    </h2>
                                </div>
                                <div class="col-2 px-2 pt-3 text-center">_</div>
                                <div class="col-5 px-2 text-center">
                                    <h2 class="text-dark">
                                        <input type="number" id="away_score_{{ $key }}" class="form-control text-center input-score-style" name="away_score" value="{{ $match->away_score }}" 
                                            onKeyup="scoreUpdate({{ $key }})"
                                        >
                                    </h2>
                                </div>
                            </div>
                        @endif
                        <small><strong>{{ date('d-m-Y', strtotime($match->datetime)) }}</strong></small>
                        <small style="font-size: 70%;">( {{ date('H:i', strtotime($match->datetime)) }} น.)</small>

                        <div id="match_action_{{ $key }}" class="text-center">
                            @if($match->status == 'DR')
                                <a class="text-truncate mr-2" href="#!" title="แก้ไขแมทซ์" data-toggle="modal" data-target="#matchEditModal"
                                    onClick="setDataEditFootballMatch(
                                        {{ $key }},
                                        {{ $match->id }}, 
                                        {{ $match->home_team }}, 
                                        {{ $match->away_team }}, 
                                        '{{ $match->datetime }}'
                                    )"
                                >
                                    <i class="fi fi-pencil"></i>
                                </a>

                                <a  href="#!" 
                                    class="text-truncate js-ajax-confirm mr-2" 
                                    title="จบการแข่งขัน" 
                                    data-href="/football/matchs/end/{{ $match->id }}"
                                    data-ajax-confirm-body="การแข่งขันจบลงแล้ว?" 

                                    data-ajax-confirm-method="GET" 

                                    data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                    data-ajax-confirm-btn-yes-text="จบการแข่งขัน" 
                                    data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                    data-ajax-confirm-btn-no-text="ยกเลิก" 
                                    data-ajax-confirm-btn-no-icon="fi fi-close"
                                >
                                    <i class="fi fi-box-checked text-success"></i>
                                </a>
                            @endif

                            <a  href="#!" 
                                class="text-truncate js-ajax-confirm mr-2"
                                title="ลบแมทซ์" 
                                data-href="/football/matchs/delete/{{ $match->id }}"
                                data-ajax-confirm-body="ยืนยันการลบ?" 

                                data-ajax-confirm-mode="ajax" 
                                data-ajax-confirm-method="GET" 

                                data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                data-ajax-confirm-btn-no-text="ยกเลิก" 
                                data-ajax-confirm-btn-no-icon="fi fi-close"

                                data-ajax-confirm-success-target="#message_id_{{ $key }}" 
                                data-ajax-confirm-success-target-action="remove">
                                <i class="fi fi-thrash text-danger"></i>
                            </a>

                        </div>
                        <div id="score_action_{{ $key }}" style="display: none;">
                            <button type="submit" id="btn-save-score" class="btn btn-success btn-vv-sm mr-2 text-center" title="บันทึก" data-key="{{ $key }}"><i class="fi fi-check mr-0"></i></button>
                            <button type="button" class="btn btn-danger btn-vv-sm mr-2 text-center" title="ยกเลิก" 
                                    onClick="clearScoreMatch({{ $key }}, {{ $match->home_score }}, {{ $match->away_score }})"
                            >
                                <i class="fi fi-close mr-0"></i>
                            </button>
                        </div>
                        <i id="score_updated_{{ $key }}" class="fi fi-circle-spin fi-spin" style="display: none;"></i>
                        <input type="hidden" name="match_id" value="{{ $match->id }}">
                    </form>
                </td>

                <td class="text-center text-mobile" style="line-height: 17px;">
                    <img id="away_logo_{{ $key }}" src="{{ asset('logoteams/'.$match->away_team_logo) }}" alt="{{ $match->away_team_logo }}" width="60" class="mb-2"><br/>
                    <p class="mb-0 text-dark">{{ $match->away_team_name }}</p>
                    <small>{{ $match->away_team_en }}</small>
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>