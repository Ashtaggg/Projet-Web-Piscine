function like(element){
    var IDpost = element.id;
    var Like = parseInt(element.dataset.like);
    if(element.style.color === "red"){
        element.style.color = "white";
        Like = Like;
        $.ajax({
            url: 'accueil.php',
            type: 'POST',
            cache: false,
            data: { IDpostDislike: IDpost },
            success: function(response) {
                $('.nbrLike').text(Like);
            },
            error: function() {
                alert('Erreur lors de la requête AJAX');
            }
        });
    }
    else{
        element.style.color = "red";
        Like = Like + 1;
        $.ajax({
            url: 'accueil.php',
            type: 'POST',
            cache: false,
            data: { IDpostLike: IDpost },
            success: function(response) {
                $('.nbrLike').text(Like);
            },
            error: function() {
                alert('Erreur lors de la requête AJAX');
            }
        });
    }
}