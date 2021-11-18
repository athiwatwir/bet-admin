@extends('layouts.core')

@section('title', 'การจัดการกลุ่มธนาคาร')

@section('content')
<div class="row gutters-sm">
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
                <div class="row p-3">
                    <div class="col-md-3 p-4 text-right">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active border-bottom" id="{{ $group_default->id }}-tab" data-toggle="pill" href="#{{ $group_default->id }}" role="tab" aria-controls="{{ $group_default->id }}" aria-selected="false">
                                <p class="mb-0"><small class="mr-1">(ค่าเริ่มต้น)</small> <strong class="text-primary">{{ $group_default->name }}</strong></p>
                                <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                            </a>
                            @foreach($bgroups as $bgroup)
                            <a class="nav-link border-bottom" id="{{ $bgroup->id }}-tab" data-toggle="pill" href="#{{ $bgroup->id }}" role="tab" aria-controls="{{ $bgroup->id }}" aria-selected="false">
                                <p class="mb-0"><strong>{{ $bgroup->name }}</strong></p>
                                @if($bgroup->isactive == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-9 bg-light p-4">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="{{ $group_default->id }}" role="tabpanel" aria-labelledby="{{ $group_default->id }}-tab">
                                <div class="row border-bottom mb-2">
                                    <div class="col-md-12">
                                        <strong class="mr-2">{{ $group_default->name }} : </strong>
                                        <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                            onClick="setBankGroupDataEdit('{{ $group_default->id }}', '{{ $group_default->name }}', '{{ $group_default->isactive }}', '{{ $group_default->isdefault }}')">
                                            <i class="fi fi-pencil"></i>
                                        </a>

                                        <a  href="#!" class="text-truncate js-ajax-confirm">
                                            <i class="fi fi-thrash text-danger"></i>
                                        </a>
                                    </div>
                                </div>
                                <p>{{ $group_default->isactive }} - {{ $group_default->isdefault }}</p>
                            </div>
                            @foreach($bgroups as $bgroup)
                                <div class="tab-pane fade" id="{{ $bgroup->id }}" role="tabpanel" aria-labelledby="{{ $bgroup->id }}-tab">
                                    <div class="row border-bottom mb-2">
                                        <div class="col-md-12">
                                            <strong class="mr-2">{{ $bgroup->name }} : </strong>
                                            <a class="text-truncate mr-2" href="#!" title="แก้ไข" data-toggle="modal" data-target="#bankGroupEditModal" 
                                                onClick="setBankGroupDataEdit('{{ $bgroup->id }}', '{{ $bgroup->name }}', '{{ $bgroup->isactive }}', '{{ $bgroup->isdefault }}')">
                                                <i class="fi fi-pencil"></i>
                                            </a>

                                            <a  href="#!" class="text-truncate js-ajax-confirm">
                                                <i class="fi fi-thrash text-danger"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <p>{{ $bgroup->isactive }} - {{ $bgroup->isdefault }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('modal')
    @include('bankgroups.modal.create')
    @include('bankgroups.modal.edit')
@endsection