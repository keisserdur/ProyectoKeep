(function (){
    var slider = $('jajamoqui').nextElementSibling;
    var nodelist = slider.getElementsByTagName('img');
    
    
    window.setInterval(function () {
        slider.insertBefore(nodelist[3],nodelist[1]);
    }, 5000);
    
    
    function $(name){
        return document.getElementById(name);
    }
    
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