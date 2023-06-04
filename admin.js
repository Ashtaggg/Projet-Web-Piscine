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