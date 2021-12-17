<!-- payment Slip Modal -->
<div class="modal fade" id="promotionWalletList" tabindex="-1" role="dialog" aria-labelledby="promotionWalletList" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-40" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="payment-transaction-promotion-loading" class="text-center">
                    <i class="fs--30 fi fi-circle-spin fi-spin text-secondary"></i>
                </div>
                <div id="payment-transaction-promotion-loaded" style="display: none;">
                    <p class="mb-1">รายละเอียดโปรโมชั่น : <strong id="promotion-description" class="text-dark"></strong></p>
                    <p class="mb-1">จำนวนเงิน : <strong id="promotion-amount" class="text-indigo"></strong></p>

                    <hr/>

                    <div class="table-responsive">
                        <table id="sub_wallet_history_table" class="table table-align-middle border-bottom mb-3">
                            <thead>
                                <tr class="text-muted fs--13 bg-light">
                                    <th class="text-center">ชื่อผู้ใช้</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                </tr>
                            </thead>

                            <tbody id="item_list">

                            </tbody>

                        </table>
                    </div>
                </div>
                <div id="payment-transaction-promotion.error" class="text-center" style="display: none;">
                    <p id="is_error" class="text-danger"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function getTransactionPromotion(id) {
        const response = await fetch(window.location.origin+'/api/v3/payment-transaction-promotion/wallet-list/'+id, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })

        return response.json()
    }

    function promotionWalletList(id) {
        this.walletListLoding('block', 'none')
        const res = this.getTransactionPromotion(id)
        res.then(res => {
            this.walletListLoding('none', 'block')
            if(res.error === null) {
                // console.log(res.data)
                document.querySelector('#promotion-description').innerHTML = res.description.name
                document.querySelector('#promotion-amount').innerHTML = '+ ' + res.description.amount

                let tbodyRef = document.getElementById('sub_wallet_history_table').getElementsByTagName('tbody')[0]
    
                while (tbodyRef.childNodes.length) {
                    tbodyRef.removeChild(tbodyRef.childNodes[0]);
                }

                res.data.forEach((data, index) => {
                    // console.log(data)
                    let newRow = tbodyRef.insertRow(index)
                    newRow.insertCell(0).innerHTML = '<center>' + data.username + '</center>'
                    newRow.insertCell(1).innerHTML = '<center>' + data.name + '</center>'
                })
            }else{
                document.querySelector('#is_error').innerHTML = res.error
            }
        })
    }

    function walletListLoding(display1, display2) {
        document.querySelector('#payment-transaction-promotion-loading').style.display = display1
        document.querySelector('#payment-transaction-promotion-loaded').style.display = display2
    }
</script>