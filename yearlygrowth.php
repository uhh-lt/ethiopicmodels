<?php
	include("header.php");
?>
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
			<h2 class="mb-4">Yearly  Growth Report</h2>
			<p>
			    Based on the selected hate speech lexicon, the yearly growth graph shows the number of <kbd>hate and normal speech</kbd> tweets, computed on a monthly manner.
			</p>
			<p>
			    <div id="chartContainer2" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
			</p>
		</div>
	</div>
	<?php 
		include("scripts.php");
	?>

</body></html>
