<!DOCTYPE html>
<html lang="sr">

<head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<meta http-equiv="refresh" content="300" />
	<script src="js/Chart.min.js"></script>

</head>

<body onload="program()">
	<h2>Pregled temperatura</h2>
	<div width="400" heighth="100"><canvas id="Senzor1" width="400" height="100"></canvas> </div>
	<div width="400" heighth="100"><canvas id="Senzor2" width="400" height="100"></canvas> </div>

<script>
function program(){
	uzmiPodatke("Senzor1");
	uzmiPodatke("Senzor2");
	return 1;
}
function uzmiPodatke(senzor){
	var pozivBaze;
	var podaci = [];
	pozivBaze = new XMLHttpRequest();
  	pozivBaze.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			podaci = JSON.parse(this.responseText);
		        var i = 0;
			var n;
			var t = [];
			var v = [];
			for( i = 149; i > -1; i--){
				t.push(podaci[i].temperatura);
				v.push(podaci[i].vreme);
			}
		}		
		var myChart = document.getElementById(senzor).getContext('2d');
		var grafik = new Chart(myChart, {
		    type: 'line',
		    data: {
			labels: v,
			datasets: [{
		            	label: senzor,
				data:  t,
				fill: false,
		        	backgroundColor: [],
			        borderColor: ['rgba(54, 162, 235, 1)'],
		        	borderWidth: 5
		        }]
		    },
		    options: {
		        scales: {
				yAxes: [{
					gridLines: {
						drawBorder: false,
						color: ['black', 'black', 'red', 'black', 'red']				
					},
		                	ticks: {
						beginAtZero: true,
						min: 0,
						max: 50,
						stepSize: 10
					}
		            	}]
		        }
		    }
		});
	}
	pozivBaze.open("GET", "backend.php?senzor=Senzor1", true);
	pozivBaze.send();
}
</script>
</body>
</html>

