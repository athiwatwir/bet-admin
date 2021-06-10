function setFootballLeagueDataEdit(id, name, name_en) {
    document.getElementById('league_id').value = id
    document.getElementById('name_edit').value = name
    document.getElementById('name_en_edit').value = name_en
    document.getElementById('league_name').innerHTML = name
}