//Verification regex password - modification de son mot de passe 
  
$("#change_password_nouveauPassword").on('input', function () {

        var tab_validation = [];
    

        // check lower case
        var lowerCase = new RegExp('[a-z]');

        if ($(this).val().match(lowerCase)) {
            $(".contr-2").css('color', '#1cc88a');
            var ajout_1 = tab_validation.push('lowerCase');
        } else {
            $(".contr-2").css('color', '#212529');
            
           
        }

        // check upper case
        var upperCase = new RegExp('[A-Z]');
        if ($(this).val().match(upperCase)) {
            $(".contr-3").css('color', '#1cc88a');
            var ajout_2 = tab_validation.push('upperCase');

        } else {
            $(".contr-3").css('color', '#212529');
           

        }

        // check length words
        if ($(this).val().length >= 8 && $(this).val().length <= 15) {

            $(".contr-1").css('color', '#1cc88a');

            var ajout_3 = tab_validation.push('length');
            

        } else {
            $(".contr-1").css('color', '#212529');
           
        }


        //special caractere
        var specialChars = /[.^*$@#/§`=()<>¥€.,\\:+\-_!%¨]/g;

        if ($(this).val().search(specialChars) > -1) {

            $(".contr-4").css('color', '#1cc88a');

            var ajout_4 = tab_validation.push('specialChars');
          

        } else {
            $(".contr-4").css('color', '#212529');
           
        }


        // check number
        var number = new RegExp('[0-9]');
        if ($(this).val().match(number)) {

            $(".contr-5").css('color', '#1cc88a');
            var ajout_5 = tab_validation.push('number');
           

        } else {
            $(".contr-5").css('color', '#212529');
            
        }


        // si 5 true changer le submit disabled false


        if (tab_validation.length === 5) {

            $("#btn-change-password").prop("disabled", false);

        }else{
            $("#btn-change-password").prop("disabled", true);
        }

});



//Vérification regex password = first connect 

$("#change_password_first_connect_nouveauPassword").on('input', function () {

    var tab_validation = [];


    // check lower case
    var lowerCase = new RegExp('[a-z]');

    if ($(this).val().match(lowerCase)) {
        $(".contr-2").css('color', '#1cc88a');
        var ajout_1 = tab_validation.push('lowerCase');
    } else {
        $(".contr-2").css('color', '#212529');
        
       
    }

    // check upper case
    var upperCase = new RegExp('[A-Z]');
    if ($(this).val().match(upperCase)) {
        $(".contr-3").css('color', '#1cc88a');
        var ajout_2 = tab_validation.push('upperCase');

    } else {
        $(".contr-3").css('color', '#212529');
       

    }

    // check length words
    if ($(this).val().length >= 8 && $(this).val().length <= 15) {

        $(".contr-1").css('color', '#1cc88a');

        var ajout_3 = tab_validation.push('length');
        

    } else {
        $(".contr-1").css('color', '#212529');
       
    }


    //special caractere
    var specialChars = /[.^*$@#/§`=()<>¥€.,\\:+\-_!%¨]/g;

    if ($(this).val().search(specialChars) > -1) {

        $(".contr-4").css('color', '#1cc88a');

        var ajout_4 = tab_validation.push('specialChars');
      

    } else {
        $(".contr-4").css('color', '#212529');
       
    }


    // check number
    var number = new RegExp('[0-9]');
    if ($(this).val().match(number)) {

        $(".contr-5").css('color', '#1cc88a');
        var ajout_5 = tab_validation.push('number');
       

    } else {
        $(".contr-5").css('color', '#212529');
        
    }


    // si 5 true changer le submit disabled false


    if (tab_validation.length === 5) {

        $("#btn-change-password").prop("disabled", false);

    }else{
        $("#btn-change-password").prop("disabled", true);
    }

});


//Vérification regex password = Mot de passe oublié

$("#reset_password_nouveauPassword").on('input', function () {

    var tab_validation = [];


    // check lower case
    var lowerCase = new RegExp('[a-z]');

    if ($(this).val().match(lowerCase)) {
        $(".contr-2").css('color', '#1cc88a');
        var ajout_1 = tab_validation.push('lowerCase');
    } else {
        $(".contr-2").css('color', '#212529');
        
       
    }

    // check upper case
    var upperCase = new RegExp('[A-Z]');
    if ($(this).val().match(upperCase)) {
        $(".contr-3").css('color', '#1cc88a');
        var ajout_2 = tab_validation.push('upperCase');

    } else {
        $(".contr-3").css('color', '#212529');
       

    }

    // check length words
    if ($(this).val().length >= 8 && $(this).val().length <= 15) {

        $(".contr-1").css('color', '#1cc88a');

        var ajout_3 = tab_validation.push('length');
        

    } else {
        $(".contr-1").css('color', '#212529');
       
    }


    //special caractere
    var specialChars = /[.^*$@#/§`=()<>¥€.,\\:+\-_!%¨]/g;

    if ($(this).val().search(specialChars) > -1) {

        $(".contr-4").css('color', '#1cc88a');

        var ajout_4 = tab_validation.push('specialChars');
      

    } else {
        $(".contr-4").css('color', '#212529');
       
    }


    // check number
    var number = new RegExp('[0-9]');
    if ($(this).val().match(number)) {

        $(".contr-5").css('color', '#1cc88a');
        var ajout_5 = tab_validation.push('number');
       

    } else {
        $(".contr-5").css('color', '#212529');
        
    }


    // si 5 true changer le submit disabled false


    if (tab_validation.length === 5) {

        $("#btn-change-password").prop("disabled", false);

    }else{
        $("#btn-change-password").prop("disabled", true);
    }

});







//redirection reset password
var page =  window.location.pathname; 
        
if(page == "/validation/reset/password"){
    window.setTimeout("location=('/');" , 6000);
}
    
