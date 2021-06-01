@extends('layouts.core')

@section('title', 'การจัดการสมาชิก')

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

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3">
                        + เพิ่มสมาชิก
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    สมาชิกทั้งหมด
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
                                    <th class="w--30 hidden-lg-down text-center">
                                        #
                                    </th>
                                    <th>
                                        <span class="px-2 p-0-xs">
                                            ชื่อผู้ใช้
                                        </span>
                                    </th>
                                    <th class="w--250 hidden-lg-down text-center">โทรศัพท์</th>
                                    <th class="w--150 hidden-lg-down text-center">ไลน์</th>
                                    <th class="w--150 hidden-lg-down text-center">สกุลเงิน</th>
                                    <th class="w--150 hidden-lg-down text-center">สถานะ</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach ($users as $key => $user)

                                    <!-- user -->
                                    <tr id="message_id_{{ $key }}" class="text-dark">

                                        <td class="hidden-lg-down text-center">
                                            {{ $key + 1 }}.
                                        </td>

                                        <td style="line-height: 17px;">
                                            <a class="text-dark" href="/users/{{ $user->username }}/{{ $user->id }}/view" title="ดูรายละเอียดของผู้ใช้งานนี้">
                                                <p class="mb-0 d-flex">
                                                    <strong class="text-dark">{{ $user->username }}</strong> 
                                                </p>
                                                <small style="font-size: 70%;">ชื่อ-สกุล : {{ $user->name }}</small>
                                            </a>

                                            <!-- MOBILE ONLY -->
                                            <div class="fs--13 d-block d-xl-none">
                                                <span class="d-block text-muted">{{ $user->phone }}</span>
                                                <span class="d-block text-muted">{{ $user->line }}</span>
                                            </div>
                                            <!-- /MOBILE ONLY -->
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ $user->phone }}
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            @if($user->line != '')
                                                <a href="https://line.me/R/ti/p/{{ $user->line }}" target="_blank">{{ $user->line }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="hidden-lg-down text-center">
                                            {{ $user->currency }}
                                        </td>

                                        <td class="text-center">
                                            @if($user->is_active == 'Y')
                                                <span class="badge badge-success float-end font-weight-normal mt-1">เปิดใช้งาน</span>
                                            @else
                                                <span class="badge badge-danger float-end font-weight-normal mt-1">ปิดใช้งาน</span>
                                            @endif
                                        </td>

                                    </tr>
                                    <!-- /user -->
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

                                    <li class="{{ $users->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                    </li>
                                    
                                    <li class="page-item active" aria-current="page">
                                        {{ $users->links() }}
                                    </li>
                                    
                                    <li class="{{ $users->currentPage() == $users->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}">ถัดไป</a>
                                    </li>

                                </ul>

                                <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                    <small>หน้า : {{ $users->currentPage() }} / {{ $users->lastPage() }}</small>
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
    
@endsection