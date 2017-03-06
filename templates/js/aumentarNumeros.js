(function (){
    var inicio = Math.floor((Math.random() * 100000000) + 100000);
    $('#number-change').textContent = inicio;
    
    var total = inicio;
    
    window.setInterval(function () {
        var incremento = Math.floor((Math.random() * 5) + 1);
        total = total + incremento;
        $('#number-change').text(formatearNumero(total));
    }, (Math.random() * 5000) + 1);

    
    function formatearNumero(num) {
        num += '';
        x = num.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

}());