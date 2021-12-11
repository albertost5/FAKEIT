// VALIDACION EDIT USER
    function validateText(text) {
        var regex = /^[a-zA-Z ]+$/;
        return regex.test(text); //devuelve TRUE o FALSE
    }

    // ID: fname - surname - country - city_input - twitter - facebook - twitch


    // VALIDAR NOMBRE
    $("#fname").blur(function () {
        var name = $("#fname").val();
        
        if (name == "") {
            alert("El campo nombre no puede estar vacío");
            $("#fname").focus();
        }else if(!validateText(name)){
            alert("El campo nombre no puede contener números.");
            $("#fname").focus();
        }else if(name.length < 3 || name.length > 12 ){
            alert("Nombre: mín. 3, máx. 12 carácteres.");
            $("#fname").focus();
        }
    });

    // VALIDAR APELLIDO
    $("#surname").blur(function () {
        var surname = $("#surname").val();
        
        if (surname == "") {
            alert("El campo apellido no puede estar vacío");
            $("#surname").focus();
        }else if(!validateText(surname)){
            alert("El campo apellido no puede contener números.");
            $("#surname").focus();
        }else if(surname.length < 3 || surname.length > 12 ){
            alert("Apellido: mín. 3, máx. 12 carácteres.");
            $("#surname").focus();
        }
    });

    // VALIDAR CIUDAD
    $("#city_input").blur(function () {
        var city = $("#city_input").val();
        
        if (city == "") {
            alert("El campo ciudad no puede estar vacío.");
            $("#city_input").focus();
        }else if(!validateText(city)){
            alert("El campo ciudad no puede contener números.");
            $("#city_input").focus();
        }else if(city.length < 3 || city.length > 18 ){
            alert("Ciudad: mín. 3, máx. 12 carácteres.");
            $("#city_input").focus();
        }
    });

    // VALIDAR TWITTER  
    $("#twitter").blur(function () {
        var twitter = $("#twitter").val();
        
       if(twitter.length > 18 ){
            alert("Twitter: máx. 12 carácteres.");
            $("#twitter").focus();
        }
    });

    // VALIDAR FACEBOOK  
    $("#facebook").blur(function () {
        var facebook = $("#facebook").val();
        
        if(facebook.length > 18 ){
            alert("facebook: máx. 12 carácteres.");
            $("#facebook").focus();
        }
    });

    // VALIDAR TWITCH  
    $("#twitch").blur(function () {
        var twitch = $("#twitch").val();
        
        if(twitch.length > 18 ){
            alert("twitch: máx. 12 carácteres.");
            $("#twitch").focus();
        }
    });




// COOKIES
/* ésto comprueba la localStorage si ya tiene la variable guardada */
    function compruebaAceptaCookies() {
        if(localStorage.aceptaCookies == 'true'){
            cookiesbox.style.display = 'none';
        }
    }

    /* aquí guardamos la variable de que se ha
    aceptado el uso de cookies así no mostraremos
    el mensaje de nuevo */
    function aceptarCookies() {
        localStorage.aceptaCookies = 'true';
        cookiesbox.style.display = 'none';
    }

    /* ésto se ejecuta cuando la web está cargada */
    $(document).ready(function () {
        compruebaAceptaCookies();
    });

    $("a#loginB").click(function(){
        if(localStorage.aceptaCookies != 'true'){
            alert("Ha de aceptar nuestras cookies antes de continuar.");
            return false;
        }
    });

    $("a#loginA").click(function(){
        if(localStorage.aceptaCookies != 'true'){
            alert("Ha de aceptar nuestras cookies antes de continuar.");
            return false;
        }
    });


    


