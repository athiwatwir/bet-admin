@extends('layouts.core')

@section('title', 'รายงานเกม')

@section('content')
<div class="row gutters-sm">
	<div class="col-12">
		<div class="portlet">
			<div class="portlet-header border-bottom">

			</div>
			<!-- /portlet : header -->
			<div class="portlet-body pt-2 px-5">
                <table class="table-datatable table table-bordered table-hover table-striped px-3"
                    data-lng-empty="ไม่มีข้อมูล..." 
                    data-lng-page-info="แสดงผลเกมที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ เกม" 
                    data-lng-filtered="(filtered from _MAX_ total entries)" 
                    data-lng-loading="กำลังโหลด..." 
                    data-lng-processing="กำลังดำเนินการ..." 
                    data-lng-search="ค้นหาเกม..." 
                    data-lng-norecords="ไม่มีเกมที่ค้นหา..." 
                    data-lng-sort-ascending=": activate to sort column ascending" 
                    data-lng-sort-descending=": activate to sort column descending" 

                    data-lng-column-visibility="ปิดการแสดงผลคอลัมน์" 
                    data-lng-csv="CSV" 
                    data-lng-pdf="PDF" 
                    data-lng-xls="XLS" 
                    data-lng-copy="Copy" 
                    data-lng-print="Print" 
                    data-lng-all="ทั้งหมด" 

                    data-main-search="true" 
                    data-column-search="false" 
                    data-row-reorder="false" 
                    data-col-reorder="true" 
                    data-responsive="true" 
                    data-header-fixed="true" 
                    data-select-onclick="false" 
                    data-enable-paging="true" 
                    data-enable-col-sorting="false" 
                    data-autofill="false" 
                    data-group="false" 
                    data-items-per-page="30" 

                    data-lng-export="<i class='fi fi-squared-dots fs--18 line-height-1'></i>" 
                    dara-export-pdf-disable-mobile="true" 
                    data-export='["csv", "pdf", "xls"]' 
                    data-options='["copy", "print"]' 
                >
                    <thead>
                        <tr class="text-muted fs--13">
                            <th>เลือกดูรายงานเกม</th>
                            <th class="text-center">จำนวนกระเป๋าเงิน</th>
                            <th class="w--150 text-center">สถานะ</th>
                        </tr>
                    </thead>

                    <tbody id="item_list">
                    @foreach ($games as $key => $game)
                        <!-- admin -->
                        <tr class="text-dark">

                            <td style="line-height: 17px;">
                                <a href="{{ route('game-view-report', ['gamecode' => $game->gamecode]) }}" class="d-flex text-dark">
                                    <img src="{{ Request::root() }}/logogames/{{ $game->logo }}" style="width: 60px;">
                                    <div class="ml-3">
                                        <span class="text-dark">{{ $game->name }}</span><br/>
                                        <small class="text-secondary fs--11">รหัสเกม : {{ $game->gamecode }}</small>
                                    </div>
                                </a>
                            </td>

                            <td class="text-center">
                                @if($game->wallet_count <= 0)
                                    <small class="text-secondary">ยังไม่มีกระเป๋าเงิน</small>
                                @else
                                    {{ $game->wallet_count }}
                                @endif
                            </td>

                            <td class="text-center">
                                @if($game->isactive == 'Y')
                                    <span class="badge badge-success font-weight-normal mt-1">เปิดใช้งาน</span>
                                @else
                                    <span class="badge badge-danger font-weight-normal mt-1">ปิดใช้งาน</span>
                                @endif
                            </td>

                        </tr>
                        <!-- /admin -->
                    @endforeach
                    </tbody>
                </table>
			</div>
		</div>
	</div>
</div>


<style>
	a.dt-button.dropdown-item.buttons-pdf.buttons-html5 {
		display: none;
	}
    button.btn.btn-secondary.buttons-collection.dropdown-toggle.buttons-colvis.btn-sm.btn-light {
        display: none;
    }
</style>
@endsection