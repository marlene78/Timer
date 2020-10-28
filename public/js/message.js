/**
 * Send message
*/
$("#form-to-send-message").on("submit" , function(e){
    e.preventDefault();

    let data = $(this).serialize(); 

    if($("#message").val() != ""){

        $("#loader").removeClass("cacher");
        $("#send").prop("disabled" , true);
        $("#send-message-annule").prop("disabled" , true);
        $("#message").prop("disabled" , true);
       
        //Envoi du message
        $.post({
            url:"/user/message/new", 
            data: data,
            success:function(response){
                $("#loader").addClass("cacher");
                $(".val_message").html('<span class="text-success"><i class="fas fa-thumbs-up"></i> '+response+'</span>'); 
                
                setTimeout(() => {
                    $("#sendMessage").modal("hide"); 
                    $(".val_message").html("");
                    $("#message").val(""); 
                    $("#send").prop("disabled" , false);
                    $("#send-message-annule").prop("disabled" , false);
                }, 4000);
            },
            error:function(erreur){ 
                $("#loader").addClass("cacher");   
                $(".val_message").html('<span class="text-danger"><i class="far fa-frown"></i>'+ erreur+'</span>'); 
                $("#send").prop("disabled" , false);
                $("#send-message-annule").prop("disabled" , false);
                $("#message").prop("disabled" , false); 

            }
        });


    }else{
        $("#loader").addClass("cacher");
        $(".val_message").html('<span class="text-danger"><i class="far fa-frown"></i> Veuillez remplir ce champ</span>');
        $("#message").prop("disabled" , false); 
    }

});  


//Reset form
 $("#send-message-annule").on("click" , () =>{
    $(".val_message").html("");
    $("#message").val(""); 
    $("#send").prop("disabled" , false);
    $("#send-message-annule").prop("disabled" , false);
    $("#message").prop("disabled" , false); 
 })













