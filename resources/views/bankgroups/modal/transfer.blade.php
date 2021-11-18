<!-- Bank Edit Modal -->
<div class="modal fade" id="transferBankGroupModal" tabindex="-1" role="dialog" aria-labelledby="transferBankGroupModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/settings/bank-groups/transfer') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ย้ายไปยังกลุ่มธนาคารอื่น</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-control" name="transer_to" required>
                        <option value="" disabled selected>-- เลือกกลุ่มธนาคาร --</option>
                        @foreach($bt_groups as $bt_group)
                            <option value="{{ $bt_group->id }}">{{ $bt_group->name }} @if($bt_group->isdefault == 'Y') (ค่าเริ่มต้น) @endif [ {{ $bt_group->banks_count }} ]</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="transfer_id" name="transfer_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">ย้าย</button>
                </div>
            </form>
        </div>
    </div>
</div>