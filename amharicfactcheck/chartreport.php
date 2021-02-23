<!DOCTYPE html>
<!-- saved from url=(0054)https://colorlib.com/etc/bootstrap-sidebar/sidebar-01/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>amharicfactcheck</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="lib/sidebar/css" rel="stylesheet">
	<link rel="stylesheet" href="lib/sidebar/font-awesome.min.css">
	<link rel="stylesheet" href="lib/sidebar/style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	
	<script type="text/javascript">
	    function chartData(){

			      var dataPointsA = [];
			    $.ajax({
                    url: 'https://ltdemos.informatik.uni-hamburg.de/amsol/charts',
                  
                    type: "GET",
                    dataType: "JSON",
                    data: {
                    },
                    success: function (result) {
                        var objData = JSON.parse(result);
                        
                        dataPointsA.push({ label: "Hate", y: objData.Tweets.hate });
                        dataPointsA.push({ label: "Fact", y: objData.Tweets.fact });
                        dataPointsA.push({ label: "Fake", y: objData.Tweets.fake });
                        console.log("Success" + objData);
                    

        			    var options = {
        					title: {
        						text: "Chart Report"
        					},
        					data: [{
        						type: "pie",
        						startAngle: 90,
        						showInLegend: "true",
        						legendText: "{label}",
        						indexLabel: "{label} ({y})",
        						yValueFormatString:"#,##0.#"%"",
        						dataPoints: 
        						    
        						//{ label: "Facts", y: 30 },
        						//{ label: "Propaganda", y: 31 },
        						//{ label: "Hate", y: 17 },
        						//{ label: "Disinformation", y: 7 }
        						dataPointsA
        						
        					}]
    				};
    				$("#chartContainer").CanvasJSChart(options);
    			

                    },
                    error: function () {
                        console.log("error");
                    }
                });
                
                
			}
			
			window.onload = function() {
			    
			    chartData();
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
					<li class="active">
						<a href="chartreport.php">Chart Report</a>
					</li>
					<li>
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
			<h2 class="mb-4">Chart Report</h2>
			<p>
			    The Pie chart provides commutative information (on Twitter dataset since Jan 2020) on the distributions of facts, hate speech, and fake news. News corpus is used as background information. <kbd>Fake tweets</kbd> are those that are not supported by the news corpora. 
			</p>
			<p>
			    <div id="chartContainer" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
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