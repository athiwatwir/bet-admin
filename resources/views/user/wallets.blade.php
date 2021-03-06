@extends('layouts.core')

@section('title', 'จัดการกระเป๋าเงิน')

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
                    รายการกระเป๋าเงินของ {{ $username }}
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">

                <form novalidate class="bs-validate" id="form_id" method="post" action="#!">
                @csrf
                    <input type="hidden" id="action" name="action" value=""><!-- value populated by js -->

                    <div class="table-responsive">

                        <table class="table table-align-middle border-bottom mb-6">

                            <thead>
                                <tr class="text-muted fs--13 bg-light">
                                    <th class="hidden-lg-down text-center">#</th>
                                    <th>
                                        <span class="px-2 p-0-xs">
                                            รายการกระเป๋า
                                        </span>
                                    </th>
                                    <th class="w--200 hidden-lg-down text-center">จำนวนเงิน</th>
                                    <th class="w--200">&nbsp;</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">
                                <tr class="bg-light">
                                    <td class="hidden-lg-down text-center">
                                        0
                                    </td>
                                    <td class="hidden-lg-down">
                                        <strong>กระเป๋าเงินหลัก</strong>
                                    </td>
                                    <td class="hidden-lg-down text-center">
                                        {{ number_format($default_wallet->amount) }} {{ $default_wallet->currency }}
                                    </td>
                                    <td class="hidden-lg-down text-center">
                                        <div class="flex text-right">
                                            <a href="#!" title="แก้ไขเงินในกระเป๋าหลัก" 
                                                data-toggle="modal" data-target="#editWalletModal" onClick="setDataEditWalletAmount({{ $default_wallet->id }}, {{ $default_wallet->amount }} , 'หลัก')"
                                            >
                                                <i class="fi fi-pencil mr-0"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                @foreach($wallets as $key => $is_wallet)
                                    <tr id="message_id_{{ $key }}" class="text-dark">
                                        <td class="hidden-lg-down text-center">
                                            <small>{{ $key+1 }}.</small>
                                        </td>
                                        <td>
                                            <p class="mb-0 d-flex">
                                                {{ $is_wallet->game_id }}
                                            </p>

                                            <!-- MOBILE ONLY -->
                                            <div class="fs--13 d-block d-xl-none">
                                                <span class="d-block text-muted"></span>
                                                <span class="d-block text-muted"></span>
                                            </div>
                                            <!-- /MOBILE ONLY -->
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ number_format($is_wallet->amount) }} {{ $is_wallet->currency }}
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            <div class="flex text-right">
                                                <a href="#!" title="แก้ไขเงินในกระเป๋าเกม{{ $is_wallet->game_id }}" 
                                                    data-toggle="modal" data-target="#editWalletModal" onClick="setDataEditWalletAmount({{ $is_wallet->id }}, {{ $is_wallet->amount }} , {{ $is_wallet->game_id }})"
                                                >
                                                    <i class="fi fi-pencil mr-0"></i>
                                                </a>
                                                
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>



                    <!-- options and pagination -->
                    <div class="row text-center-xs">

                        <div class="hidden-lg-down col-12 col-xl-6">

                            <!-- SELECTED ITEMS -->
                            
                            <!-- /SELECTED ITEMS -->

                        </div>


                        <div class="col-12 col-xl-6">

                            <!-- pagination -->
                            <nav aria-label="pagination">
                                <ul class="pagination pagination-pill justify-content-end justify-content-center justify-content-md-end">

                                    <li class="{{ $wallets->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                        <a class="page-link" href="{{ $wallets->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                    </li>
                                    
                                    <li class="page-item active" aria-current="page">
                                        {{ $wallets->links() }}
                                    </li>
                                    
                                    <li class="{{ $wallets->currentPage() == $wallets->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                        <a class="page-link" href="{{ $wallets->nextPageUrl() }}">ถัดไป</a>
                                    </li>

                                </ul>

                                <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                    <small>หน้า : {{ $wallets->currentPage() }} / {{ $wallets->lastPage() }}</small>
                                </div>
                            </nav>
                            <!-- pagination -->

                        </div>

                    </div>
                    <!-- /options and pagination -->

                </form>

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
@endsection