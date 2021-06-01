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

                <td class="text-center" style="line-height: 17px;">
                    <img src="{{ asset('logoteams/'.$match->home_team_logo) }}" width="60" class="mb-2"><br/>
                    <p class="mb-0 text-dark">{{ $match->home_team_name }}</p>
                    <small>{{ $match->home_team_en }}</small>
                </td>

                <td style="line-height: 17px;" class="text-center">
                    <p class="mb-0">
                        <h2 class="text-dark mb-1 mt-4" style="line-height: 0px;">{{ $match->home_score }} - {{ $match->away_score }}</h2> 
                    </p>
                    <small><strong>{{ date('d-m-Y', strtotime($match->datetime)) }}</strong></small>
                    <small style="font-size: 70%;">( {{ date('H:i', strtotime($match->datetime)) }} น.)</small>

                    <div class="text-center">
                        @if($match->status == 'DR')
                            <a class="text-truncate mr-2" href="#!" title="แก้ไขแมทซ์" data-toggle="modal" data-target="#matchEditModal"
                                onClick="setDataEditFootballMatch(
                                    {{ $match->id }}, 
                                    {{ $match->home_team }}, 
                                    {{ $match->away_team }}, 
                                    '{{ $match->datetime }}',
                                    {{ $match->home_score }},
                                    {{ $match->away_score }},
                                    '{{ $match->home_team_logo }}',
                                    '{{ $match->away_team_logo }}'
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

                    <!-- MOBILE ONLY -->
                    <div class="fs--13 d-block d-xl-none">

                    </div>
                    <!-- /MOBILE ONLY -->
                </td>

                <td class="text-center" style="line-height: 17px;">
                    <img src="{{ asset('logoteams/'.$match->away_team_logo) }}" width="60" class="mb-2"><br/>
                    <p class="mb-0 text-dark">{{ $match->away_team_name }}</p>
                    <small>{{ $match->away_team_en }}</small>
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>