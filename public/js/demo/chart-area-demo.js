

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
      
      //information concernant les tâches
      response.tasks.forEach(element => {

        //Mois de création de la tâche
        $date = new Date(element.createdAt); 
        let dateFormat = $date.toLocaleDateString('fr-FR').split( "/" );  
        for (index in tabMois) {dateFormat[1] == index ?  mois.push( dateFormat[0] + " " + tabMois[index] ) : ""; }
      
      });

      /***********************
      *  NB TACHE CRÉE/JOUR
      ***********************/
      //trie le tableau
      let sort = mois.sort(); 

      //retire doublons (mois)
      let newTab = sort.filter((item,index) => {return sort.indexOf(item) === index}); 
        
      //Nombre de tâche crée 
      let occurrences = { };//trie
      let nbTask = []; //tableau nb tâche
      for (var i = 0, j = sort.length; i < j; i++) {occurrences[sort[i]] = (occurrences[sort[i]] || 0) + 1;}
      for (index in occurrences){nbTask.push(occurrences[index]); }
      

      $("#myAreaChart").removeClass("cacher"); 
      $(".loader_tache_create").addClass("cacher"); 

      // Affichage Area Chart 
      var ctx = document.getElementById("myAreaChart");
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: newTab,
          datasets: [{
            label: "Nombre de tâche crée",
            lineTension: 0.3,
            backgroundColor: "rgba(78, 115, 223, 0.05)",
            borderColor: "rgba(78, 115, 223, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(78, 115, 223, 1)",
            pointBorderColor: "rgba(78, 115, 223, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: nbTask,
          }],
        },
        options: {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              gridLines: {
                display: false,
                drawBorder: false
              }
            }],
            yAxes: [{
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              /*label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
              }*/
            }
          }
        }
      });



      
    }





  })
 






