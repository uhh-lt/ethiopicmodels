<?php
	include("header.php");
?>


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
				
				<?php
					
					include("sidemenu.php");
				?>
				
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
						
						<?php
							include("mainmenu.php");
						?>
				</div>
			</div>
		</nav>
		<h2 class="mb-4">Chart Report</h2>
		<p>
			The Pie chart provides cumulative information (on Twitter dataset since Jan 2020) on the distributions of facts, hate speech, and fake news. News corpus is used as background information. <kbd>Fake tweets</kbd> are those that are not supported by the news corpora.
		</p>
		<p>
			<div id="chartContainer" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
		</p>
	</div>
</div>

<?php
	include("scripts.php");
?>
</body></html>
