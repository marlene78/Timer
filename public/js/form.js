
//ANNULATION
$(".annulation").on("click" , function(){
    $("#AnnulationModal").modal("show");
})




/***********************/
/* FORMULAIRE DEMANDEUR
/**********************/
$("#form_info_demandeur").on("submit" , function(e){

    e.preventDefault();
    let erreur = true; 

   //civilité 
   if( $("#civilite").val() == ""){
       $("#erreur_civilite").text("Veuillez remseigner ce champ"); 
       erreur = false; 
    }

   //nom 
   if( $("#nom").val() == ""){
        $("#erreur_nom").text("Veuillez remseigner ce champ"); 
        erreur = false; 
    }

    //prénom
    if( $("#prenom").val() == ""){
        $("#erreur_prenom").text("Veuillez remseigner ce champ"); 
        erreur = false; 
    }


    //téléphone & adherent vide 
    if( $("#tel").val() == "" && $("#adherent").val() == ""){
        $("#erreur_tel_adherent").text("Veuillez renseigner le numéro de téléphone et/ou le numéro d'adhérent");
        $("#label_tel").css("color" , "red"); 
        $("#label_ad").css("color", "red");
        erreur = false;
    }



    //tel 
    if($("#tel").val() !="" &&  $("#tel").val().length  != 10 ){
        $("#erreur_tel").text("Veuillez saisir un numéro comportant 10 caractères");
        $("#label_tel").css("color" , "red");  
        erreur = false;
    }


    //consentement
    if($("#check_oui").is(":checked") == true && $("#email").val() == ""){
        erreur = false;
        $("#erreur_email").text("Veuillez renseigner ce champ"); 
    }


    //email
    let emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

    if($("#email").val() != "" &&  emailReg.test($("#email").val())  == false   ){
        erreur = false; 
        $("#erreur_email").text("Veuillez saisir une adresse email valide"); 

    }


    let donnees = $(this).serialize(); 
  
    //enregistrement en session
    if(erreur == true){

        //loader
        $('<div id="loader"></div>').appendTo('#erreur_tel_adherent');
        //désactiver input
        $("#form_info_demandeur input").prop("disabled" , true); 
        $("#form_info_demandeur select").prop("disabled" , true);
         //désactiver btn valide
        $("#btn_form_demandeur_enr").addClass("disabled");
        $(".annulation").addClass("disabled"); 
     

        $.post({

            url:"/set/demandeur", 
            data: donnees, 
            success:function(response){     
                //remove loader  
                $('#loader').remove(); 

                let valide ='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> ' + response  +'</div>';
                $("#erreur_tel_adherent").append(valide); 

                $("#next_reclamation").addClass("visible"); //active btn suivant
                $("#btn_form_demandeur_mod").removeClass("disabled"); //active btn modifier
                $(".annulation").removeClass("disabled"); //active btn annuler
           
                $( ' <span id="success_demandeur" class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>' ).appendTo( "#card_info_demandeur" );


            }, 
            error:function(){
                //remove loader  
                $('#loader').remove(); 
                let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
                $("#erreur_tel_adherent").append(erreur); 

                $("#form_info_demandeur input").prop("disabled" , false); //activer input
                $("#form_info_demandeur select").prop("disabled" , false);
                $("#success_demandeur").remove(); 
                $("#next_reclamation").addClass("cacher");

                //activer btn valide
                $("#btn_form_demandeur_enr").removeClass("disabled");
            }

        })

    }
    
 
 
})


//civilité
$("#civilite").on("change" , function(){
    if($("#civilite").val() !=""){
        $("#erreur_civilite").text(""); 
    }
})

//nom
$("#nom").on("change" , function(){
    if($("#nom").val() !=""){
        $("#erreur_nom").text(""); 
    }
})

//prenom
$("#prenom").on("change" , function(){
    if($("#prenom").val() !=""){
        $("#erreur_prenom").text(""); 
    }
})



//téléphone
$("#tel").on("change" , function(){

    if($("#tel").val() !="" &&  $("#tel").val().length  == 10 ){
        $("#erreur_tel").text(""); 
        $("#label_tel").css("color" , "#858796");  
        $("#label_ad").css("color","#858796");
        $("#btn_form_demandeur_enr").prop("disabled" , false);  
        $("#erreur_tel_adherent").text(""); 
    }else{
        $("#erreur_tel").text("Veuillez saisir un numéro comportant 10 caractères"); 
        $("#btn_form_demandeur_enr").prop("disabled" , true);
        $("#label_tel").css("color" , "red");  
    }
})




//N° adhérent
$("#adherent").on("change" , function(){
    if($("#adherent").val() !="" && $("#adherent").val().length == 13 ){
        $("#erreur_tel_adherent").text(""); 
        $("#label_ad").css("color","#858796");
        $("#label_tel").css("color" , "#858796");  
        $("#btn_form_demandeur_enr").prop("disabled" , false); 
        $("#erreur_ad").text("");
    }else{
        $("#erreur_ad").text("Veuillez saisir un numéro comportant 13 caractères"); 
        $("#btn_form_demandeur_enr").prop("disabled" , true);
        $("#label_ad").css("color","red");
    }
})


//email
$("#email").on("change" , function(){
    $("#erreur_email").text(""); 
    
})



//Button Modifer 
$("#btn_form_demandeur_mod").on("click" , function(){

    $("#form_info_demandeur input").prop("disabled" , false); //activer input
    $("#form_info_demandeur select").prop("disabled" , false);
    $("#btn_form_demandeur_enr").removeClass("disabled"); //activer btn valider

    $("#next_reclamation").addClass("cacher"); //désactive btn suivant
    $("#btn_form_demandeur_mod").addClass("disabled") //déactiver btn modifier
    $("#success_demandeur").remove(); 

})


//Button Suivant 
$("#next_reclamation").on("click" , function(){  
    $("#demandeur").removeClass("show"); 

})



/***************************************/
/* FORMULAIRE INFORMATION RÉCLAMMATION
/***************************************/


//Affichage des sous-motifs en fonction du motif choisi
$("#motif").on("change" , function(){

    $('#select_sous_motif').addClass("cacher"); 
    if($("#motif").val() == 0)
    {
        $("#erreur_info").text("Veuillez choisir un motif"); 
    }else{

        $("#erreur_info").text(""); 
      
        //loader
        $('<div id="loader"></div>').appendTo('#erreur_info');
        $("#motif").prop("disabled" , true); 
        $(".annulation").prop("disabled" , true);
        //btn valider
        $("#btn_form_info_enr").prop("disabled" , true); 
        $("#btn_retour_vers_demandeur").prop("disabled" , true); 

        $.post({
            url:"/get/sous/motif", 
            data : 'motif=' + $("#motif").val(), 
            success:function(response){
                
                $('#loader').remove();
                $("#motif").prop("disabled" , false); 
                $(".annulation").prop("disabled" , false);
                //btn valider
                $("#btn_form_info_enr").prop("disabled" , false); 

                $("#btn_retour_vers_demandeur").prop("disabled" , false); 


                    let tabSousMotif = response['sousMotif'];  
             
                    $('#select_sous_motif').removeClass("cacher"); 

                    let $select = $('#sous-motif');   
                    $select.find('option').remove();   
                    $select.append('<option value="0">--</option>');  

                    tabSousMotif.forEach(function(sousMotif){   
                        var $option = $('<option></option>');   
                        $option.attr('value', sousMotif.id).text(sousMotif.intitule);   
                        $select.append($option);   
                    });
            }, 
            error:function()
            {
                $('#loader').remove();
                let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
                $("#erreur_info").append(erreur);
                //select
                $("#motif").prop("disabled" , false);
                $(".annulation").prop("disabled" , false);
                //btn valider
                $("#btn_form_info_enr").prop("disabled" , false); 
                $("#btn_retour_vers_demandeur").prop("disabled" , false); 


            }
        })


    }



})

//validation
$("#form_info_reclamation").on("submit" , function(e){
    e.preventDefault(); 
    let erreur = true; 
    let donnees = $(this).serialize(); 

    if( $("#motif").val() == 0 || $("#sous-motif").val() == 0){
        $("#erreur_info").text("Veuillez renseigner tous les champs"); 
        erreur = false; 
    }else{
        $("#erreur_info").text("");
    }

    //enregistrement en session
    if(erreur == true){

         //loader
         $('<div id="loader"></div>').appendTo('#erreur_info');
         //select
         $("#form_info_reclamation select").prop("disabled" , true);
         //btn valider
         $("#btn_form_info_enr").prop("disabled" , true); 
         $(".annulation").addClass("disabled"); 
         $("#btn_retour_vers_demandeur").prop("disabled" , true); 


         

        $.post({
            url:"/set/information/reclamation", 
            data: donnees, 
            success:function(response){
                //remove loader  
                $('#loader').remove(); 

                //message
                let valide ='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> ' + response  +'</div>';
                $("#erreur_info").append(valide);    
                $( ' <span id="success_reclam"  class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>' ).appendTo( "#card_reclam" ); 
               
                //btn
                $("#btn_form_info_mod").removeClass("disabled"); 
                $("#next_info_complementaire").addClass("visible"); 
                $(".annulation").removeClass("disabled"); 
                $("#btn_retour_vers_demandeur").prop("disabled" , false); 



            }, 
            error:function(){
                //remove loader  
                $('#loader').remove(); 

                //message
                let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
                $("#erreur_info").append(erreur); 
                $("#success_reclam").remove(); 
                //select
                $("#form_info_reclamation select").prop("disabled" , false);
                //btn
                $("#btn_form_info_enr").prop("disabled" , false);
                $("#btn_form_info_mod").addClass("disabled"); 
                $("#next_info_complementaire").addClass("cacher"); 
                $("#btn_retour_vers_demandeur").prop("disabled" , false); 



            

            }
        })

    }





})


//Button Modifer 
$("#btn_form_info_mod").on("click" , function(){

    $("#form_info_reclamation input").prop("disabled" , false); //activer input
    $("#btn_form_info_enr").removeClass("disabled"); //activer btn valider

    $("#next_info_complementaire").addClass("cacher"); //désactive btn suivant
    $("#btn_form_info_mod").addClass("disabled") //déactiver btn modifier

    $("#success_reclam").remove(); 

})


//Button Suivant 
$("#next_info_complementaire").on("click" , function(){
   
    $("#reclamation").removeClass("show"); 

})

//Button retour
$("#btn_retour_vers_demandeur").on("click", function(){
    $("#reclamation").removeClass("show"); 
})


/***************************************/
/* FORMULAIRE INFORMATION COMPLÉMENTAIRE
/***************************************/

//validation 
$("#form_info_complementaire").on("submit" , function(e){
    e.preventDefault(); 

    let motif = $("#motif").val(); 
    let sousMotif = $("#sous-motif").val(); 

    let erreur = true; 

    if($("#status").val() == 0){
        $("#erreur_status").text("Veuillez renseigner le status"); 
        $("#label_status").css("color" ,"red"); 
        erreur = false; 
    }else{
        $("#erreur_status").text(""); 
        $("#label_status").css("color" ,"#858796");
    }


    //Vérification si motif et sous-motif == Autre 
    if(motif == 15 || sousMotif == 16 )
    {
       
        if($("#information_message").val() == ""){
             erreur = false; 
            $("#erreur_message").text("Veuillez nous communiquer plus d'information"); 
            $("#label_message").css("color" , "red"); 
        }else{
            $("#erreur_message").text(""); 
            $("#label_message").css("color" , "#858796");
        }

    }

    let donnees = $(this).serialize(); 
    if(erreur == true)
    {
        //loader
        $('<div id="loader"></div>').appendTo('#erreur_status');

         //input
         $("#form_info_complementaire input").prop("disabled" , true); 
         $("#form_info_complementaire select").prop("disabled" , true);
         $("#form_info_complementaire textarea").prop("disabled" , true);

         //btn 
         $("#btn_form_info_complementaire_enr").addClass("disabled");
         $(".annulation").prop("disabled" , true); 
         $("#btn_retour_vers_reclamation").prop("disabled" , true); 
       

        $.post({
            url:"/set/information/complementaire", 
            data:donnees, 
            success:function(response){

                //loader
                $("#loader").remove(); 

                //button
                $("#next_validation").addClass("visible"); //active btn suivant
                $("#btn_form_info_complementaire_mod").removeClass("disabled") //activer btn modifier
                $(".annulation").prop("disabled" , false); 
                $("#btn_retour_vers_reclamation").prop("disabled" , false); 
       

                //message
                let valide ='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> ' + response  +'</div>';
                $("#erreur_status").append(valide); 

                $( ' <span id="success_complement" class="btn btn-success btn-circle btn-sm"><i class="fas fa-check"></i></span>' ).appendTo( "#card_info_complementaire" );
            }, 
            error:function(){

                //loader
                $("#loader").remove(); 
                
                //input
                $("#form_info_complementaire input").prop("disabled" , false); 
                $("#form_info_complementaire select").prop("disabled" , false);
                $("#form_info_complementaire textarea").prop("disabled" , false);

                //button
                $("#next_validation").addClass("cacher"); //désactive btn suivant
                $("#btn_form_info_complementaire_mod").prop("disabled" , true) //déactiver btn modifier
                $("#btn_form_info_complementaire_enr").prop("disabled" , false)
                $("#btn_retour_vers_reclamation").prop("disabled" , false); 

                //message
                let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
                $("#erreur_status").append(erreur); 

                $("#success_complement").remove(); 

            }
        })
    }


})



//Button Modifer 
$("#btn_form_info_complementaire_mod").on("click" , function(){

    //input
    $("#form_info_complementaire input").prop("disabled" , false); 
    $("#form_info_complementaire textarea").prop("disabled" , false);

    $("#btn_form_info_complementaire_enr").removeClass("disabled"); //activer btn valider

    $("#next_validation").addClass("cacher"); //désactive btn suivant
    $("#btn_form_info_complementaire_mod").addClass("disabled") //déactiver btn modifier

    $("#success_complement").remove(); 

})


//Button Suivant Affichage du récapitulative
$("#next_validation").on("click" , function(){
   
    $("#information").removeClass("show"); 
      //loader
      $('<div id="loader"></div>').appendTo('#recapitulatif');
    $("#btn_validation").prop("disabled" , true); 
    $("#btn_validation_annule").prop("disabled" , true); 
    $("#btn_retour_vers_information").prop("disabled" , true); 
    


    $.post({
        url:"/get/info", 
        success:function(response){
            //loader
            $('#loader').remove();


            $("#btn_validation").prop("disabled" , false); 
            $("#btn_validation_annule").prop("disabled" , false); 
            $("#btn_retour_vers_information").prop("disabled" , false); 
            
        
           
            //Information demandeur
            let tabInfoDemande = response[0];  
            let ulDemandeur = $("#recap_demandeur"); 
            let html = '<ul><li>Civilité : ' + tabInfoDemande.civilite+'</li>'; 
                html += '<li>Nom : ' + tabInfoDemande.nom +'</li>';
                html += '<li>Prénom : ' + tabInfoDemande.prenom +'</li>';
                html += '<li>Date de naissance : ' + tabInfoDemande.date_de_naissance +'</li>';
                html += '<li>N° Téléphone : ' + tabInfoDemande.tel +'</li>';
                html += '<li>N° Adhérent : ' + tabInfoDemande.numero_adherent +'</li>';
                html += '<li>Email : ' + tabInfoDemande.email +'</li>';
                html += '<li>Suivi de la demande par email ? : ' + tabInfoDemande.consentement +'</li>';
                html += '<li>Suivi de la demande par sms ? : ' + tabInfoDemande.consentement_sms +'</li></ul>';
            ulDemandeur.append(html); 

            //Information réclamation
            let tabInfoReclamation = response[1]; 
            let ulMotif = $("#recap_motif"); 
            let html2 = '<ul><li>Motif : ' + tabInfoReclamation.motif+'</li>';
                html2 += '<li>Sous-Motif : ' + tabInfoReclamation.sous_motif+'</li></ul>';
            ulMotif.append(html2); 

            //Information complémentaire
            let tabInfoComplementaire = response[2]; 
            let ulComplement = $("#recap_complement"); 
            let html3 = '<ul><li>Status : ' + tabInfoComplementaire.status+'</li>';
                html3 += '<li>Message : ' + tabInfoComplementaire.message+'</li>';
            ulComplement.append(html3); 
           
         
        },
        error:function(){
            //loader
            $('#loader').remove();
            
            let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
            $("#recap").before(erreur); 

            $("#btn_validation").prop("disabled" , false); 
            $("#btn_validation_annule").prop("disabled" , false); 
            $("#btn_retour_vers_information").prop("disabled" , false); 
            
        
        }
    })

})

//Button retour 
$("#btn_retour_vers_reclamation").on("click" , function(){
    $("#information").removeClass("show"); 
    $("#recap_demandeur").empty(); 
    $("#recap_motif").empty(); 
    $("#recap_complement").empty(); 
})



/***************************************/
/* CONFIRMATION CRÉATION RÉCLAMATION
/***************************************/

//Button retour 
$("#btn_retour_vers_information").on("click" , function(){
    $("#validation").removeClass("show");
})

//Button validation 
$("#btn_validation").on("click" , function(){
    $("#ValidationModal").modal("show"); 
})

$("#Confirmation").on("click" , function(){

 

    //désactiver les buttons 
    $("#ValidationModal button").prop("disabled" , true); 

    //Création de la réclamation
    $.post({
        url:"/user/reclamation/new", 
        success:function(response){
            
            console.log(response.message); 
            //$("#ValidationModal #message").text(response.message); 
         
            $("#ValidationModal").modal("hide");

            //id réclamation
            let id = response.id; 

            //1) Affiche modale pièce jointe 
            $("#FichierModal").modal("show");

            //1-1)Pas de fichier à transmettre 
            $("#redirect_non_document").on("click" , function(){
                $("#FichierModal").modal("hide");
                
                //2)Transmission
                $("#TransmettreModal").modal("show"); 
             

                //ne pas transmettre
                $("#redirect_non_transmis").on("click", function(){

                    //redirection voir réclamation
                    window.location = "/user/reclamation/show/"+id;

                })

                //transmettre 
                $("#redirect_oui_transmis").on("click", function(){

                    //loader
                    $('<div id="loader"></div>').appendTo('#TransmettreModal #message');

                    //redirection édition transmettre 1 + envois mail 
                    $.post({
                        url:"/set/transmission", 
                        data:'id='+id, 
                        success:function(response)
                        {
                            $("#loader").remove(); 
                            $("#TransmettreModal #message").text(response); 
                            $("#TransmettreModal button").prop("disabled" , true); 
                            window.setTimeout("location=('/');" , 3000);

                        },
                        error:function(error)
                        {
                            $("#loader").remove(); 
                            $("#TransmettreModal #message").text(error); 
                        }
                    })

                })

            })

            //1-2)fichier à transmettre 
            $("#redirect_oui_document").on("click" , function(){

                //modale transmettre
                $("#FichierModal").modal("hide");
                
                //loader
                $('<div id="loader"></div>').appendTo('#recapitulatif');

                //redirection page édition
                window.location = "/user/reclamation/add/document/"+id;
               


            })

        }, 
        error:function()
        {
            //loader
             $("#loader").remove(); 
            //message
            $("#ValidationModal #message").text("Une erreur s'est produite , veuillez re-essayer ultérieurement. Vous allez être redirigé dans quelques instants."); 
            
            //redirection 
            window.setTimeout("location=('/annulation')" , 4000); 
            $("#ValidationModal .modal-footer").addClass("cacher"); 
            
        }

    })

})



/***************************************/
/* ÉDITION INFORMATION RECLAMATION
/***************************************/

//Affichage des sous-motifs au changement
$("#select_motif").on("change" , function(){

    //loader
    $('<div id="loader"></div>').appendTo('#erreur_info');
    $("#select_motif").prop("disabled" , true); 
    $("#select_sous_motif").prop("disabled" , true); 
    $("#btn_edit_info_reclam").prop("disabled" , true); 

    $.post({
        url:"/get/sous/motif", 
        data : 'motif=' + $("#select_motif").val(), 
        success:function(response){
                
            $('#loader').remove();
            $("#select_motif").prop("disabled" , false); 
            $("#select_sous_motif").prop("disabled" , false); 
            $("#btn_edit_info_reclam").prop("disabled" , false); 
           

            let tabSousMotif = response['sousMotif'];  
            let $select = $('#select_sous_motif');   
            $select.find('option').remove();   
            $select.append('<option value="0">--</option>');  

            tabSousMotif.forEach(function(sousMotif){   
                var $option = $('<option></option>');   
                $option.attr('value', sousMotif.id).text(sousMotif.intitule);   
                $select.append($option);   
            });
        }, 
        error:function()
        {
            $('#loader').remove();
            let erreur ='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><i class="fa fa-times"></i> Une erreur s\'est produite, veuillez ré-essayer ultérieurement</div>';
            $("#erreur_info").append(erreur);
            //select
            $("#select_motif").prop("disabled" , false);
            $("#select_sous_motif").prop("disabled" , false); 
            $("#btn_edit_info_reclam").prop("disabled" , false);
            
        }
    })






})





/***************************************/
/* TRAITEMENT RÉCLAMATION
/***************************************/


$("#etat").text() == "Demande d'information" ? $("#admin_demande_info").addClass("disabled") : $("#admin_demande_info").removeClass("disabled"); 

$("#etat").text() == "Demande d'information" ? $("#admin_transfere").addClass("disabled") : $("#admin_transfere").removeClass("disabled"); 