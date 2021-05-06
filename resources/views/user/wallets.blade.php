@extends('layouts.core')

@section('title', 'Wallets Menagement')

@section('content')
<div class="row gutters-sm">

    <!-- navigation -->
    <div class="col-12 col-lg-3 col-xl-2">

        <nav class="nav-deep nav-deep-light mb-2">

            <!-- mobile only -->
            <button class="clearfix btn btn-toggle btn-sm btn-block text-align-left shadow-md border rounded mb-1 d-block d-lg-none" data-target="#nav_responsive" data-toggle-container-class="d-none d-sm-block bg-white shadow-md border animate-fadein rounded p-3">
                <span class="group-icon px-2 py-2 float-start">
                    <i class="fi fi-bars-2"></i>
                    <i class="fi fi-close"></i>
                </span>

                <span class="h5 py-2 m-0 float-start font-weight-light">
                    Inbox
                </span>
            </button>


            <!-- navigation -->
            <ul id="nav_responsive" class="nav flex-column d-none d-lg-block">

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            All Users
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            Active Users
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            InActive Users
                        </span>
                    </a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link px-0" href="{{ url('/users') }}">
                        <i class="fi fi-arrow-end m-0 fs--12"></i> 
                        <span class="px-2 d-inline-block">
                            Deleted Users
                        </span>
                    </a>
                </li>

            </ul>

        </nav>

    </div>
    <!-- /navigation -->


    <!-- inbox list -->
    <div class="col-12 col-lg-9 col-xl-10">


        <!-- portlet -->
        <div class="portlet">
            
            <!-- portlet : header -->
            <div class="portlet-header border-bottom">

                <div class="float-end">

                    <a href="/users" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        < Back
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    รายการ Wallet ของ {{ $username }}
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
                                    <th class="hidden-lg-down text-center">จำนวนเงิน</th>
                                    <th>&nbsp;</th>
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
                                            <button type="button" class="btn btn-success btn-sm btn-vv-sm rounded" title="แก้ไขเงินในกระเป๋าหลัก" 
                                                data-toggle="modal" data-target="#editWalletModal" onClick="setDataEditWalletAmount({{ $default_wallet->id }}, {{ $default_wallet->amount }} , 'หลัก')"
                                            >
                                                <i class="fi fi-pencil mr-0"></i>
                                            </button>
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
                                                <button type="button" class="btn btn-success btn-sm btn-vv-sm rounded" title="แก้ไขเงินในกระเป๋าเกม{{ $is_wallet->game_id }}" 
                                                    data-toggle="modal" data-target="#editWalletModal" onClick="setDataEditWalletAmount({{ $is_wallet->id }}, {{ $is_wallet->amount }} , {{ $is_wallet->game_id }})"
                                                >
                                                    <i class="fi fi-pencil mr-0"></i>
                                                </button>
                                                
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