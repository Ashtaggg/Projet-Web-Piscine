
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