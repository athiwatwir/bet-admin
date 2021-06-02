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
    document.getElementById('wallet_game_decrease').innerHTML = game
    document.getElementById('username_decrease').innerHTML = username
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

function setImagePaymentTransactionSlip(url) {
    document.getElementById("slip_img").src = '/slip/' + url
}

// Football League

function setFootballLeagueDataEdit(id, name, name_en) {
    document.getElementById('league_id').value = id
    document.getElementById('name_edit').value = name
    document.getElementById('name_en_edit').value = name_en
    document.getElementById('league_name').innerHTML = name
}

function setFootballTeamDataEdit(id, league_id, team_name, team_en, code, logo) {
    document.getElementById('team_id').value = id
    document.getElementById('league_edit').value = league_id
    document.getElementById('name_edit').value = team_name
    document.getElementById('name_en_edit').value = team_en
    document.getElementById('code_edit').value = code
    document.getElementById("logo_team").src = '/logoteams/' + logo
    document.getElementById('edit_team_name').innerHTML = team_name
}

function validateAndUploadTeamLogo() {
    let file = document.getElementById('logo');
    isValidateFile(file, 'logo_alert', 'in-validated', 'is-validated')
}

function validateAndUploadTeamLogoEdit() {
    let file = document.getElementById('logo_edit');
    isValidateFile(file, 'logo_alert_edit', 'in-validated_edit', 'is-validated_edit')
}

function isValidateFile(file, logo_alert, inValidate, isValidate) {
    const acceptedImageTypes = ['image/gif', 'image/png'];
    const fixFileSize = 1024

    let checkType = file && acceptedImageTypes.includes(file.files[0].type)
    let checkSize = Math.round(file.files[0].size / fixFileSize) <= fixFileSize ? true : false

    if(!checkType) {
        document.getElementById(logo_alert).innerHTML = 'รูปแบบของไฟล์ไม่ถูกต้อง'
        document.getElementById(inValidate).style.display = "block";
        document.getElementById(isValidate).style.display = "none";
    }

    if(!checkSize) {
        document.getElementById(logo_alert).innerHTML = 'ขนาดของไฟล์ใหญ่เกินไป'
        document.getElementById(inValidate).style.display = "block";
        document.getElementById(isValidate).style.display = "none";
    }

    if(checkType && checkSize) {
        document.getElementById(logo_alert).innerHTML = ''
        document.getElementById(inValidate).style.display = "none";
        document.getElementById(isValidate).style.display = "block";
    }
}

// set logo team when create and edit match
    // create
    document.querySelector("#home_team").addEventListener('change', function(e) {
        let logo = getLogoFromHomeAwayTeam(e.target.value)
        document.getElementById('home_team_logo').src = '/logoteams/' + logo
    })

    document.querySelector("#away_team").addEventListener('change', function(e) {
        let logo = getLogoFromHomeAwayTeam(e.target.value)
        document.getElementById('away_team_logo').src = '/logoteams/' + logo
    })

    // edit
    document.querySelector("#home_team_edit").addEventListener('change', function(e) {
        let logo = getLogoFromHomeAwayTeam(e.target.value)
        document.getElementById('home_team_logo_edit').src = '/logoteams/' + logo
    })
    document.querySelector("#away_team_edit").addEventListener('change', function(e) {
        let logo = getLogoFromHomeAwayTeam(e.target.value)
        document.getElementById('away_team_logo_edit').src = '/logoteams/' + logo
    })

    // global func
    function getLogoFromHomeAwayTeam(data) {
        let logo = data.split("!")
        return logo[1]
    }
// end

function scoreUpdate(key) {
    let home_input = parseInt(document.getElementById('home_score_'+key).value)
    let away_input = parseInt(document.getElementById('away_score_'+key).value)

    if(Number.isInteger(home_input) && Number.isInteger(away_input)){
        document.getElementById('match_action_'+key).style.display = "none"
        document.getElementById('score_action_'+key).style.display = "block"
    }else{
        document.getElementById('match_action_'+key).style.display = "block"
        document.getElementById('score_action_'+key).style.display = "none"
    }
}

function clearScoreMatch(key, home, away) {
    document.getElementById('home_score_'+key).value = home
    document.getElementById('away_score_'+key).value = away
    document.getElementById('match_action_'+key).style.display = "block"
    document.getElementById('score_action_'+key).style.display = "none"
}

document.querySelector('#btn-save-score').addEventListener('click', function(e) {
    let key = e.target.dataset.key
    document.getElementById('score_action_'+key).style.display = "none"
    document.getElementById('score_updated_'+key).style.display = "block"
})

function setDataEditFootballMatch(id, home_id, away_id, datetime, home_logo, away_logo) {
    let date_time = datetime.split(' ')

    document.getElementById('match_id').value = id
    document.getElementById('home_team_edit').value = home_id + '!' + home_logo
    document.getElementById('away_team_edit').value = away_id + '!' + away_logo
    document.getElementById('match_date_edit').value = date_time[0]
    document.getElementById('match_time_edit').value = date_time[1]
    document.getElementById('home_team_logo_edit').src = '/logoteams/' + home_logo
    document.getElementById('away_team_logo_edit').src = '/logoteams/' + away_logo
}

function clearDataCreateMatch() {
    document.getElementById('home_team').value = ''
    document.getElementById('away_team').value = ''
    document.getElementById('away_team_logo').src = ''
    document.getElementById('home_team_logo').src = ''
    document.getElementById('add_match_date').value = ''
    document.getElementById('add_match_time').value = ''
}

// END Football League