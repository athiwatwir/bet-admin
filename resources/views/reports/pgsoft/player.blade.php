@extends('layouts.core')

@section('title', 'รายละเอียด PG สล๊อต')

@section('content')
<div class="row gutters-sm">
	<div class="col-12 col-md-8 offset-md-2 mb-3 bg-light p-2 rounded">
		<div class="portlet">
			<div class="portlet-body">
                <div class="row gutters-sm">
                    <div class="col-md-4 px-3 pt-2">
                        <h4 class="mb-4">รายละเอียดการเล่นเกม</h4>
                        <div class="border rounded px-2 py-3 mb-3">
                            <p><small>บัญชีผู้ใช้งาน :</small> <strong><a href="/users/{{ $player }}/{{ $player_id }}/view" class="text-dark border-bottom" target="_blank"><i class="fas fa-user-circle"></i> {{ $player }}</a></strong> </p>
                            <p><small>จำนวนการเล่นทั้งหมด :</small> <strong class="text-dark">{{ number_format($hands) }}</strong> <small>ครั้ง</small> </p>
                            <p><small>จำนวนเงินเดิมพันทั้งหมด :</small> <strong class="text-primary">{{ number_format($betAmount, 2) }}</strong> <small>฿</small> </p>
                            <p><small><span class="text-success">ชนะ</span> / <span class="text-danger">แพ้</span> ทั้งหมด :</small> <strong class="@if($winLossAmount > 0) text-success @elseif($winLossAmount < 0) text-danger @endif my-2">{{ number_format($winLossAmount, 2) }}</strong> <small>฿</small> </p>
                        </div>
                        <a href="{{ url('/reports/pgsoft') }}" class="btn btn-vv-sm rounded-circle-xs btn-primary btn-pill js-stoppropag"><small><< ย้อนกลับ</small></a>
                    </div>

                    <div class="col-md-8">
                        <table class="table-datatable table table-bordered table-hover table-striped"
                            data-lng-empty="ไม่มีข้อมูล..." 
                            data-lng-page-info="แสดงผลข้อมูลที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล" 
                            data-lng-filtered="(filtered from _MAX_ total entries)" 
                            data-lng-loading="กำลังโหลด..." 
                            data-lng-processing="กำลังดำเนินการ..." 
                            data-lng-search="ค้นหา..." 
                            data-lng-norecords="ไม่มีข้อมูลที่ค้นหา..." 
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
                            data-items-per-page="50" 

                            data-lng-export="<i class='fi fi-squared-dots fs--18 line-height-1'></i>" 
                            dara-export-pdf-disable-mobile="true" 
                            data-export='["csv", "pdf", "xls"]' 
                            data-options='["copy", "print"]' 
                        >
                            <thead>
                                <tr class="text-muted fs--13">
                                    <th>รายชื่อเกมที่เล่น</th>
                                    <th class="text-center">จำนวนการเล่น</th>
                                    <th class="text-center">จำนวนเงินเดิมพัน</th>
                                    <th class="text-center"><span class="text-success">ชนะ</span> / <span class="text-danger">แพ้</span></th>
                                </tr>
                            </thead>

                            <tbody id="item_list">
                                @foreach ($results as $key => $result)
                                    <tr>
                                        <td><strong class="text-dark">{{ $result['gameName'] }}</strong></td>

                                        <td class="text-center">{{ number_format($result['hands']) }}</td>

                                        <td class="text-center">{{ number_format($result['betAmount'], 2) }}</td>

                                        <td class="text-center">
                                            <strong class="@if($result['winLossAmount'] > 0) text-success @elseif($result['winLossAmount'] < 0) text-danger @endif">
                                            {{ number_format($result['winLossAmount'], 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr class="text-muted fs--13">
                                    <th>รายชื่อเกมที่เล่น</th>
                                    <th class="text-center">จำนวนการเล่น</th>
                                    <th class="text-center">จำนวนเงินเดิมพัน</th>
                                    <th class="text-center"><span class="text-success">ชนะ</span> / <span class="text-danger">แพ้</span></th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
        
			</div>
		</div>
	</div>
</div>

<style>
	a.dt-button.dropdown-item.buttons-pdf.buttons-html5 {
		display: none;
	}
    .dt-buttons.btn-group.flex-wrap {
        display: none;
    }
</style>
@endsection