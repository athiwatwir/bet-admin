<!-- Bank Edit Modal -->
<div class="modal fade" id="addBankGroupModal" tabindex="-1" role="dialog" aria-labelledby="addBankGroupModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('/settings/bank-groups/add') }}">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มธนาคารเข้ากลุ่ม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">

                        <table class="table table-align-middle border-bottom mb-6">

                            <thead>
                                <tr class="text-muted fs--13 bg-light">
                                    <th class="w--30 hidden-lg-down text-center">
                                        #
                                    </th>
                                    <th>
                                        <span class="px-2 p-0-xs">
                                            ธนาคารที่ยังไม่มีกลุ่ม
                                        </span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                                @foreach($cbanks as $key => $cbank)
                                <tr class="text-dark form-group">
                                    <td class="hidden-lg-down text-center">
                                        <input type="checkbox" id="bank_select_{{$key}}" name="bank_select[]" value="{{ $cbank->id }}" class="form-control" style="width: 16px; height: 16px;">
                                    </td>

                                    <td style="line-height: 17px;">
                                        <label for="bank_select_{{$key}}" class="mb-0 d-flex">
                                            <strong class="mr-2">{{ $cbank->b_name_th }}</strong> [ {{ $cbank->account_name }} : {{ $cbank->account_number }} ]
                                        </label>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                        <input type="hidden" name="group_id" value="{{ $bgroup->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-sm">เพิ่ม</button>
                </div>
            </form>
        </div>
    </div>
</div>