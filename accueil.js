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


function com(element) {
    var IDpost = element.id;
    var Com = parseInt(element.dataset.com) + 1;
    var overlay3 = document.getElementById("overlay3");
    overlay3.style.display = "block";
    $.ajax({
        url: 'commentaires.php',
        type: 'POST',
        cache: false,
        data: { IDpostCom: IDpost },
        success: function(response) {
            //$('.nbrCom[data-idpost="' + IDpost + '"]').text(Com);
            $('.php').load('commentaires.php', { IDpostCom: IDpost });
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}

function com_cacher(){
    var overlay3 = document.getElementById("overlay3");
    overlay3.style.display = "none";
}


function com_poster(element){
    var IDpost = element.id;
    var contenu = document.getElementById("contenuCom");
    var contenu = contenu.value;
    var Com = parseInt(element.dataset.com) + 1;
    console.log(contenu);
    $.ajax({
        url: 'commentaires.php',
        type: 'POST',
        cache: false,
        data: { ContenuCom: contenu, IDpostCom: IDpost, NbrCom: Com},
        success: function(response) {
            $('.nbrCom[data-idpost="' + IDpost + '"]').text(Com);
            $('.php').load('commentaires.php', { IDpostCom: IDpost });
        },
        error: function() {
            alert('Erreur lors de la requête AJAX');
        }
    });
}