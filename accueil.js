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
            success: function() {
                $('.nbrLike[data-idpost="' + IDpost + '"]').text(Like);
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
            success: function() {
                $('.nbrLike[data-idpost="' + IDpost + '"]').text(Like);
            },
            error: function() {
                alert('Erreur lors de la requête AJAX');
            }
        });
    }
}


function com(element){
    var IDpost = element.id;
    var Com = parseInt(element.dataset.com);
    element.style.color = "red";
    $.ajax({
        url: 'accueil.php',
        type: 'POST',
        cache: false,
        data: { IDpostCom: IDpost },
        success: function() {
            $('.nbrCom[data-idpost="' + IDpost + '"]').text(Com);
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}