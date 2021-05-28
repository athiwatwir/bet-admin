<div class="table-responsive">

    <table class="table table-align-middle border-bottom mb-6">

        <thead>
            <tr class="text-muted fs--13 bg-light">
                <th class="w--30 hidden-lg-down text-center">
                    #
                    <!-- <label class="form-checkbox form-checkbox-primary float-start">
                        <input class="checkall" data-checkall-container="#item_list" type="checkbox" name="checkbox">
                        <i></i>
                    </label> -->
                </th>
                <th class="w--120 hidden-lg-down text-center">โลโก้</th>
                <th>
                    <span class="px-2 p-0-xs">
                        ชื่อทีม
                    </span>
                </th>
                <th class="hidden-lg-down text-center">ลีก</th>
                <th class="hidden-lg-down text-center">รหัสทีม</th>
                <th class="w--100 hidden-lg-down text-center">สถานะ</th>
                <th class="w--100">&nbsp;</th>
            </tr>
        </thead>

        <tbody id="item_list">

            @foreach($teams as $key => $team)
            <tr id="message_id_{{ $key }}" class="text-dark">

                <td class="hidden-lg-down text-center">
                    {{ $key + 1 }}
                    <!-- <label class="form-checkbox form-checkbox-secondary float-start">
                        <input type="checkbox" name="item_id[]" value="{{ $key }}">
                        <i></i>
                    </label> -->
                </td>

                <td class="hidden-lg-down text-center">
                    <img src="{{ asset('logoteams/'.$team->logo) }}" width="60">
                </td>

                <td style="line-height: 17px;">
                    <p class="mb-0 d-flex">
                        <strong class="text-dark">{{ $team->name }}</strong> 
                    </p>
                    <small style="font-size: 70%;">{{ $team->name_en }}</small>

                    <!-- MOBILE ONLY -->
                    <div class="fs--13 d-block d-xl-none">
                        <strong>สถานะ :</strong> 
                        @if($team->is_active == 'Y')
                            <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                        @else
                            <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                        @endif
                    </div>
                    <!-- /MOBILE ONLY -->
                </td>

                <td class="hidden-lg-down text-center" style="line-height: 17px;">
                    <p class="mb-0 text-dark">{{ $team->league_name }}</p>
                    <small><small class="text-secondary">{{ $team->league_en }}</small></small>
                </td>

                <td class="hidden-lg-down text-center">
                    {{ $team->code }}
                </td>

                <td class="hidden-lg-down text-center">
                    @if($team->is_active == 'Y')
                        <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                    @else
                        <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                    @endif
                </td>

                <td class="text-center">

                    <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#teamEditModal" 
                        onClick="setFootballTeamDataEdit(
                            {{ $team->id }}, 
                            {{ $team->c_league_id }}, 
                            '{{ $team->name }}', 
                            '{{ $team->name_en }}', 
                            '{{ $team->code }}', 
                            '{{ $team->logo }}'
                        )">
                        <i class="fi fi-pencil"></i>
                    </a>

                    <a class="text-truncate mr-2" href="/football/teams/active/{{ $team->id }}/{{ $team->name }}">
                        @if($team->is_active == 'Y')
                            <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                        @else
                            <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                        @endif
                    </a>

                    <a  href="#!" 
                        class="text-truncate js-ajax-confirm" 
                        data-href="/football/teams/delete/{{ $team->id }}/{{ $team->name }}"
                        data-ajax-confirm-body="ยืนยันการลบทีม {{ $team->name }} ?" 

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
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>

</div>