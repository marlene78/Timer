

    // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  

  let pathArray = window.location.pathname.split( "/" );
  let id = pathArray[4]; 


  let mois = []; 
  let tabMois = {
    "01" :  'Janvier' , 
    "02" : "Février" , 
    "03" : "Mars" , 
    "04" : "Avril" , 
    "05" : "Mai" ,
    "06" : "Juin" , 
    "07" : "Juillet" , 
    "08" : "Août" , 
    "09" : "Septembre" , 
    "10" : "Octobre" ,
    "11" : "Novembre" , 
    "12" : "Décembre"
  }; 


  //récupère les informations du projet
  $.post({
    url:"/user/info/projet/"+id, 
    data:"id="+id,
    success:function(response){

      let nonCommenceTab  = [];
      let clotureTab = [];
      let EnCoursTab = [];

      //information concernant les tâches
      response.tasks.forEach(element => {

        if(element.demarre == 0 && element.cloture == 0){
          let tab = {
            'nom':element.nom,
            'demarre' : element.demarre,
            'cloture' : element.cloture
          };

          nonCommenceTab.push(tab);
        }
        else if(element.demarre == 1 && element.cloture == 0){
          let tab = {
            'nom':element.nom,
            'demarre' : element.demarre,
            'cloture' : element.cloture
          };

          EnCoursTab.push(tab);
        }
        else if(element.cloture == 1){
          let tab = {
            'nom':element.nom,
            'demarre' : element.demarre,
            'cloture' : element.cloture
          };

          clotureTab.push(tab);
        }


      });

      nonCommenceTab.forEach(element => {
        let html = "";
        html +='<ul class="list-group list-group-flush"> <li class="list-group-item">'+element.nom +'</li> </ul>'

        $("#myAreaTab").append(html);
      });

      EnCoursTab.forEach(element => {
        let html = "";
        html +='<ul class="list-group list-group-flush"> <li class="list-group-item">'+element.nom +'</li> </ul>'
        
        $("#myAreaTabEnCours").append(html);
        
      });
      clotureTab.forEach(element => {
        let html = "";
        html +='<ul class="list-group list-group-flush"> <li class="list-group-item">'+element.nom +'</li> </ul>'
        
        $("#myAreaTabEnCloture").append(html);
        
      });

      let nbTasks = nonCommenceTab.length + clotureTab.length + EnCoursTab.length;

      $("#nbTasks").append('Nombre de tâches crées : '+ nbTasks);
      


      



      
    }





  })
 






