@extends('layouts.core')

@section('title', 'การจัดการกลุ่มธนาคาร')

@section('content')
<div class="row gutters-sm">
    <div class="col-12 col-lg-12 col-xl-12">

        <!-- portlet -->
        <div class="portlet">

            <!-- portlet : body -->
            <div class="portlet-body pt-0">
                <div class="row p-3">
                    <div class="col-md-4 px-4 pt-1 pb-4 text-center">
                        <div class="row">
                            <div class="col-md-6 text-left mb-2">
                                <a href="{{ route('bankgroups') }}" class="btn btn-vv-sm btn-secondary btn-soft btn-pill ml-2">
                                    <i class="fi fi-home"></i>
                                    <small>กลับหน้าหลัก</small>
                                </a>
                            </div>
                            <div class="col-md-6 text-right mb-2">
                                <div class="dropdown d-inline-block">
                                    <a href="#" id="ddHClean_demo2" class="btn btn-vv-sm btn-secondary btn-soft btn-pill" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                        <span class="group-icon">
                                            <i class="fi fi-arrow-end-slim"></i>
                                            <i class="fi fi-arrow-down"></i>
                                        </span>
                                        <small>กลุ่มธนาคารอื่น</small>
                                    </a>

                                    <div aria-labelledby="ddHClean_demo2" class="dropdown-menu dropdown-menu-clean dropdown-click-ignore max-w-400">
                                        <div class="scrollable-vertical max-h-50vh">
                                            @foreach($bt_groups as $bt_group)
                                                <a class="dropdown-item text-truncate" href="{{ route('bankgroup-view', ['id' => $bt_group->id]) }}">
                                                    {{ $bt_group->name }} <small>[ {{ $bt_group->banks_count }} ]</small>
                                                    @if($bt_group->isdefault == 'Y') <small class="badge badge-primary font-weight-normal">ค่าเริ่มต้น</small> @endif 
                                                </a>
                                                <div class="dropdown-divider"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="col-md-12 mt-4">
                                <h3 class="@if($bgroup->isdefault == 'Y') text-primary @endif">{{ $bgroup->name }}</h3>
                                @if($bgroup->isdefault == 'Y')
                                    <p class="badge badge-primary font-weight-normal">ค่าเริ่มต้น</p>
                                @endif
                            </div>
                            
                            <div class="col-md-12">
                                <small>จำนวนธนาคารในกลุ่ม : <strong>{{ $bgroup->banks_count }}</strong></small>
                            </div>

                            <div class="col-md-12">
                                @if($bgroup->isactive == 'Y')
                                    <p class="badge badge-success font-weight-normal">เปิดใช้งาน</p>
                                @else
                                    <p class="badge badge-danger font-weight-normal">ปิดใช้งาน</p>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                    onClick="setBankGroupDataEdit('{{ $bgroup->id }}', '{{ $bgroup->name }}', '{{ $bgroup->isactive }}', '{{ $bgroup->isdefault }}')">
                                    <i class="fi fi-pencil"></i>
                                </a>
                                @if($bgroup->isdefault == 'N')
                                <a class="text-truncate mr-2" href="/settings/bank-groups/active/{{ $bgroup->id }}">
                                    @if($bgroup->isactive == 'Y')
                                        <span class="text-success" title="ปิดการใช้งาน"><i class="fi fi-eye"></i></span>
                                    @else
                                        <span class="text-danger" title="เปิดการใช้งาน"><i class="fi fi-eye-disabled"></i></span>
                                    @endif
                                </a>
                                <a  href="{{ route('bankgroup-delete', ['id' => $bgroup->id]) }}" class="text-truncate js-ajax-confirm"
                                    data-ajax-confirm-body="<center>ยืนยันการลบกลุ่มธนาคาร {{ $bgroup->name }} ? <br/>
                                        ธนาคารที่อยู่ในกลุ่มนี้ทั้งหมดจะกลายเป็นสถานะว่าง <br/>
                                        ยืนยันการลบ ?</center>"

                                    data-ajax-confirm-btn-yes-class="btn-sm btn-danger" 
                                    data-ajax-confirm-btn-yes-text="ลบข้อมูล" 
                                    data-ajax-confirm-btn-yes-icon="fi fi-check" 

                                    data-ajax-confirm-btn-no-class="btn-sm btn-light" 
                                    data-ajax-confirm-btn-no-text="ยกเลิก" 
                                    data-ajax-confirm-btn-no-icon="fi fi-close"
                                >
                                    <i class="fi fi-thrash text-danger"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 bg-light p-4">
                        <div class="w-100 text-right mb-4">
                            <a href="#!" class="btn btn-sm btn-primary btn-pill px-2 py-1 fs--15 mt--n3" data-toggle="modal" data-target="#addBankGroupModal">
                                + เพิ่มธนาคารเข้ากลุ่ม
                            </a>
                        </div>
                        
                        <div class="table-responsive">

                            <table class="table table-align-middle border-bottom mb-6">

                                <thead>
                                    <tr class="text-muted fs--13 bg-light">
                                        <th class="w--30 hidden-lg-down text-center">
                                            #
                                        </th>
                                        <th>
                                            <span class="px-2 p-0-xs">
                                                ธนาคาร
                                            </span>
                                        </th>
                                        <th class="hidden-lg-down text-center">ชื่อบัญชี</th>
                                        <th class="hidden-lg-down text-center">เลขบัญชี</th>
                                        <th class="w--150 hidden-lg-down text-center"></th>
                                    </tr>
                                </thead>

                                <tbody id="item_list">

                                    @foreach($cbgroups as $key => $cbgroup)
                                        <tr id="message_id_{{ $key }}" class="text-dark form-group">
                                            <td class="hidden-lg-down text-center">
                                                <input type="checkbox" id="cbgroup_select_{{$key}}" name="cbgroup_select[]" value="{{ $cbgroup->id }}" class="form-control" style="width: 16px; height: 16px;">
                                            </td>
                                            <td style="line-height: 17px;">
                                                <label for="cbgroup_select_{{$key}}" class="mb-0">
                                                    {{ $cbgroup->b_name_th }}
                                                </label>
                                            </td>
                                            <td class="hidden-lg-down text-center">
                                                <label for="cbgroup_select_{{$key}}" class="mb-0">
                                                    {{ $cbgroup->account_name }}
                                                </label>
                                            </td>
                                            <td class="hidden-lg-down text-center">
                                                <label for="cbgroup_select_{{$key}}" class="mb-0">
                                                    {{ $cbgroup->account_number }}
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <a href="#!" class="mr-1" title="ย้ายไปกลุ่มอื่น" data-toggle="modal" data-target="#transferBankGroupModal" onClick="getDataToTransfer('{{ $cbgroup->id }}')"><i class="fi fi-arrow-right-3 text-primary"></i></a>
                                                <a  href="#!" 
                                                    class="text-truncate js-ajax-confirm ml-1" 
                                                    data-href="/settings/bank-groups/cancle/{{ $cbgroup->id }}"
                                                    data-ajax-confirm-body="ยืนยันการลบบัญชีธนาคาร {{ $cbgroup->account_name }} : {{ $cbgroup->account_number }} ?" 

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
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('modal')
    @include('bankgroups.modal.add')
    @include('bankgroups.modal.create')
    @include('bankgroups.modal.edit')
    @include('bankgroups.modal.transfer')
@endsection