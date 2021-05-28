<!-- League Add Modal -->
<div class="modal fade" id="leagueCreateModal" tabindex="-1" role="dialog" aria-labelledby="leagueCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/football/leagues/create') }}" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มลีก</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อลีก (ไทย)') }}</label>

                        <div class="col-md-6">
                            <input required placeholder="ชื่อลีกภาษาไทย" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อลีก (อังกฤษ)') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อลีกภาษาอังกฤษ (ถ้ามี)" id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" autocomplete="name_en">
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มลีกฟุตบอล</button>
                </div>
            </form>
        </div>
    </div>
</div>