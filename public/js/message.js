/**
 * Ajouté un message
*/
$("#form_message").on("submit" , function(e){
    e.preventDefault();

    let data = $(this).serialize(); 

    if($("#message-to-send").val() != ""){
       
        //Envoi du message
        $.post({
            url:"/user/message-new/", 
            data: data,
            success:function(response){

                $("#message-to-send").val(""); 
                $(".val_message").html('<i class="fas fa-thumbs-up"></i> '+response+''); 
                setTimeout(() => {
                    $(".val_message").html(""); 
                }, 2000);
            },
            error:function(erreur){
               
                $(".erreur_message").html('<i class="far fa-frown"></i>'+erreur+''); 
                setTimeout(() => {
                    $(".erreur_message").html(""); 
                }, 2000);
            }
        });


    }else{
    
        $(".erreur_message").html('<i class="far fa-frown"></i> Veuillez rempli ce champ'); 
        setTimeout(() => {
            $(".erreur_message").html(""); 
        }, 2000);
    }

});  


 









/**
 * Souscription à un hub
*/
const u = new URL('/.well-known/mercure'); //url mercure
u.searchParams.append('topic', '/user/ping'); //topic url à écouter
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

