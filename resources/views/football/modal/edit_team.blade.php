<!-- Team Edit Modal -->
<div class="modal fade" id="teamEditModal" tabindex="-1" role="dialog" aria-labelledby="teamEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/teams/edit') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขทีมฟุตบอล <span id="edit_team_name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="league" class="col-md-4 col-form-label text-md-right">{{ __('ลีกฟุตบอล') }}</label>

                        <div class="col-md-6">
                            <select required id="league_edit" name="league_edit" class="form-control">
                                @foreach($leagues as $league)
                                    <option value="{{ $league->id }}">{{ $league->name }} @if(isset($league->name_en)) - {{ $league->name_en }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name_edit" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อทีม (ไทย)') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อทีมภาษาไทย" id="name_edit" type="text" class="form-control" name="name_edit" value="{{ old('name_edit') }}" autocomplete="name_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name_en_edit" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อทีม (อังกฤษ)') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อทีมภาษาอังกฤษ (ถ้ามี)" id="name_en_edit" type="text" class="form-control" name="name_en_edit" value="{{ old('name_en_edit') }}" autocomplete="name_en_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="code_edit" class="col-md-4 col-form-label text-md-right">{{ __('รหัสทีม') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="" id="code_edit" type="text" class="form-control" name="code_edit" value="{{ old('code_edit') }}" autocomplete="code_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logo_edit" class="col-md-4 col-form-label text-md-right">{{ __('โลโก้ทีม') }}</label>

                        <div class="col-md-6">
                            <img src="" id="logo_team" width="100"><br/><br/>
                            <small id="logo_alert_edit" class="text-danger"></small>
                            <input id="logo_edit" type="file" class="form-control" name="logo_edit" value="{{ old('logo_edit') }}" autocomplete="logo_edit" onChange="validateAndUploadTeamLogoEdit();">
                            <small class="text-danger fs--10">*ไฟล์ PNG , GIF และขนาดไม่เกิน 1 MB</small>
                        </div>
                    </div>

                    <input type="hidden" id="team_id" name="team_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" id="in-validated_edit" class="btn btn-primary btn-sm" style="display: none;" disabled>เพิ่มทีมฟุตบอล</button>
                    <button type="submit" id="is-validated_edit" class="btn btn-primary btn-sm">เพิ่มทีมฟุตบอล</button>
                </div>
            </form>
        </div>
    </div>
</div>