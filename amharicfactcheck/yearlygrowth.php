<!DOCTYPE html>
<!-- saved from url=(0054)https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>amharicfactcheck</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="lib/sidebar/css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="lib/sidebar/style.css">
	
	<script type="text/javascript">
	    function lineChartData(){
			    
			    var dataPointsA = [];
			    var hateListData = [];
			    var normalListData = [];
			    $.ajax({
                    url: 'https://ltdemos.informatik.uni-hamburg.de/amsol/growth',
                  
                    type: "GET",
                    dataType: "JSON",
                    data: {
                    },
                    success: function (result) {
                        var objData = JSON.parse(result);
                        var hateData = objData.Tweets.hate;
                        var normalData = objData.Tweets.normal;
                         
                       // alert ("SS"+objData.Tweets.hate);
                         
                         for (var key in hateData) {
                            if (hateData.hasOwnProperty(key)) {
                                for (var key2 in hateData[key]) {
                                
                                    key3 = new Date(key2.replace(/-/g,','));                                    
                                    //console.log(key2+"-> " + key3 + " -> " + hateData[key][key2]);

                 hateListData.push({x: key3 , y: hateData[key][key2]});

                                }

                            }
                        }
                        
                        
                        for (var key in normalData) {
                            if (normalData.hasOwnProperty(key)) {
                                for (var key2 in normalData[key]) {
                                
                                    key3 = new Date(key2.replace(/-/g,','));                                    
                                    //console.log("Normal" + key2+"-> " + key3 + " -> " + normalData[key][key2]);

                 normalListData.push({x: key3 , y: normalData[key][key2]});

                                }

                            }
                        }

                        
                        var options2 = {
        					animationEnabled: true,
        					theme: "light2",
        					title:{
        						text: "Yearly Growth"
        					},
        					axisX:{
        						valueFormatString: "DD MMM YYYY"
        					},
        					axisY: {
        						title: "Number of Speech",
        						suffix: "K",
        						minimum: 30
        					},
        					toolTip:{
        						shared:true
        					},  
        					legend:{
        						cursor:"pointer",
        						verticalAlign: "bottom",
        						horizontalAlign: "left",
        						dockInsidePlotArea: true,
        						itemclick: toogleDataSeries
        					},
        					data: [{
        						type: "line",
        						showInLegend: true,
        						name: "Hate Speech Growth",
        						markerType: "square",
        						xValueFormatString: "DD MMM, YYYY",
        						color: "#F08080",
        						yValueFormatString: "#,##0",
        						dataPoints: hateListData
        					},
        					{
        						type: "line",
        						showInLegend: true,
        						name: "Normal Speech Growth",
        						lineDashType: "dash",
        						yValueFormatString: "#,##0",
        						dataPoints: normalListData
        					}]
        				};
    				
    				
    				
    				$("#chartContainer2").CanvasJSChart(options2);
    				
    				function toogleDataSeries(e){
					if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
						e.dataSeries.visible = false;
						} else{
						e.dataSeries.visible = true;
					}
					e.chart.render();
				}
    				
                      
    
                        },
                    error: function () {
                        console.log("error");
                    }
                });
                
                
			}
			
			window.onload = function() {
			    
			    lineChartData();
			}
	</script>
</head>
<body>
	<div class="wrapper d-flex align-items-stretch">
		<nav id="sidebar">
			<div class="p-4 pt-5">
				<a href="home.php" class="img logo rounded-circle mb-5" style="background-image: url(selam.png);"></a>
				<ul class="list-unstyled components mb-5">
					<li>
						<a href="home.php">Home</a>
					</li>
					<li>
						<a href="dailyinfo.php">Daily Info</a>
					</li>
					<li>
						<a href="checkfact.php">Check a Fact</a>
					</li>
					<li>
						<a href="chartreport.php">Chart Report</a>
					</li>
					<li class="active">
						<a href="yearlygrowth.php">Yearly Growth</a>
					</li>
				</ul>
				<div class="footer">
					<p>
					Copyright ©2021 All rights reserved 
					</p>
				</div>
			</div>
		</nav>
		
		<div id="content" class="p-4 p-md-5">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
						<i class="fa fa-bars"></i>
						<span class="sr-only">Toggle Menu</span>
					</button>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fa fa-bars"></i>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item active">
								<a class="nav-link" href="index.php">Home</a>
							</li>

							<li class="nav-item">			
								<a  target='_blank' class="nav-link" href="https://bit.bdu.edu.et/ict4d/">ICT4D</a>
							</li>
							<li class="nav-item">
								<a  target='_blank' class="nav-link" href="https://www.inf.uni-hamburg.de/en/inst/ab/lt/people/seid-muhie-yimam.html">LT</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="about.php">About Us</a>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<h2 class="mb-4">Yearly  Growth Report</h2>
			<p>
			    Based on the selected hate speech lexicon, the yearly growth graph shows the number of <kbd>hate and normal speech</kbd> tweets, computed on a monthly manner.
			</p>
			<p>
			    <div id="chartContainer2" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
			</p>
		</div>
	</div>
	<script src="lib/sidebar/jquery.min.js.download"></script>
	<script src="lib/sidebar/popper.js.download"></script>
	<script src="lib/sidebar/bootstrap.min.js.download"></script>
	<script src="lib/sidebar/main.js.download"></script>
	<script defer="" src="lib/sidebar/beacon.min.js.download"></script>
	
		<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script> 
	
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	
</body></html>