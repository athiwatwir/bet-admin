@extends('layouts.core')

@section('title', 'การจัดการกลุ่มธนาคาร')

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

                    <a href="message-write.html" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#bankGroupCreateModal">
                        + เพิ่มกลุ่มธนาคาร
                    </a>

                </div>

                <span class="d-block text-muted text-truncate font-weight-medium pt-1">
                    กลุ่มธนาคารทั้งหมด
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
                                        กลุ่มธนาคาร
                                    </span>
                                </th>
                                <th class="hidden-lg-down text-center">สถานะ</th>
                                <th class="w--150 hidden-lg-down text-center"></th>
                            </tr>
                        </thead>

                        <tbody id="item_list">
                            @if(isset($group_default))
                                <tr class="text-dark">
                                    <td class="hidden-lg-down text-center">
                                        
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0 d-flex">
                                            <a href="{{ route('bankgroup-view', ['id' => $group_default->id]) }}">
                                                <strong class="text-primary mr-2">{{ $group_default->name }}</strong> 
                                            </a>
                                            <small>[ {{ $group_default->banks_count }} ]</small>
                                            <small class="ml-2">
                                                <span class="badge badge-primary font-weight-normal">ค่าเริ่มต้น</span>
                                            </small>
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                    </td>

                                    <td class="text-center">
                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                            onClick="setBankGroupDataEdit('{{ $group_default->id }}', '{{ $group_default->name }}', '{{ $group_default->isactive }}', '{{ $group_default->isdefault }}')">
                                            <i class="fi fi-pencil"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endif
                            @foreach($bank_groups as $key => $bgroup)
                                <tr id="message_id_{{ $key }}" class="text-dark">

                                    <td class="hidden-lg-down text-center">
                                        <small>{{ $key + 1 }}.</small>
                                    </td>

                                    <td style="line-height: 17px;">
                                        <p class="mb-0 d-flex">
                                            <a href="{{ route('bankgroup-view', ['id' => $bgroup->id]) }}">
                                                <strong class="text-dark mr-2">{{ $bgroup->name }}</strong> 
                                            </a>
                                            <small>[ {{ $bgroup->banks_count }} ]</small>
                                        </p>

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            @if($bgroup->isactive == 'Y')
                                                <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                            @else
                                                <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                            @endif
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($bgroup->isactive == 'Y')
                                            <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                        @else
                                            <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                            onClick="setBankGroupDataEdit('{{ $bgroup->id }}', '{{ $bgroup->name }}', '{{ $bgroup->isactive }}', '{{ $bgroup->isdefault }}')">
                                            <i class="fi fi-pencil"></i>
                                        </a>

                                        <a  href="#!" 
                                            class="text-truncate js-ajax-confirm" 
                                            data-href="/settings/bank-groups/delete/{{ $bgroup->id }}"
                                            data-ajax-confirm-body="ยืนยันการลบบัญชีธนาคาร {{ $bgroup->name }} ?" 

                                            data-ajax-confirm-mode="ajax" 
                                            data-ajax-confirm-method="GET" 

                                            data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                            data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                            data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                            data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                            data-ajax-confirm-btn-no-text="ยกเลิก" 
                                            data-ajax-confirm-btn-no-icon="fi fi-close"

                                            data-ajax-confirm-success-target="#message_id_{{ $key }}" 
                                            data-ajax-confirm-success-target-action="remove">
                                            <i class="fi fi-thrash text-danger"></i>
                                        </a>
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

                                <li class="{{ $bank_groups->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                    <a class="page-link" href="{{ $bank_groups->previousPageUrl() }}" tabindex="-1" aria-disabled="true">Prev</a>
                                </li>
                                
                                <li class="page-item active" aria-current="page">
                                    {{ $bank_groups->links() }}
                                </li>
                                
                                <li class="{{ $bank_groups->currentPage() == $bank_groups->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                    <a class="page-link" href="{{ $bank_groups->nextPageUrl() }}">Next</a>
                                </li>

                            </ul>

                            <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                <small>หน้า : {{ $bank_groups->currentPage() }} / {{ $bank_groups->lastPage() }}</small>
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
    @include('bankgroups.modal.create')
    @include('bankgroups.modal.edit')
@endsection