/* global $*/
(function (){
    var notaPadre;
    
    $('.nota').on('click', function(event) {
        var notaPadre = event.currentTarget;
        var modal = crearModal(notaPadre, 'editar');
    });
    
    $('#agregar').on('click',function (event){
        event.preventDefault();
        var modal = crearModal(null, 'agregar');
    });
    
    function crearModal(notaPadre, solicitud){
        
        
        // Creamos la ventana modal
        var modal = document.createElement('div');
        modal.setAttribute('class', 'modal');
        document.getElementById('contenedor').appendChild(modal);
        
        //Creamos la nota dentro de la ventana modal
        var nota = document.createElement('div');
        nota.setAttribute('class', 'nota-modal');
        modal.appendChild(nota);
        
        //Creamos la parte del titulo de la ventana modal
        var titulo = document.createElement('div');
        titulo.setAttribute('class', 'titulo');
        nota.appendChild(titulo);
        
        //Creamos la etiqueta del titulo
        var ptitulo = document.createElement('p');
        ptitulo.setAttribute('contenteditable', true);
        ptitulo.textContent = 'Titulo';
        titulo.appendChild(ptitulo);
        
        //Creamos el icono de favorito
        var star = document.createElement('img');
        star.setAttribute('src',"templates/img/notas/estrellavacia.svg");
        star.setAttribute('alt','favorito');
        star.setAttribute('valor',0);
        titulo.appendChild(star);
        star.addEventListener('click',function(){
            if(star.getAttribute('src') == "templates/img/notas/estrellavacia.svg"){
                star.setAttribute('src',"templates/img/notas/estrellallena.svg");
                star.setAttribute('valor',1);
            }else{
                star.setAttribute('src',"templates/img/notas/estrellavacia.svg");
                star.setAttribute('valor',0);
            }
        });
        
        
        
        //Creamos la parte del contenido
        var contenido = document.createElement('div');
        contenido.setAttribute('class','contenido');
        nota.appendChild(contenido);
        
        //Creanis la etiqueta del contenido
        var pcontenido = document.createElement('p');
        pcontenido.setAttribute('contenteditable', true);
        pcontenido.textContent = 'Contenido';
        contenido.appendChild(pcontenido);
        
        //Creamos la parte de los archivos adjuntos
        var enlazados = document.createElement('div');
        enlazados.setAttribute('class','enlazados');
        nota.appendChild(enlazados);
        
        //Creamos la parte de las miniaturas
        var miniaturas = document.createElement('div');
        miniaturas.setAttribute('class', 'miniaturas');
        enlazados.appendChild(miniaturas);
        
        //Creamos el numero total de archivos subidos
        var total = document.createElement('p');
        total.textContent = '+0';
        enlazados.appendChild(total);
        
        if(notaPadre != null){
            ptitulo.textContent = notaPadre.getElementsByClassName('titulo')[0].getElementsByTagName('p')[0].textContent;
            pcontenido.textContent = notaPadre.getElementsByClassName('contenido')[0].getElementsByTagName('p')[0].textContent;
            star.src = notaPadre.getElementsByClassName('titulo')[0].getElementsByTagName('img')[0].src;
        }
        
        
        
        if(solicitud == 'agregar'){
            modal.addEventListener('click', function (event){
                if (event.target == modal) {
                    $.ajax({
                        url: "index.php?ruta=nota&accion=doinsert",
                        context: document.body,
                        method: "POST",
                        data: { titulo: ptitulo.textContent, contenido: pcontenido.textContent, favorito: $( ".nota-modal .titulo img" ).attr( "valor" ) },
                        success: function(data){
                           if(star.getAttribute('src') == "templates/img/notas/estrellallena.svg"){
                                nota.setAttribute('class','nota favorita');
                            }else{
                                nota.setAttribute('class','nota');
                            }
                            var firstNota = document.getElementsByClassName('nota');
                            nota.id =  data;
                            if(firstNota.length>0){
                                document.getElementById('contenedorNotas').insertBefore(nota, firstNota[0]);
                            }else{
                                document.getElementById('contenedorNotas').appendChild(nota);
                            }
                            nota.addEventListener('click', function(event) {
                                var notaPadre = event.currentTarget;
                                var modal = crearModal(notaPadre, 'editar');
                            });
                        }
                    });
                    $('.modal').remove(); 
                }
            });
            
            $('#trigger-delete').on('click',function(event) {
                    var borrar = confirm('Desea eliminar la nota');
                    if(borrar){
                        $('.modal').remove(); 
                    }
                });
        }
        
        
        
        if(solicitud == 'editar'){
            modal.addEventListener('mousedown',function (event){
                if (event.target == modal) {
                    $.ajax({
                        url: "index.php?ruta=nota&accion=doedit",
                        context: document.body,
                        method: "POST",
                        data: { idNotas: notaPadre.getAttribute('id'), titulo: ptitulo.textContent, contenido: pcontenido.textContent, favorito: $( ".nota-modal .titulo img" ).attr( "valor" ) },
                        success: function(data){
                            notaPadre.getElementsByClassName('titulo')[0].getElementsByTagName('p')[0].textContent = ptitulo.textContent;
                            notaPadre.getElementsByClassName('contenido')[0].getElementsByTagName('p')[0].textContent = pcontenido.textContent;
                            notaPadre.getElementsByClassName('titulo')[0].getElementsByTagName('img')[0].src = star.src;
                            if(star.getAttribute('src') == "templates/img/notas/estrellallena.svg"){
                                star.setAttribute('valor',1);
                                notaPadre.setAttribute('class','nota favorita');
                            }else{
                                star.setAttribute('valor',0);
                                notaPadre.setAttribute('class','nota');
                            }
                            $('.modal').remove(); 
                        }
                    });
                    
                }
            });
            
            $('#trigger-delete').on('click',function(event) {
                var idPadre = notaPadre.getAttribute('id');
                var borrar = confirm('Desea eliminar la nota '+idPadre);
                
                if(borrar){
                    $.ajax({
                        url: "index.php?ruta=nota&accion=dodelete",
                        context: document.body,
                        method: "POST",
                        data: { id: notaPadre.getAttribute('id')},
                        success: function(){
                            $('.modal').remove(); 
                            $('#'+idPadre).remove();
                        }
                    });
                }
            });
        }
        
        
        return modal;
    }
    
    
}());