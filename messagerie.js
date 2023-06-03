function mess(element){
    var contenu = document.getElementById("contenuMess").value;
    var envoyeur = parseInt(element.dataset.env);
    var recepteur = parseInt(element.dataset.recep);
    console.log(contenu);
    console.log(envoyeur);
    console.log(recepteur);
    $.ajax({
        url: 'messages.php',
        type: 'POST',
        cache: false,
        //data: { IDenv: envoyeur, IDrecep: recepteur, Contenu: contenu},
        success: function(response) {
            $('.prout').text(CAAC);
            $('.scroll').load('messages.php', { IDenv: envoyeur, IDrecep: recepteur});
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}