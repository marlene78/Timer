let pathArray = window.location.pathname.split( "/" );
let id = pathArray[4]; 

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

/**
 * Génère une couleur
 */
function generateRandomColor(){
  var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
  return randomColor;
}

// Pie Chart Example
var ctx = document.getElementById("pieChartUser");

let listTache = []; 
let time = []; 
let color = []; 
let html = "";
$.post({
  url:"/user/info/user/"+id, 
  data:"id="+id,
  success:function(response){
    response.tasks.forEach(element => {

        listTache.push(element.nom); 
        time.push(element.timer.progress)
        let myColor = generateRandomColor(); 
        color.push(myColor); 

        html +='<h4 class="small font-weight-bold"><a href="/user/task/show/'+ element.id +'">'+ element.nom +'</a><span class="float-right">'+element.timer.heure +"h : "+ element.timer.minute + "mn : " + element.timer.seconde +'s</span></h4><div class="progress mb-4"><div class="progress-bar" role="progressbar" style="width:'+element.timer.progress+'%;background-color:'+myColor+'" aria-valuenow="'+ element.timer.progress +'" aria-valuemin="0" aria-valuemax="100"></div></div>'; 

    });
    console.log(time);

    $("#info_projet_avancement").append(html); 

    $("#pieChartUser").removeClass("cacher"); 
    $("#info_projet_avancement").removeClass("cacher"); 
    $(".loader_pourcentage_user").addClass("cacher"); 

    var pieChartUser = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: listTache,
        datasets: [{
          data: time,
          backgroundColor: color,
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true
        },
        cutoutPercentage: 80,
      },
    });

  }
  
}); 





