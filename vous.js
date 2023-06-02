function modif(element){
    var IDutilisateur = element.id;
    var Like = parseInt(element.dataset.like);

    $.ajax({
        url: 'vous.php',
        type: 'POST',
        cache: false,
        data: { IDpostDislike: IDpost },
        success: function() {
            $('.nbrLike[data-idpost="' + IDpost + '"]').text(Like);
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}
