function rech_mess(element){
    var input = $('#rech-message');
    var contenu = input.val();
    $.ajax({
        url: 'rech_messages.php',
        type: 'POST',
        cache: false,
        //data: { IDenv: envoyeur, IDrecep: recepteur, Contenu: contenu},
        success: function(response) {
            input.val('');
            $('#scroll-messagerie').load('rech_messages.php', { Contenu: contenu});
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}


function mess(element){
    var input = $('#contenuMess');
    var contenu = input.val();
    var envoyeur = parseInt(element.dataset.env);
    var recepteur = parseInt(element.dataset.recep);
    var utilisateur = parseInt(element.dataset.utilisateur);
    console.log(contenu);
    console.log(envoyeur);
    console.log(recepteur);
    console.log(utilisateur);
    $.ajax({
        url: 'messages.php',
        type: 'POST',
        cache: false,
        //data: { IDenv: envoyeur, IDrecep: recepteur, Contenu: contenu},
        success: function(response) {
            input.val('');
            $('#scroll_msg').load('messages.php', { IDenv: envoyeur, IDrecep: recepteur, Contenu: contenu, IDutilisateur: utilisateur});
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}