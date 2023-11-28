$(document).ready(function(){
    $('#placeorder').on('change', function (e) {
        var a = this.value;
        console.log(a);
        if(a!="")
        location.href = 'http://countrywideprocess.com/countrywide/'+a;
    });
});