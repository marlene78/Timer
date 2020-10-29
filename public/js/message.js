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


<<<<<<< HEAD
=======











<<<<<<< HEAD
/**
 * Souscription à un hub
 */
const u = new URL('http://timer-ipssi.herokuapp.com/:3000/.well-known/mercure'); //url mercure
u.searchParams.append('topic', 'http://timer-ipssi.herokuapp.com/user/ping'); //topic url à écouter
const evtSource = new EventSource(u);
evtSource .onmessage = e =>{
    
    //Message envoyé 
      /*let html =`<li class="clearfix"><div class="message-data align-right"><span class="message-data-time" ></span> &nbsp; &nbsp;<span class="message-data-name"></span> <i class="fa fa-circle" style="color:"></i></div><div class="message float-right" style="background-color:">${e.data}<span id="delete" class="delete_message" data-id="">X</span></div></li>`;
    $(".chat-history ul").append(html);
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;" class="topic">
    <div class="toast" style="position: absolute; top: 0; right: 0;">
        <div class="toast-header">
            <img src="..." class="rounded mr-2" alt="...">
            <strong class="mr-auto">Message</strong>
            <small>11 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body"></div>
    </div>
    </div>
    $("#topic .toast-body").text(e.data);
    $(".toast").toast('show');*/
    console.log(e);
   
}
window.addEventListener('beforeunload' , () =>{
    if(evtSource == null){
        evtSource.close
    }
})

=======
>>>>>>> develop
>>>>>>> master
