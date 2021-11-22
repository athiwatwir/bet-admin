@extends('layouts.core')

@section('title', 'การจัดการกลุ่มลูกค้า')

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

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#createUserLevel">
                        + เพิ่มกลุ่มลูกค้า
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    กลุ่มลูกค้าทั้งหมด
                </span>
            </div>
            <!-- /portlet : header -->


            <!-- portlet : body -->
            <div class="portlet-body pt-0">

                <div class="table-responsive">

                    <table class="table table-align-middle border-bottom mb-6">

                        <thead>
                            <tr class="text-muted fs--13 bg-light">
                                <th class="w--30 hidden-lg-down text-center">
                                    #
                                </th>
                                <th>
                                    <span class="px-2 p-0-xs">
                                        กลุ่มลูกค้า
                                    </span>
                                </th>
                                <th class="hidden-lg-down text-center">ยอดฝากสูงสุด</th>
                                <th class="hidden-lg-down text-center">ยอดถอนสูงสุด</th>
                                <th class="hidden-lg-down text-center">ยอดโอนสูงสุด</th>
                                <th class="hidden-lg-down text-center">สถานะ</th>
                                <th class="w--150 hidden-lg-down text-center"></th>
                            </tr>
                        </thead>

                        <tbody id="item_list">

                            @foreach ($levels as $key => $level)

                                <!-- user -->
                                <tr id="level_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down text-center">
                                        {{ $key + 1 }}.
                                    </td>

                                    <td style="line-height: 17px;">
                                        <span class="@if($level->isdefault == 'Y') text-danger @endif">
                                            {{ $level->name }}
                                        </span>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="d-block text-muted">ฝาก : {{ number_format($level->limit_deposit) }}</span>
                                            <span class="d-block text-muted">ถอน : {{ number_format($level->limit_withdraw) }}</span>
                                            <span class="d-block text-muted">ย้าย : {{ number_format($level->limit_transfer) }}</span>
                                            <span class="d-block text-muted">
                                                @if($level->isactive == 'Y')
                                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                                @else
                                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                                @endif
                                            </span>
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ number_format($level->limit_deposit) }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ number_format($level->limit_withdraw) }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        {{ number_format($level->limit_transfer) }}
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($level->isactive == 'Y')
                                            <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                        @else
                                            <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#editUserLevel" onClick="setDataUserLevel('{{$level->id}}', '{{$level->name}}', {{$level->limit_deposit}}, {{$level->limit_withdraw}}, {{$level->limit_transfer}}, '{{$level->isdefault}}')">
                                            <i class="fi fi-pencil"></i>
                                        </a>
                                        @if($level->isdefault == 'N')
                                            <a class="text-truncate mr-2" href="/user-levels/active/{{ $level->id }}/{{ $level->name }}">
                                                @if($level->isactive == 'Y')
                                                    <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                                @else
                                                    <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                                @endif
                                            </a>
                                        
                                            <a  href="#!" 
                                                class="text-truncate js-ajax-confirm" 
                                                data-href="/user-levels/delete/{{ $level->id }}"
                                                data-ajax-confirm-body="ยืนยันการลบเลเวล {{ $level->name }} ?" 

                                                data-ajax-confirm-mode="ajax" 
                                                data-ajax-confirm-method="GET" 

                                                data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                                data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                                data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                                data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                                data-ajax-confirm-btn-no-text="ยกเลิก" 
                                                data-ajax-confirm-btn-no-icon="fi fi-close"

                                                data-ajax-confirm-success-target="#level_id_{{ $key }}" 
                                                data-ajax-confirm-success-target-action="remove">
                                                <i class="fi fi-thrash text-danger"></i>
                                            </a>
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

                                <li class="{{ $levels->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                    <a class="page-link" href="{{ $levels->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                </li>
                                
                                <li class="page-item active" aria-current="page">
                                    {{ $levels->links() }}
                                </li>
                                
                                <li class="{{ $levels->currentPage() == $levels->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                    <a class="page-link" href="{{ $levels->nextPageUrl() }}">ถัดไป</a>
                                </li>

                            </ul>

                            <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                <small>หน้า : {{ $levels->currentPage() }} / {{ $levels->lastPage() }}</small>
                            </div>
                        </nav>
                        <!-- pagination -->

                    </div>

                </div>
                <!-- /options and pagination -->

            </div>
            <!-- /portlet : body -->

        </div>
        <!-- /portlet -->


    </div>
    <!-- /inbox list -->

</div>
@endsection

@section('modal')
    @include('userlevel.modal.create_userlevel')
    @include('userlevel.modal.edit_userlevel')
@endsection