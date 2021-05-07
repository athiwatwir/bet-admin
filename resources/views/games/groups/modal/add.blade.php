<!-- Bank Edit Modal -->
<div class="modal fade" id="groupGameCreateModal" tabindex="-1" role="dialog" aria-labelledby="groupGameCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/groups/create') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มกลุ่มเกม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="group_name" class="col-md-4 col-form-label text-md-right">{{ __('ชื่อกลุ่มเกม') }}</label>

                        <div class="col-md-6">
                            <input placeholder="ชื่อกลุ่มเกม" id="group_name" type="text" class="form-control @error('group_name') is-invalid @enderror" name="group_name" value="{{ old('group_name') }}" autocomplete="group_name">
                            
                            @error('group_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่มกลุ่ม</button>
                </div>
            </form>
        </div>
    </div>
</div>