<!-- League Edit Modal -->
<div class="modal fade" id="leagueEditModal" tabindex="-1" role="dialog" aria-labelledby="leagueEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/leagues/edit') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขลีก <span id="league_name"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name_edit" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อลีก (ไทย)') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อลีกภาษาไทย" id="name_edit" type="text" class="form-control @error('name_edit') is-invalid @enderror" name="name_edit" value="{{ old('name_edit') }}" autocomplete="name_edit">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name_en_edit" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อลีก (อังกฤษ)') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อลีกภาษาอังกฤษ (ถ้ามี)" id="name_en_edit" type="text" class="form-control @error('name_en_edit') is-invalid @enderror" name="name_en_edit" value="{{ old('name_en_edit') }}" autocomplete="name_en_edit">
                        </div>
                    </div>

                    <input id="league_id" type="hidden" name="league_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">แก้ไขลีกฟุตบอล</button>
                </div>
            </form>
        </div>
    </div>
</div>