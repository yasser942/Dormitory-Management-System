$(function() {
    "use strict";



     // chart 1

		  var ctx = document.getElementById('chart1').getContext('2d');

			var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8" , "9", "10", "11", "12" , "13", "14", "15", "16", "17", "18", "19", "20", "21", "22" , "23", "24", "25", "26", "27", "28", "29", "30" ,'31'],
                    datasets: [{
                        label: ' This Month',
                        data: visitorData, // Use the data variable
                        backgroundColor: '#14abef',
                        borderColor: "transparent",
                        pointRadius: "0",
                        borderWidth: 3
                    }, {
                        label: ' Last Month',
                        data: visitorData2, // Use the data variable
                        backgroundColor: "rgba(20, 171, 239, 0.35)",
                        borderColor: "transparent",
                        pointRadius: "0",
                        borderWidth: 1
                    }]
                },
			options: {
				maintainAspectRatio: false,
				legend: {
				  display: false,
				  labels: {
					fontColor: '#585757',
					boxWidth:40
				  }
				},
				tooltips: {
				  displayColors:false
				},
			  scales: {
				  xAxes: [{
					ticks: {
						beginAtZero:true,
						fontColor: '#585757'
					},
					gridLines: {
					  display: true ,
					  color: "rgba(0, 0, 0, 0.05)"
					},
				  }],
				   yAxes: [{
					ticks: {
						beginAtZero:true,
						fontColor: '#585757'
					},
					gridLines: {
					  display: true ,
					  color: "rgba(0, 0, 0, 0.05)"
					},
				  }]
				 }

			 }
			});


    // chart 2
    var vacantRoomsElement = document.getElementById('data1');
    var occupiedRoomsElement = document.getElementById('data2');

    var vacantRoomsData = vacantRoomsElement.textContent;
    var occupiedRoomsData = occupiedRoomsElement.textContent;

    var ctx = document.getElementById("chart2").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
					labels: ["", "",  ""],
					datasets: [{
						backgroundColor: [

							"#02ba5a",
							"#d31e1e",
							"#fba540"
						],
						data: [vacantRoomsData, occupiedRoomsData, 0],
						borderWidth: [0, 0, 0, 0]
					}]
				},
				options: {
					maintainAspectRatio: false,
					cutoutPercentage: 60,
				   legend: {
					 position :"bottom",
					 display: false,
						labels: {
						  fontColor: '#ddd',
						  boxWidth:15
					   }
					}
					,
					tooltips: {
					  displayColors:false
					}
				   }
			});




    // easy pie chart

	 $('.easy-dash-chart1').easyPieChart({
		easing: 'easeOutBounce',
		barColor : '#3b5998',
		lineWidth: 10,
		trackColor : 'rgba(0, 0, 0, 0.08)',
		scaleColor: false,
		onStep: function(from, to, percent) {
			$(this.el).find('.w_percent').text(Math.round(percent));
		}
	 });


	 $('.easy-dash-chart2').easyPieChart({
		easing: 'easeOutBounce',
		barColor : '#55acee',
		lineWidth: 10,
		trackColor : 'rgba(0, 0, 0, 0.08)',
		scaleColor: false,
		onStep: function(from, to, percent) {
			$(this.el).find('.w_percent').text(Math.round(percent));
		}
	 });


	 $('.easy-dash-chart3').easyPieChart({
		easing: 'easeOutBounce',
		barColor : '#e52d27',
		lineWidth: 10,
		trackColor : 'rgba(0, 0, 0, 0.08)',
		scaleColor: false,
		onStep: function(from, to, percent) {
			$(this.el).find('.w_percent').text(Math.round(percent));
		}
	 });

// chart 2
    var libraryFeeas = document.getElementById('data1');
    var roomFees = document.getElementById('data2');
    var kitchenFees = document.getElementById('data3');
    var gymFees = document.getElementById('data4');

    var Library = libraryFeeas.textContent;
    var Room = roomFees.textContent;
    var Kitchen = kitchenFees.textContent;
    var Gym = gymFees.textContent;

    var ctx = document.getElementById("chart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Library", "Room",  "Kitchen", "Gym"],
            datasets: [{
                backgroundColor: [

                    "#02ba5a",
                    "#d31e1e",
                    "#fba540",
                    "#224272"
                ],
                data: [Library, Room, Kitchen, Gym],

                borderWidth: [0, 0, 0, 0]
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutoutPercentage: 60,
            legend: {
                position :"bottom",
                display: false,
                labels: {
                    fontColor: '#ddd',
                    boxWidth:15
                }
            }
            ,
            tooltips: {
                displayColors:false
            }
        }
    });
// worl map

jQuery('#dashboard-map').vectorMap(
{
    map: 'world_mill_en',
    backgroundColor: 'transparent',
    borderColor: '#818181',
    borderOpacity: 0.25,
    borderWidth: 1,
    zoomOnScroll: false,
    color: '#009efb',
    regionStyle : {
        initial : {
          fill : '#14abef'
        }
      },
    markerStyle: {
      initial: {
        r: 9,
        'fill': '#fff',
        'fill-opacity':1,
        'stroke': '#000',
        'stroke-width' : 5,
        'stroke-opacity': 0.4
                },
                },
    enableZoom: true,
    hoverColor: '#009efb',
    markers : [{
        latLng : [21.00, 78.00],
        name : 'Lorem Ipsum Dollar'

      }],
    hoverOpacity: null,
    normalizeFunction: 'linear',
    scaleColors: ['#b6d6ff', '#005ace'],
    selectedColor: '#c9dfaf',
    selectedRegions: [],
    showTooltip: true,
});


   $("#trendchart1").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8], {
      type: 'bar',
      height: '20',
      barWidth: '2',
      resize: true,
      barSpacing: '3',
      barColor: '#eb5076'
    });


	$("#trendchart2").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8], {
      type: 'bar',
      height: '20',
      barWidth: '2',
      resize: true,
      barSpacing: '3',
      barColor: '#14abef'
    });


    $("#trendchart3").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8], {
      type: 'bar',
      height: '20',
      barWidth: '2',
      resize: true,
      barSpacing: '3',
      barColor: '#02ba5a'
    });


    $("#trendchart4").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8], {
      type: 'bar',
      height: '20',
      barWidth: '2',
      resize: true,
      barSpacing: '3',
      barColor: '#d13adf'
    });


     $("#trendchart5").sparkline([5,8,7,10,9,10,8,6,4,6,8,7,6,8,9,10,8], {
      type: 'bar',
      height: '20',
      barWidth: '2',
      resize: true,
      barSpacing: '3',
      barColor: '#000000'
    });


	  // chart 3

     var ctx = document.getElementById('chart3').getContext('2d');

       var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
          datasets: [{
            label: 'Page Views',
            data: [0, 8, 12, 5, 12, 8, 16, 25, 15, 10, 20, 10, 30],
            backgroundColor: 'rgba(0, 150, 136, 0.33)',
            borderColor: '#009688',
            pointBackgroundColor:'#fff',
            pointHoverBackgroundColor:'#fff',
            pointBorderColor :'#fff',
            pointHoverBorderColor :'#fff',
            pointBorderWidth :1,
            pointRadius :0,
            pointHoverRadius :4,
            borderWidth: 3
          }]
        }
        ,
        options: {
			maintainAspectRatio: false,
              legend: {
                position: false,
                display: true,
            },
        tooltips: {
           enabled: false
      },
     scales: {
          xAxes: [{
            display: false,
            gridLines: false
          }],
          yAxes: [{
            display: false,
            gridLines: false
          }]
        }
        }

      });

       // chart 4

	  var ctx = document.getElementById("chart4").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
					datasets: [{
						label: 'Total Clicks',
						data: [0, 10, 14, 18, 12, 8, 16, 25, 15, 10, 20, 10, 30],
						backgroundColor: "#ff6a00"
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
					  display: false,
					  labels: {
						fontColor: '#ddd',
						boxWidth:40
					  }
					},
					tooltips: {
					  enabled:false
					},

					scales: {
					  xAxes: [{
						  barPercentage: .3,
						display: false,
						gridLines: false
					  }],
					  yAxes: [{
						display: false,
						gridLines: false
					  }]
					}

			 }

			});

     // chart 5

	   var ctx = document.getElementById("chart5").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
					datasets: [{
						label: 'Total Earning',
						data: [39, 19, 25, 16, 31, 39, 23, 20, 23, 18, 15, 20],
						backgroundColor: "#04b35a"
					},{
						label: 'Total Sales',
						data: [27, 12, 26, 15, 21, 27, 13, 19, 32, 22, 18, 30],
						backgroundColor: "rgba(4, 179, 90, 0.35)"
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
					  display: false,
					  position: 'bottom',
					  labels: {
						fontColor: '#ddd',
						boxWidth:13
					  }
					},
					tooltips: {
					  enabled:true,
					  displayColors:false,
					},

					scales: {
					  xAxes: [{
					  	 stacked: true,
						  barPercentage: .4,
						display: false,
						gridLines: false
					  }],
					  yAxes: [{
					  	stacked: true,
						display: false,
						gridLines: false
					  }]
					}

			 }

			});




   });
