<!-- payment Slip Modal -->
<div class="modal fade" id="promotionWalletList" tabindex="-1" role="dialog" aria-labelledby="promotionWalletList" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-50" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="payment-transaction-promotion-loading" class="text-center">
                    <i class="fs--30 fi fi-circle-spin fi-spin text-secondary"></i>
                </div>
                <div id="payment-transaction-promotion-loaded" style="display: none;">
                    <p class="mb-1">รายละเอียดโปรโมชั่น : <strong id="promotion-description" class="text-dark"></strong></p>
                    <p class="mb-1">จำนวนเงิน : <strong id="promotion-amount" class="text-indigo"></strong></p>
                    <p class="mb-1">เป้าหมายโปรโมชั่น : <strong id="promotion-target" class="text-dark"></strong></p>

                    <hr/>
                    
                    <div id="listingTable" class="row"></div>
                    <div class="float-end">
                        <a href="javascript:prevPage()" id="btn_prev" class="mr-2"><i class="fas fa-angle-double-left"></i></a>
                        <a href="javascript:nextPage()" id="btn_next" class="mr-2"><i class="fas fa-angle-double-right"></i></a> 
                        | <small>หน้า : <span id="page"></span></small>
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
    let current_page = 1
    let records_per_page = 20
    let res_data = null

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
        this.walletListLoading('block', 'none')
        const res = this.getTransactionPromotion(id)
        res.then(res => {
            this.walletListLoading('none', 'block')
            if(res.error === null) {
                // console.log(res.user_level)
                document.querySelector('#promotion-description').innerHTML = res.description.name
                document.querySelector('#promotion-amount').innerHTML = '+ ' + res.description.amount
                document.querySelector('#promotion-target').innerHTML = res.user_level

                res_data = res.data
                this.changePage(1)
            }else{
                document.querySelector('#is_error').innerHTML = res.error
            }
        })
    }

    function walletListLoading(display1, display2) {
        document.querySelector('#payment-transaction-promotion-loading').style.display = display1
        document.querySelector('#payment-transaction-promotion-loaded').style.display = display2
    }

    function prevPage() {
        if (current_page > 1) {
            current_page--
            changePage(current_page)
        }
    }

    function nextPage() {
        if (current_page < numPages()) {
            current_page++
            changePage(current_page)
        }
    }

    function changePage(page) {
        let btn_next = document.getElementById("btn_next")
        let btn_prev = document.getElementById("btn_prev")
        let listing_table = document.getElementById("listingTable")
        let page_span = document.getElementById("page")
    
        // Validate page
        if (page < 1) page = 1
        if (page > numPages()) page = numPages()

        listing_table.innerHTML = "";

        for (let i = (page-1) * records_per_page; i < (page * records_per_page) && i < res_data.length; i++) {
            listing_table.innerHTML += "<div class='col-3 mb-3'><div class='card'><div class='card-body text-center p-2' style='line-height: 16px;'>" + 
                                        "<p class='mb-0 text-dark'><strong><i class='far fa-user mr-2'></i>" + res_data[i].username + "</strong></p><small>" + 
                                        res_data[i].name + "</small></div></div></div>"
        }
        page_span.innerHTML = page + "/" + numPages()

        if (page == 1) {
            btn_prev.style.visibility = "hidden"
        } else {
            btn_prev.style.visibility = "visible"
        }

        if (page == numPages()) {
            btn_next.style.visibility = "hidden"
        } else {
            btn_next.style.visibility = "visible"
        }
    }

    function numPages(){
        return Math.ceil(res_data.length / records_per_page)
    }
</script>