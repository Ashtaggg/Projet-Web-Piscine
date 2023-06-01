
//Celui des profs :


/*$(document).ready(function() {
    var $img = $('#carrousel img');
    var max = $img.length;
    var i = 0; // compteur
    $img.css('margin-left','0').css('display', 'none'); //on cache les images
    $img.eq(i).css('display', 'inline'); //on affiche l'image courante
    $img.eq(i+1).css('margin-left','200px').css('display', 'inline');
    $img.eq(i+2).css('margin-left','400px').css('display', 'inline');
    $img.eq(i+3).css('margin-left','600px').css('display', 'inline');
    //si on clique sur « next » ou « > »
    $('.next').click(function () { // image suivante
     i+=4; // on incrémente le compteur
     if (i < max-4) {
     i = i+4;
     $img.css('margin-left','0').css('display', 'none'); //on cache
     $img.eq(i).css('display', 'inline'); //on affiche l'image courante
     $img.eq(i+1).css('margin-left','200px').css('display', 'inline');
     $img.eq(i+2).css('margin-left','400px').css('display', 'inline');
     $img.eq(i+3).css('margin-left','600px').css('display', 'inline');
    } else {
        i = 0;
        }
        });
       //si on clique sur « prev » ou « < »
        $('.prev').click(function () { // groupe des images précédentes
        i-=4; // on décrémente le compteur
        if (i >= 0) {
        $img.css('margin-left','0').css('display', 'none'); //on cache
        $img.eq(i).css('display', 'inline'); //on affiche l'image courante
        $img.eq(i+1).css('margin-left','200px').css('display', 'inline');
        $img.eq(i+2).css('margin-left','400px').css('display', 'inline');
        $img.eq(i+3).css('margin-left','600px').css('display', 'inline');
        } else {
        i = 0;
        }
        });
       function slideImg() {
        setTimeout(function() {
        $img.eq(i).css('display', 'inline').css('transition-delay','0.25s');
        $img.eq(i + 1).css('margin-left','200px').css('display',
        'inline').css('transition-delay','0.5s');
        $img.eq(i + 2).css('margin-left','400px').css('display',
        'inline').css('transition-delay','0.75s');
        $img.eq(i + 3).css('margin-left','600px').css('display',
        'inline').css('transition-delay','1s');
        if (i < max-4) {
       i = i+4;
        } else {
       i = 0;
        }
        $img.css('margin-left','0').css('display', 'none');
        $img.eq(i).css('display', 'inline').css('transition-delay','1.25s');
        $img.eq(i + 1).css('margin-left','200px').css('display',
        'inline').css('transition-delay','1.5s');
        $img.eq(i + 2).css('margin-left','400px').css('display',
        'inline').css('transition-delay','1.75s');
        $img.eq(i + 3).css('margin-left','600px').css('display',
        'inline').css('transition-delay','2s');
       slideImg();
       }, 4000);
       }
       slideImg();
       });



*/



//Le notre :

$(document).ready(function(){
    $img = $('#carrousel img');
    indexImg = $img.length - 1;
    i = 0;
    $currentImg = $img.eq(i);
    $img.css('display', 'none');
    $currentImg.css('display', 'block');
    $minia = $('#boutons img');
    $currentMinia = $minia.eq(i);
    
    
    $('#next').click(function(){
        i++;
        if (i <= indexImg){
            $img.css('display', 'none');
            $currentImg = $img.eq(i);
            $currentImg.css('display', 'block');
            $currentMinia = $minia.eq(i);
        }
        else{
                i = 0;
                $img.css('display', 'none');
                $currentImg = $img.eq(i);
                $currentImg.css('display', 'block');
                $currentMinia = $minia.eq(i);
        }
    });


    $('#prev').click(function(){
        i--;
        if (i >= 0){
            $img.css('display', 'none');
            $currentImg = $img.eq(i);
            $currentImg.css('display', 'block');
            $currentMinia = $minia.eq(i);
        }
        else{
            i = indexImg;
            $img.css('display', 'none');
            $currentImg = $img.eq(i);
            $currentImg.css('display', 'block');
            $currentMinia = $minia.eq(i);
        }
    });

    

    $('#0').click(function(){
        i=0;
        $img.css('display', 'none');
        $currentImg = $img.eq(i);
        $currentImg.css('display', 'block');
        $currentMinia = $minia.eq(i);
    });
    $('#1').click(function(){
        i=1;
        $img.css('display', 'none');
        $currentImg = $img.eq(i);
        $currentImg.css('display', 'block');
        $currentMinia = $minia.eq(i);
    });
    
    



    function slideImg(){
        setTimeout(function(){
        if (i < indexImg){
            i++;
        }
        else {
            i = 0;
        }
        $img.css('display', 'none');
        $currentImg = $img.eq(i);
        $currentImg.css('display', 'block');
        $currentMinia = $minia.eq(i);
        slideImg();
        }, 5000);
    }
    slideImg();
});