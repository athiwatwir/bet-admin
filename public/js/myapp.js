function setDataEditModal(id, bID, aName, aNumber, isActive) {
    document.getElementById('edit_id').value = id
    document.getElementById('edit_bank').value = bID
    document.getElementById('edit_account_name').value = aName
    document.getElementById('edit_account_number').value = aNumber
    document.getElementById('edit_active').checked = isActive === 'Y' ? true : false
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

function setDataEditWalletAmount(id, amount, game) {
    document.getElementById('wallet_id').value = id
    document.getElementById('wallet_amount').value = amount
    document.getElementById('wallet_game').innerHTML = game
}