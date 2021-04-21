function setDataEditModal(id, bName, aName, aNumber, isActive) {
    document.getElementById('edit_id').value = id
    document.getElementById('edit_bank_name').value = bName
    document.getElementById('edit_account_name').value = aName
    document.getElementById('edit_account_number').value = aNumber
    document.getElementById('edit_active').checked = isActive === 'Y' ? true : false
}