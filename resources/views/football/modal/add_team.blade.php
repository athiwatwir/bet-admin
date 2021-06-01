<!-- Team Add Modal -->
<div class="modal fade" id="teamCreateModal" tabindex="-1" role="dialog" aria-labelledby="teamCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-60" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/teams/create') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มทีมฟุตบอล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="league" class="col-md-4 col-form-label text-md-right">{{ __('ลีกฟุตบอล') }}</label>

                        <div class="col-md-6">
                            <select required id="league" name="league" class="form-control">
                                <option value="" selected disabled>-- เลือกลีกฟุตบอล --</option>
                                @foreach($leagues as $league)
                                    @if($league_id == $league->id)
                                        <option value="{{ $league->id }}" selected>{{ $league->name }} @if(isset($league->name_en)) - {{ $league->name_en }} @endif</option>
                                    @else
                                        <option value="{{ $league->id }}">{{ $league->name }} @if(isset($league->name_en)) - {{ $league->name_en }} @endif</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อทีม (ไทย)') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อทีมภาษาไทย" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อทีม (อังกฤษ)') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อทีมภาษาอังกฤษ (ถ้ามี)" id="name_en" type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" autocomplete="name_en">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('รหัสทีม') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="" id="code" type="text" class="form-control" name="code" value="{{ old('name_en') }}" autocomplete="code">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('โลโก้ทีม') }}</label>

                        <div class="col-md-6">
                            <small id="logo_alert" class="text-danger"></small>
                            <input required id="logo" type="file" class="form-control" name="logo" value="{{ old('logo') }}" autocomplete="logo" onChange="validateAndUploadTeamLogo();">
                            <small class="text-danger fs--10">*ไฟล์ PNG , GIF และขนาดไม่เกิน 1 MB</small>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" id="in-validated" class="btn btn-primary btn-sm" style="display: none;" disabled>เพิ่มทีมฟุตบอล</button>
                    <button type="submit" id="is-validated" class="btn btn-primary btn-sm">เพิ่มทีมฟุตบอล</button>
                </div>
            </form>
        </div>
    </div>
</div>