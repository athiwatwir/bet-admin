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