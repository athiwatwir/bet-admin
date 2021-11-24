function setDataEditModal(id, bID, aName, aNumber, bgID) {
    document.getElementById('edit_id').value = id
    document.getElementById('edit_bank').value = bID
    document.getElementById('edit_account_name').value = aName
    document.getElementById('edit_account_number').value = aNumber
    document.getElementById('edit_bank_group').value = bgID
}

function setDataAdminEditModal(id, username, name, phone, line) {
    document.getElementById('edit_id').value = id
    document.getElementById('admin_username').innerHTML = username
    document.getElementById('edit_username').value = username
    document.getElementById('edit_name').value = name
    document.getElementById('edit_phone').value = phone
    document.getElementById('edit_line').value = line
}

function setAdminPasswordModal(id) {
    let result           = [];
    let characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let charactersLength = characters.length;
    for ( let i = 0; i < 10; i++ ) {
      result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
    }

    document.getElementById('new_password').value = result.join('')
    document.getElementById('admin_id').value = id
}

function copyNewPassword() {
    let copyText = document.getElementById("new_password");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");

    // console.log(copyText.value)
}

function setBankDataEdit(id, name, name_en) {
    document.getElementById('edit_bank_name').value = name
    document.getElementById('edit_bank_name_en').value = name_en
    document.getElementById('edit_bank_id').value = id
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

// Profile Wallet Edit
function setDataIncreaseWalletAmount(id, amount, game, username) {
    document.getElementById('wallet_id').value = id
    document.getElementById('is_wallet').value = amount
    document.getElementById('wallet_game').innerHTML = game
    document.getElementById('username').innerHTML = username
    document.getElementById('wallet_amount_notice').innerHTML = 'จำนวนเงินเดิม : ' + formatNumber(amount)
}

function setDataDecreaseWalletAmount(id, amount, game, username) {
    document.getElementById('wallet_id_decrease').value = id
    document.getElementById('min_wallet').value = amount
    document.getElementById('wallet_game_decrease').innerHTML = game
    document.getElementById('username_decrease').innerHTML = username
    document.getElementById('wallet_amount_notice_min').innerHTML = 'จำนวนเงินเดิม : ' + formatNumber(amount)
}

function chackWalletIncreaseAmountValue() {
    let min = document.getElementById('is_wallet').value
    let value = document.getElementById('wallet_amount').value
    let increase = parseInt(min) + parseInt(value)
    document.getElementById('wallet_amount_notice').innerHTML = "จำนวนเงินคงเหลือ (" + formatNumber(min) + " + " + formatNumber(value) + ") = " + formatNumber(increase)
}

function chackWalletDecreaseAmountValue() {
    let min = document.getElementById('min_wallet').value
    let value = document.getElementById('wallet_amount_decrease').value
    let decrease = min - value
    if(decrease < 0) {
        document.getElementById('wallet_amount_decrease').value = min
        document.getElementById('wallet_amount_notice_min').innerHTML = "ลดจำนวนเงินได้สูงสุดคือ " + formatNumber(min)
    }else{
        document.getElementById('wallet_amount_notice_min').innerHTML = "จำนวนเงินคงเหลือ (" + formatNumber(min) + " - " + formatNumber(value) + ") = " + formatNumber(decrease)
    }
}

function clearWalletAmount() {
    document.getElementById('wallet_amount').value = ''
    document.getElementById('wallet_amount_decrease').value = ''
}

// END Profile Wallet Edit

function setGameGroupDataEdit(id, name) {
    document.getElementById('edit_game_group_name').value = name
    document.getElementById('edit_game_group_id').value = id
    document.getElementById('game_group_edit').innerHTML = name
}

function setGameDataEdit(id, name, url, token, logo) {
    document.getElementById('is_edit_game_name').innerHTML = name
    document.getElementById('edit_game_id').value = id
    document.getElementById('edit_game_name').value = name
    document.getElementById('edit_game_url').value = url
    document.getElementById('edit_game_token').value = token
    document.getElementById("logo_img").src = '/logogames/' + logo
}

function setGameDataTransfer(id) {
    document.getElementById('game_transfer_id').value = id
}

function setGameGroupDataActive(id, name, game_count) {
    document.getElementById('active_game_group_name').innerHTML = name
    document.getElementById('active_game_group_count').innerHTML = game_count
    document.getElementById('active_game_group_id').value = id
}


// User Profile
function editProfile() {
    document.getElementById("name").disabled = false
    document.getElementById("phone").disabled = false
    document.getElementById("line").disabled = false
    document.querySelector('#level').disabled = false
    document.querySelector('#bank_group').disabled = false
    document.getElementById("is-edit-profile-btn").style.display = "block";
}

function cancelEditProfile() {
    document.getElementById("name").disabled = true
    document.getElementById("phone").disabled = true
    document.getElementById("line").disabled = true
    document.querySelector('#level').disabled = true
    document.querySelector('#bank_group').disabled = true
    document.getElementById("is-edit-profile-btn").style.display = "none";
}

function editProfileBank() {
    document.getElementById("banks").disabled = false
    document.getElementById("account_name").disabled = false
    document.getElementById("account_number").disabled = false
    document.getElementById("is-edit-bank-btn").style.display = "block";
}

function cancelEditBank() {
    document.getElementById("banks").disabled = true
    document.getElementById("account_name").disabled = true
    document.getElementById("account_number").disabled = true
    document.getElementById("is-edit-bank-btn").style.display = "none";
}
// END User Profile

// Admin Profile
function editProfileAdmin() {
    document.getElementById("name_admin").disabled = false
    document.getElementById("phone_admin").disabled = false
    document.getElementById("line_admin").disabled = false
    document.getElementById("is-edit-admin-profile-btn").style.display = "block";
}

function cancelEditAdminProfile() {
    document.getElementById("name_admin").disabled = true
    document.getElementById("phone_admin").disabled = true
    document.getElementById("line_admin").disabled = true
    document.getElementById("is-edit-admin-profile-btn").style.display = "none";
}
// END Admin Profile


function setImagePaymentTransactionSlip(url, bank_name, bank_name_en, account_name, account_number, date, time) {
    let newDate = date.split("-")
    document.querySelector('#bank_name').innerHTML = bank_name + ' (' + bank_name_en + ')'
    document.querySelector('#bank_account_name').innerHTML = account_name
    document.querySelector('#bank_account_number').innerHTML = account_number + ' <small>(4 ตัวท้าย)</small>'
    document.querySelector('#bank_payment_date').innerHTML = newDate[2] + '/' + newDate[1] + '/' + newDate[0]
    document.querySelector('#bank_payment_time').innerHTML = time
    document.getElementById("slip_img").src = '/slips/' + url
}

function setDataUserLevel(id, name, deposit, withdraw, transfer, isdefault) {
    document.querySelector('#userlevel_id').value = id
    document.querySelector('#levelname_edit').value = name
    document.querySelector('#modal-header-user-level').innerHTML = name
    document.querySelector('#limit_deposit_edit').value = deposit
    document.querySelector('#limit_withdraw_edit').value = withdraw
    document.querySelector('#limit_transfer_edit').value = transfer
    if(isdefault === 'Y') {
        document.querySelector('#is_default_edit').style.display = 'none' 
        document.querySelector('#is-user-level-default-label').innerHTML = '<strong class="text-danger">เป็นค่าเริ่มต้น</strong>'
    }else if(isdefault === 'N') {
        document.querySelector('#is_default_edit').style.display = 'inherit'
        document.querySelector('#is-user-level-default-label').innerHTML = 'ตั้งเป็นค่าเริ่มต้น'
    }
}

function setBankGroupDataEdit(id, name, isactive, isdefault) {
    document.querySelector('#bankgroup_id').value = id
    document.querySelector('#bankgroup_name').value = name
    if(isdefault === 'N') {
        document.querySelector("#is-not-active").style.display = "flex";
        document.querySelector("#is-not-default").style.display = "flex";
        document.querySelector('#bankgroup_isactive').checked = isactive === 'Y' ? true : false
    }else if(isdefault === 'Y'){
        document.querySelector("#is-not-active").style.display = "none";
        document.querySelector("#is-not-default").style.display = "none";
    }
}

function getDataToTransfer(id) {
    document.querySelector('#transfer_id').value = id
}