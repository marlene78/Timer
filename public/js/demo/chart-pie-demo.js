// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

let taskName = []; 
let taskProgress = []; 
let taskPriorite = []; 
let legend = []; 
let color = [];

/**
 * Génère une couleur
 */
function generateRandomColor(){
  var randomColor = '#'+Math.floor(Math.random()*16777215).toString(16);
  return randomColor;
}

/***********************
  *  POURCENTAGE TACHE
***********************/
$.post({
  url:"/user/info/projet/"+id, 
  data:"id="+id,
  success:function(response){
    //information concernant les tâches
    response.tasks.forEach(element => {   
      taskName.push(element.nom); 
      taskProgress.push(element.timer.progress); 
      let colorItem = generateRandomColor(); 
      color.push(colorItem); 
    })

    $("#myPieChart").removeClass("cacher"); 
    $(".loader_pourcentage").addClass("cacher"); 

        var ctx = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: taskName,
            datasets: [{
              data: taskProgress,
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

  },



})
