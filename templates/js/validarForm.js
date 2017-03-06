(function (){
    $('#form_login').on('click','input[type="submit"]', validarLogin);
    $('#form_register').on('click','input[type="submit"]',validarRegister);
    
    
    function validarLogin(e){
        var enviar = true;
        
        if(!email($('#correo'))){
            enviar = false;
            $('#correo').closest('label').find('span').text('Debe de ser un correo valido');
        }else{
            $('#correo').closest('label').find('span').text('');
        }
        
        if(!password($('#contrasenia'))){
            enviar = false;
            $('#contrasenia').closest('label').find('span').text('Debe de tener 8 caracteres, 1 mayuscula, 1 minuscula y un numero');
        }else{
            $('#contrasenia').closest('label').find('span').text('');
        }
        
        if(!enviar){
            e.preventDefault();
        }
    }
    
    function validarRegister (e){
        var enviar = true;
        
        if(!email($('#correo'))){
            enviar = false;
            $('#correo').closest('label').find('span').text('Debe de ser un correo valido');
        }else{
            $('#correo').closest('label').find('span').text('');
        }
        
        if(!password($('#contrasenia'))){
            enviar = false;
            $('#contrasenia').closest('label').find('span').text('Debe de tener 8 caracteres, 1 mayuscula, 1 minuscula y un numero');
        }else{
            $('#contrasenia').closest('label').find('span').text('');
        }
        
        if(!camposIguales($('#contrasenia'),$('#contrasenia2'))){
            enviar = false;
            $('#contrasenia2').closest('label').find('span').text('Ambas contraseñas tienen que ser iguales');
        }else{
            $('#contrasenia2').closest('label').find('span').text('');
        }
        
        if(!enviar){
            e.preventDefault();
        }
    }
    
    function camposIguales(campo1, campo2){
        if(campo1.val().localeCompare(campo2.val())==0){
            return true;
        }else{
            return false;
        }
    }
    
    function email(campo){
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        
        return regex.test(campo.val());
    }
    
    function password(campo){
        // Necesita tener 8 caracteres minimo, 1 mayuscula, 1 minuscula y un numero
        regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        
        return regex.test(campo.val());
    }
    
}());