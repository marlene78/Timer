

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


  let html = "";
  //récupère les informations du projet
  $.post({
    url:"/user/info/projet/"+id, 
    data:"id="+id,
    success:function(response){
       
      let nameTask = [];
      let etatTask = [];
      let clotureTab = [];
      let tabEnCours = [];
      console.log(response.tasks)
      //information concernant les tâches
      response.tasks.forEach(element => {

        //nom de la tâche
        //nameTask.push(element.nom); 

        //cloture de la tâche
        //etatTask.push(element.cloture)
        


       /* for(let j= 0; j < nameTask.length; j++){
            
            html +='<ul class="list-group list-group-flush"> <li class="list-group-item">'+ nameTask[j]+'</li> </ul>'
        
        }*/
        
          
   /*      for(let j= 0; j < etatTask.length; j++){
          if(etatTask[j] == false ){
            clotureTab.push(etatTask[j]);
          }
          else{
            tabEnCours.push(etatTask[j]);
          }
          
        } */
        //console.log('cloture'+clotureTab)
        //console.log('encours'+tabEnCours)
        
      });


      //$("#myAreaTab").append(html); 
      //console.log(nameTask)

      /***********************
      *  NB TACHE CRÉE/JOUR
      ***********************/
      //trie le tableau
     // let sort = mois.sort(); 

      //retire doublons (mois)
      //let newTab = sort.filter((item,index) => {return sort.indexOf(item) === index}); 
        
      //Nombre de tâche crée 
      /*let occurrences = { };//trie
      let nbTask = []; //tableau nb tâche
      for (var i = 0, j = sort.length; i < j; i++) {occurrences[sort[i]] = (occurrences[sort[i]] || 0) + 1;}
      for (index in occurrences){nbTask.push(occurrences[index]); }*/
      


      



      
    }





  })
 






