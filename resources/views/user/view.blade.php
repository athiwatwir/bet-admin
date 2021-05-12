@extends('layouts.core')

@section('title', 'รายละเอียดสมาชิก')

@section('content')
<div class="row gutters-sm">

    <!-- navigation -->
    
    <!-- /navigation -->


    <!-- inbox list -->
    <div class="col-12 col-lg-12 col-xl-12">

        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">
                    <a href="/users" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        < ย้อนกลับ
                    </a>
                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    รายละเอียดสมาชิก <strong class="text-dark">{{ $username }}</strong>
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">

                <div class="row mt-2">
                    <div class="col-3" style="padding-right: 0;">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                รายละเอียดผู้ใช้
                            </a>
                            <a class="nav-link" id="v-pills-wallet-tab" data-toggle="pill" href="#v-pills-wallet" role="tab" aria-controls="v-pills-wallet" aria-selected="false">
                                กระเป๋าเงิน
                            </a>
                            <a class="nav-link" id="v-pills-paymenttransaction-tab" data-toggle="pill" href="#v-pills-paymenttransaction" role="tab" aria-controls="v-pills-paymenttransaction" aria-selected="false">
                                รายการเครื่องไหวทางการเงิน
                            </a>
                        </div>
                    </div>
                    <div class="col-9 py-4 rounded bordered" style="background-color: #f4f8ff;">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                @include('user.view.profile')
                            </div>
                            <div class="tab-pane fade" id="v-pills-wallet" role="tabpanel" aria-labelledby="v-pills-wallet-tab">
                                @include('user.view.wallets')
                            </div>
                            <div class="tab-pane fade" id="v-pills-paymenttransaction" role="tabpanel" aria-labelledby="v-pills-paymenttransaction-tab">
                                @include('user.view.paymenttransaction')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>
    <!-- /inbox list -->

</div>
@endsection

@section('modal')
    @include('user.modal.wallet_edit')

    @include('user.modal.payment_slip')
@endsection