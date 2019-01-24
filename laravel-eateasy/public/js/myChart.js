$( document ).ready(function() {
	/* GRAFICO NELLA RESERVED AREA ESERCENTE */
		var ctx = document.getElementById("GraficoPunteggio");
		var myChart = new Chart(ctx, {
			type: 'horizontalBar',
		    data: {
		        labels: ["Arrivals", "Access", "Food", "Baby", "Technology", "Green"],
		        datasets: [{
		            label: 'Punteggio personale',
		            data: [$("#Arrivals").val(),$("#Access").val() ,$("#Food").val() ,$("#Baby").val() ,$("#Technology").val() ,$("#Green").val() ],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.6)',
		                'rgba(54, 162, 235, 0.6)',
		                'rgba(255, 206, 86, 0.6)',
		                'rgba(75, 192, 192, 0.6)',
		                'rgba(153, 102, 255, 0.6)',
		                'rgba(255, 159, 64, 0.6)'
		            ],
		            borderColor: [
		                'rgba(255,99,132,1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        },
		        {
		        	label: 'Ristoranti della tua città',
		            data: [$("#Arrivals2").val(),$("#Access2").val() ,$("#Food2").val() ,$("#Baby2").val() ,$("#Technology2").val() ,$("#Green2").val() ],
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255,99,132,1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        }
		        ]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true,
		                    max: 100
		                }
		            }]
		        }
		    }
		});
});