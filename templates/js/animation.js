(function (){   
    $(window).scroll(function(){   
        
        var distanciaEquipo=$("#keisser").position();
        var distanciaUtilidades=$(".efecto").position();
        var distanciaNumeros=$(".number").position();

        var altoEquipo=distanciaEquipo.top;
        var altoUtilidades=distanciaUtilidades.top;
        var altoNumeros=distanciaNumeros.top;
        
        if ($(window).scrollTop() >= altoEquipo - $('#keisser').height()){
            $('#keisser').addClass('showLeft');
        }
        if ($(window).scrollTop() >= altoEquipo - $('#ThRAShGO').height()){
            $('#ThRAShGO').addClass('showLeft');
        }
        
        if ($(window).scrollTop() >= altoUtilidades - $('.efecto').height()/2){
            $('.efecto').addClass('showUp');
        }
        
        if ($(window).scrollTop() >= altoNumeros - $('.number').height()){
            $('.number').addClass('expand');
        }
    });
    
}());