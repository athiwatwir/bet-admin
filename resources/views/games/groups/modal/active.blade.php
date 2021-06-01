<!-- Bank Edit Modal -->
<div class="modal fade" id="groupActiveModal" tabindex="-1" role="dialog" aria-labelledby="groupActiveModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-60" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/games/groups/active') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">ยืนยันการแก้ไขสถานะกลุ่มเกม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    
                    <p class="mb-3"><strong>กลุ่มเกม <span id="active_game_group_name"></span> ยังมีรายการเกมอยู่ <span id="active_game_group_count" class="text-danger"></span> เกม</strong></p>
                    <p class="mb-2">กรุณาตรวจสอบและดำเนินการย้ายกลุ่ม</p>
                    <p class="mb-2">หรือ</p>
                    <p>กดปุ่ม "ยืนยัน" เพื่อทำการแก้ไขสถานะเกมนั้นๆทั้งหมด</p>

                    <input type="hidden" id="active_game_group_id" name="active_game_group_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>