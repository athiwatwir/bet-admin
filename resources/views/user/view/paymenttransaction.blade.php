<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-align-middle border-bottom mb-6">

                        <thead>
                            <tr class="text-muted fs--13 bg-light">
                                <th>
                                    <span class="px-2 p-0-xs">
                                        ประเภทรายการ
                                    </span>
                                </th>
                                <th class="hidden-lg-down text-center">วัน-เวลา</th>
                                <th class="hidden-lg-down text-center">ไปยังบัญชี</th>
                                <th class="hidden-lg-down text-center">จำนวนเงิน</th>
                                <th class="hidden-lg-down text-center">สลิป</th>
                                <th class="hidden-lg-down text-center">สถานะ</th>
                            </tr>
                        </thead>

                        <tbody id="item_list">

                            @foreach ($transaction as $key => $trans)

                                <tr id="message_id_{{ $key }}" class="text-dark 
                                                                @if($trans->type == 'ฝาก') bg-deposit 
                                                                @elseif($trans->type == 'ถอน') bg-withdraw  
                                                                @elseif($trans->type == 'ย้าย') bg-transfer
                                                                @elseif($trans->type == 'เพิ่ม') bg-increase
                                                                @elseif($trans->type == 'ลด') bg-decrease
                                                                @endif ">

                                    <td style="line-height: 17px;">
                                        <p class="mb-0">
                                            <span class="badge 
                                                        @if($trans->type == 'ฝาก') badge-success 
                                                        @elseif($trans->type == 'ถอน') badge-danger 
                                                        @elseif($trans->type == 'ย้าย') badge-warning
                                                        @elseif($trans->type == 'เพิ่ม') badge-primary
                                                        @elseif($trans->type == 'ลด') badge-secondary
                                                        @endif 
                                                        font-weight-normal fs--16"
                                            >{{ $trans->type }}
                                            </span>
                                        </p>
                                        @if(isset($trans->description))
                                            <small><small><span class="text-danger">**</span> {{ $trans->description }}</small></small>
                                        @endif

                                        <!-- MOBILE ONLY -->
                                        <div class="fs--13 d-block d-xl-none">
                                            <span class="d-block text-muted"></span>
                                            <span class="d-block text-muted"></span>
                                        </div>
                                        <!-- /MOBILE ONLY -->
                                    </td>

                                    <td class="hidden-lg-down text-center" style="line-height: 17px;">
                                        {{ date('d-m-Y', strtotime($trans->action_date)) }}<br/>
                                        <small>{{ date('H:i:s', strtotime($trans->action_date)) }}</small>
                                    </td>

                                    <td class="hidden-lg-down text-center" style="line-height: 16px;">
                                        @if(isset($trans->by_admin))
                                            <small>
                                                <strong>ผู้ดูแลระบบ : {{ $trans->by_admin }}</strong>
                                            </small><br/>
                                            <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                            <small>
                                                @if($trans->to_default == 'Y')
                                                    กระเป๋าหลัก
                                                @else
                                                    กระเป๋าเกม : {{ $trans->to_game }}
                                                @endif
                                            </small>
                                        @else
                                            @if($trans->type == 'ฝาก')
                                                {{ $trans->cbank_name }}<br/>
                                                <small>{{ $trans->account_name }}</small><br/>
                                                <small>{{ $trans->account_number }}</small>
                                            @elseif($trans->type == 'ถอน')
                                                {{ $trans->ubank_name }}<br/>
                                                <small>{{ $trans->bank_account_name }}</small><br/>
                                                <small>{{ $trans->bank_account_number }}</small>
                                            @elseif($trans->type == 'ย้าย')
                                                <small>
                                                    @if($trans->from_default == 'Y')
                                                        กระเป๋าหลัก
                                                    @else
                                                        กระเป๋าเกม : {{ $trans->from_game }}
                                                    @endif
                                                </small><br/>
                                                <small><i class="fi fi-arrow-down-full text-primary"></i></small></br>
                                                <small>
                                                    @if($trans->to_default == 'Y')
                                                        กระเป๋าหลัก
                                                    @else
                                                        กระเป๋าเกม : {{ $trans->to_game }}
                                                    @endif
                                                </small>
                                            @endif
                                        @endif
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        <strong class=" @if($trans->type == 'ฝาก') text-success 
                                                    @elseif($trans->type == 'ถอน') text-danger 
                                                    @elseif($trans->type == 'ย้าย') text-warning
                                                    @elseif($trans->type == 'เพิ่ม') text-primary
                                                    @elseif($trans->type == 'ลด') text-secondary
                                                    @endif "
                                        >{{ number_format($trans->amount) }}
                                        </strong>
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if(isset($trans->slip))
                                            <a href="#!" title="ดูสลิปโอนเงิน" 
                                                data-toggle="modal" data-target="#paymentSlipModal" onClick="setImagePaymentTransactionSlip('{{ $trans->slip }}')">
                                                <i class="fi fi-image"></i>
                                            </a>
                                        @endif
                                    </td>

                                    <td class="hidden-lg-down text-center">
                                        @if($trans->status == 'CO') 
                                            <small class="badge badge-success font-weight-normal">ยืนยันแล้ว</small>
                                        @elseif($trans->status == 'VO')
                                            <small class="badge badge-danger font-weight-normal">ปฏิเสธแล้ว</small>
                                        @else
                                            <small class="badge badge-secondary font-weight-normal">รอยืนยัน</small>
                                        @endif
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

                                <li class="{{ $transaction->onFirstPage() ? 'page-item btn-pill disabled' : 'page-item btn-pill' }}">
                                    <a class="page-link" href="{{ $transaction->previousPageUrl() }}" tabindex="-1" aria-disabled="true">ก่อนหน้า</a>
                                </li>
                                
                                <li class="page-item active" aria-current="page">
                                    {{ $transaction->links() }}
                                </li>
                                
                                <li class="{{ $transaction->currentPage() == $transaction->lastPage() ? 'page-item disabled' : 'page-item' }}">
                                    <a class="page-link" href="{{ $transaction->nextPageUrl() }}">ถัดไป</a>
                                </li>

                            </ul>

                            <div class="justify-content-end justify-content-center justify-content-md-end text-right">
                                <small>หน้า : {{ $transaction->currentPage() }} / {{ $transaction->lastPage() }}</small>
                            </div>
                        </nav>
                        <!-- pagination -->

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>