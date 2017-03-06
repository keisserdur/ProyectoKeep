(function (){
    /* Menu de la landing page */
    $('.alternative-menu').on('click',function (){
        // $('nav').toggle('visible');
        if( $('.alternative-menu').attr('src') == 'templates/img/menu.svg'){
            $('.alternative-menu').attr('src', 'templates/img/back.svg');
            $('nav').addClass('visible');
        }else{
            $('.alternative-menu').attr('src', 'templates/img/menu.svg');  
            $('nav').removeClass('visible');
        }
        });
        
    /* Menu de las notas */
    
    if( $( window ).width() < 450 ){
        cerrarMenuNotas();
    }
        
    $('#trigger-menu').on('click', function (){
        if ($('#menuLateral').attr('class') == 'trigger-open-menu'){
            cerrarMenuNotas();
        }else{
            abrirMenuNotas();
        }
    });
    
    function cerrarMenuNotas(){
        $('#menuLateral').removeClass('trigger-open-menu');
        $('#contenedorNotas').removeClass('trigger-open-menu-notes');
        
        $('#menuLateral').addClass('trigger-close-menu');
        $('#contenedorNotas').addClass('trigger-close-menu-notes');
    }
    
    function abrirMenuNotas(){
        $('#menuLateral').removeClass('trigger-close-menu');
        $('#contenedorNotas').removeClass('trigger-close-menu-notes');
        
        $('#menuLateral').addClass('trigger-open-menu');
        $('#contenedorNotas').addClass('trigger-open-menu-notes');
    }
}());