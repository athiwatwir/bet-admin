@extends('layouts.core')

@section('title', 'รายการเคลื่อนไหวทางการเงิน')

@section('content')
<div class="row gutters-sm">
    <div class="col-12">
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                </div>

                @include('transaction.components.menu_top')
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0" style="background: #eef0f8;">

                <div class="row">
                    <div class="col-md-2 py-4">
                        <strong class="text-dark">เมนู</strong>
                        <ul id="nav_responsive" class="nav flex-column d-none d-sm-block mt-3 fs--14">
                            <li class="nav-item active mb-3">
                                <i class="fi fi-arrow-end m-0 fs--12"></i>
                                <a href="#!" class="transition-hover-top text-primary" id="_set-adjust-index-btn">รายการทั้งหมด</a>
                            </li>
                            <li class="nav-item mb-3">
                                <i class="fi fi-arrow-end m-0 fs--12"></i>
                                <a href="#!" class="transition-hover-top text-dark" id="_set-adjust-user-btn">ปรับเปลี่ยนยอดเงินสมาชิก</a>
                            </li>
                            <li class="nav-item mb-3">
                                <i class="fi fi-arrow-end m-0 fs--12"></i>
                                <a href="#!" class="transition-hover-top text-dark" id="_set-adjust-promotion-btn">ปรับเปลี่ยนโดยโปรโมชั่น</a>
                            </li>
                            <li class="nav-item mb-3">
                                <i class="fi fi-arrow-end m-0 fs--12"></i>
                                <a href="#!" class="transition-hover-top text-dark" id="">ทดสอบระบบ</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12 px-4 py-2 bg-white rounded">

                                <div class="row" id="_table-transaction-adjust" style="display: initial;">
                                    <div class="col-md-12">
                                        @include('transaction.components.adjust_index')
                                    </div>
                                </div>

                                <div class="row" id="_user-transaction-adjust" style="display: none;">
                                    <div class="col-md-12">
                                        @include('transaction.components.adjust_user')
                                    </div>
                                </div>

                                <div class="row" id="_promotion-transaction-adjust" style="display: none;">
                                    <div class="col-md-12">
                                        @include('transaction.components.adjust_promotion')
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>
<style>
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>

@if($type == 'ADJUST')
    <script>
        let index = document.querySelector('#_set-adjust-index-btn')
        let user = document.querySelector('#_set-adjust-user-btn')
        let promotion = document.querySelector('#_set-adjust-promotion-btn')

        let index_table = document.querySelector('#_table-transaction-adjust')
        let user_table = document.querySelector('#_user-transaction-adjust')
        let promotion_table = document.querySelector('#_promotion-transaction-adjust')

        index.addEventListener('click', () => {
            index.classList.add('text-primary')
            index.classList.remove('text-dark')

            user.classList.add('text-dark')
            promotion.classList.add('text-dark')

            index_table.style.display = 'initial'
            user_table.style.display = 'none'
            promotion_table.style.display = 'none'
        })

        user.addEventListener('click', () => {
            user.classList.add('text-primary')
            user.classList.remove('text-dark')

            index.classList.add('text-dark')
            promotion.classList.add('text-dark')

            user_table.style.display = 'initial'
            index_table.style.display = 'none'
            promotion_table.style.display = 'none'
        })

        promotion.addEventListener('click', () => {
            promotion.classList.add('text-primary')
            promotion.classList.remove('text-dark')

            index.classList.add('text-dark')
            user.classList.add('text-dark')

            promotion_table.style.display = 'initial'
            index_table.style.display = 'none'
            user_table.style.display = 'none'
        })

    </script>
@endif

@endsection

@section('modal')
    @include('user.modal.payment_slip')
    @include('user.modal.wallet_increase')
    @include('user.modal.wallet_decrease')
@endsection