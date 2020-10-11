/**
 * Ajouté un message
 */
$("#form_message").on("submit" , function(e){
    e.preventDefault();

    $data = $(this).serialize(); 

    if($("#message-to-send").val() != ""){
       
/*
        const u = new URL('http://localhost:3000');
        u.searchParams.append('topic', 'http://localhost/user/message-new/');
       const evtSource = new EventSource(u);
       evtSource .onmessage = e =>{
         console.log(e + "ok"); 
       }
      
*/

        $.post({
            url:"/user/message-new/", 
            data: $data,
            success:function(response){
                console.log(response);
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

