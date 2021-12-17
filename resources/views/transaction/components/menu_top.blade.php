<span class="d-block text-muted text-truncate font-weight-medium pt-1">
    <a href="@if($type == '') #! @else {{ route('transaction-all') }} @endif" class="btn btn-sm btn-outline-secondary btn-secondary-hover @if($type == '') btn-primary  btn-hover-none text-white @else btn-soft @endif mb-1 mr-3 ml-3">รายการทั้งหมด</a>
    <a href="@if($type == 'DEPOSIT') #! @else {{ route('transaction-deposit') }} @endif" class="btn btn-sm btn-outline-secondary btn-secondary-hover @if($type == 'DEPOSIT') btn-primary  btn-hover-none text-white @else btn-soft @endif mb-1 mr-3">คำร้องการฝากเงิน</a>
    <a href="@if($type == 'TRANSFER') #! @else {{ route('transaction-transfer') }} @endif" class="btn btn-sm btn-outline-secondary btn-secondary-hover @if($type == 'TRANSFER') btn-primary  btn-hover-none text-white @else btn-soft @endif mb-1 mr-3">รายการโอนในระบบ</a>
    <a href="@if($type == 'WITHDRAW') #! @else {{ route('transaction-withdraw') }} @endif" class="btn btn-sm btn-outline-secondary btn-secondary-hover @if($type == 'WITHDRAW') btn-primary  btn-hover-none text-white @else btn-soft @endif mb-1 mr-3">การถอนเงิน</a>
    <a href="@if($type == 'ADJUST') #! @else {{ route('transaction-adjust') }} @endif" class="btn btn-sm btn-outline-secondary btn-secondary-hover @if($type == 'ADJUST') btn-primary btn-hover-none text-white @else btn-soft @endif mb-1 mr-3">ปรับเปลี่ยนยอดเงิน</a>
</span>

<style>
    .btn-secondary-hover:hover {
        background-color: #377dffa3;
    }
    .btn-hover-none:hover {
        background-color: #377dff;
    }
</style>