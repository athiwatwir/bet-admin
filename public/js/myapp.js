function setDataEditModal(id, bID, aName, aNumber) {
    document.getElementById('edit_id').value = id
    document.getElementById('edit_bank').value = bID
    document.getElementById('edit_account_name').value = aName
    document.getElementById('edit_account_number').value = aNumber
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

// Profile Wallet Edit
function setDataIncreaseWalletAmount(id, amount, game, username) {
    document.getElementById('wallet_id').value = id
    document.getElementById('is_wallet').value = amount
    document.getElementById('wallet_game').innerHTML = game
    document.getElementById('username').innerHTML = username
    document.getElementById('wallet_amount_notice').innerHTML = 'จำนวนเงินเดิม : ' + amount
}

function setDataDecreaseWalletAmount(id, amount, game, username) {
    document.getElementById('wallet_id_decrease').value = id
    document.getElementById('min_wallet').value = amount
    document.getElementById('wallet_game').innerHTML = game
    document.getElementById('username').innerHTML = username
    document.getElementById('wallet_amount_notice_min').innerHTML = 'จำนวนเงินเดิม : ' + amount
}

function chackWalletIncreaseAmountValue() {
    let min = document.getElementById('is_wallet').value
    let value = document.getElementById('wallet_amount').value
    let increase = parseInt(min) + parseInt(value)
    document.getElementById('wallet_amount_notice').innerHTML = "จำนวนเงินคงเหลือ (" + min + " + " + value + ") = " + increase
}

function chackWalletDecreaseAmountValue() {
    let min = document.getElementById('min_wallet').value
    let value = document.getElementById('wallet_amount_decrease').value
    let decrease = min - value
    if(decrease < 0) {
        document.getElementById('wallet_amount_decrease').value = min
        document.getElementById('wallet_amount_notice_min').innerHTML = "ลดจำนวนเงินได้สูงสุดคือ " + min
    }else{
        document.getElementById('wallet_amount_notice_min').innerHTML = "จำนวนเงินคงเหลือ (" + min + " - " + value + ") = " + decrease
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

function setGameDataEdit(id, name, url, token, group_id) {
    document.getElementById('is_edit_game_name').innerHTML = name
    document.getElementById('edit_game_id').value = id
    document.getElementById('edit_game_name').value = name
    document.getElementById('edit_game_url').value = url
    document.getElementById('edit_game_token').value = token
    document.getElementById('edit_game_group_id').value = group_id
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
    document.getElementById("is-edit-profile-btn").style.display = "block";
}

function cancelEditProfile() {
    document.getElementById("name").disabled = true
    document.getElementById("phone").disabled = true
    document.getElementById("line").disabled = true
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

function setImagePaymentTransactionSlip(url) {
    document.getElementById("slip_img").src = '/slip/' + url
}