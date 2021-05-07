<!-- Bank Edit Modal -->
<div class="modal fade" id="gameTransferModal" tabindex="-1" role="dialog" aria-labelledby="gameTransferModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/groups/game-transfer') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ย้ายกลุ่มเกม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="group_name" class="col-md-4 col-form-label text-md-right">{{ __('ย้ายไปยังกลุ่ม') }}</label>

                        <div class="col-md-6">
                            <select required id="group_id" class="form-control" name="group_id">
                                @foreach($groups as $group)
                                    @if($group->id == $group_id)
                                        <option value="{{ $group->id }}" selected disabled>{{ $group->name }} @if($group->is_active == 'N') (กลุ่มเกมถูกปิดอยู่) @endif</option>
                                    @else
                                        <option value="{{ $group->id }}">{{ $group->name }} @if($group->is_active == 'N') (กลุ่มเกมถูกปิดอยู่) @endif</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-danger">** หากย้ายเกมไปยังกลุ่มเกมที่ถูกปิดอยู่ ตัวเกมจะถูกปิดไปด้วย...</small>
                        </div>
                    </div>

                    <input type="hidden" id="game_transfer_id" name="game_transfer_id" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">ย้ายกลุ่ม</button>
                </div>
            </form>
        </div>
    </div>
</div>