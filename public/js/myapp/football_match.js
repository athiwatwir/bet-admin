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


function setDataEditFootballMatch(key, id, home_id, away_id, datetime) {
    let home_logo = document.getElementById('home_logo_'+key).alt
    let away_logo = document.getElementById('away_logo_'+key).alt
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