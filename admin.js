function ajouter(element){
    $.ajax({
        url: 'admin.php',
        type: 'POST',
        cache: false,
        success: function(response) {
            $('#AdminSection').load('ajouter.php');
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}

function supprimer(element){
    $.ajax({
        url: 'admin.php',
        type: 'POST',
        cache: false,
        success: function(response) {
            $('#AdminSection').load('supprimer.php');
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}


function validerSupprimer(element){
    var id = parseInt(element.dataset.id);
    $.ajax({
        url: 'admin.php',
        type: 'POST',
        cache: false,
        success: function(response) {
            $('#AdminSection').load('supprimer.php', { IDuser: id});
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}


function supprimer_oui(){
    var id = parseInt(element.dataset.id);
    $.ajax({
        url: 'admin.php',
        type: 'POST',
        cache: false,
        success: function(response) {
            $('#AdminSection').load('supprimer.php', { IDsuppr: id});
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}

function supprimer_non(){
    $.ajax({
        url: 'admin.php',
        type: 'POST',
        cache: false,
        success: function(response) {
            $('#AdminSection').load('supprimer.php');
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}