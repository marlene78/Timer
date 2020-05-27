let transmettre = $("#item_transmettre").val(); 


var parsedUrl = window.location.pathname.split('/'); 

let id =  parsedUrl[4]; 


//Modal transmission
if(transmettre == "Non"){
    $("#My_modal_transmettre").modal("show"); 

    $("#envois_reclmation_gestionnaire").on('click' , function(){
        
        //loader     
        $('<div id="loader"></div>').appendTo('#My_modal_transmettre #message');
        
        //mise à jour réclamation
        $.post({
            url:"/set/transmission", 
            data:"id="+id, 
            success:function(response)
            {
               $("#loader").remove(); 
                $("#My_modal_transmettre #message").text(response);  
             
                $("#My_modal_transmettre button").prop("disabled" , true); 
              
                window.setTimeout("location=('/');" , 3000);
                 
            },
            error:function(error)
            {
                console.log(error); 
            }

        })

    })







}


//Modal Demande d'info 

if($("#item_demande_info").val() == 1)
{
    $('#modal_demande_information').modal('show')
}

//Modal transfère
$("#admin_transfere").on("click" , function(){$("#modal_transfere").modal("show"); })

$("#tranfere").on("click" , function(){

    $("#modal_transfere").modal("hide"); 
    $("#modal_destinataire").modal("show"); 
})

//Modal destinataire

$("#add_destinataire").on("click" , function(){
    $("#modal_destinataire").modal("hide"); 
    $("#modal_add_destinataire").modal("show"); 
})

$("#form_add_destinataire").on("submit" , function(e){
    e.preventDefault(); 
    $donnee = $(this).serialize(); 

    $("#modal-body").append("<p id='attend'>Veuillez patienter ..<p>"); 
 
    $("#button_annuler").prop("disabled" , true); 
    $.ajax({
        method:"post", 
        url:"/user/destinataire/new/"+$("#id_reclamation").val(), 
        data:$donnee,
        success:function(response)
        {
            $("#attend").text(response);

    
            setTimeout(function(){
                $("#modal_add_destinataire").modal("hide");
                window.location="/user/reclamation/courrier/"+$("#id_reclamation").val();

            },3000);


        },
        error:function()
        {
            $("#attend").text("Une erreur s'est produite , veuillez essayer ultérieurement.");
        }
    })
})

