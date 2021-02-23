<!DOCTYPE html>

<?php

		function feachDailyData(){

	    $url = "https://ltdemos.informatik.uni-hamburg.de/amsol/daily";
		
		$ch = curl_init($url);
		
		#curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		#curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CAINFO, true);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$server_output = curl_exec ($ch);
		
		//echo $server_output . " " . $url;die;
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
	    if (!$status  || !($status == 201 || $status == 200)) {
    		//print("Error: call to URL $url failed with status $status, response $server_output, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));
    		
    		return "Nothing found";
			
		}
		else{
			$decoded = json_decode($server_output , true);
			
			
			
			$assoc = json_decode($decoded, true);
			$output =  "";
			foreach ($assoc as $key => $value) {
				foreach ($value as $key2 => $value2) {

                    //echo "V.K ".$value2 . $key2;die;
                    
                    /*
					$output = $output . "<li class='list-group-item d-flex justify-content-between align-items-center'>" 
					. $key2 
					. "<span class='badge badge-primary badge-pill text-uppercase'>"
					.$value2
					."</span></li>";
					
					*/
					$speechKey = $value2;
					$speechTwitterId = $value2;
					if (($pos = strpos($value2, "_")) !== FALSE) { 
                        $valueV = explode("_", $value2);
                        
                        $speechKey = $valueV[0];
                        $speechTwitterId = $valueV[1];
                    }
                  //echo $speechTwitterId;

					$output = $output . "<tr class='v-middle'><td>"
					."<a href='https://twitter.com/anyuser/status/{$speechTwitterId}'>"
					.$key2
					."</a>"
					."</td><td><span class='badge badge-primary text-uppercase'>"
					.$speechKey
					."</span></td></tr>";
					
				}
			}
			
			
			return $output;
		}
		
	}
	
	function feachData(){
	    $search_keyword = $_POST['searchkeyword'];
	    //$search_keyword = rawurlencode($search_keyword);
	    
	    $search_keyword = str_replace(' ', '%20', $search_keyword);
		//echo $search_keyword;		die;
	    $url = "https://ltdemos.informatik.uni-hamburg.de/amsol/news/" . $search_keyword;
		
		
		$ch = curl_init($url);
		
		#curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		#curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CAINFO, true);
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$server_output = curl_exec ($ch);
		
		//echo $server_output . " " . $url;
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
	    if (!$status  || !($status == 201 || $status == 200)) {
    		/*print("Error: call to URL $url failed with status $status, response $server_output, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));*/
			echo "Error";
			}else{
			$decoded = json_decode($server_output , true);
			
			
			
			$assoc = json_decode($decoded, true);
			$output =  "";
			foreach ($assoc as $key => $value) {
				foreach ($value as $key2 => $value2) {

					//$output = $output . "<li class='list-group-item'>" . $value2 . "</li>";
					
					
					$output = $output . "<tr class='v-middle'><td>"
										.$value2
					."</td></tr>";
					
				}
			}
			
			curl_close ($ch);

			return $output;
		}
	}
	
	

?>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
						<meta charset="UTF-8">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		
				<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">
	
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

		
		<style>
			body {
			margin: 0;
			font-family: Arial, Helvetica, sans-serif;
			}
			
			.topnav {
			overflow: hidden;
			background-color: #333;
			}
			
			.topnav a {
			float: left;
			display: block;
			color: #f2f2f2;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
			font-size: 17px;
			}
			
			.topnav a:hover {
			background-color: #ddd;
			color: black;
			}
			
			.topnav a.active {
			background-color: #4CAF50;
			color: white;
			}
			
			.topnav .icon {
			display: none;
			}
			
			@media screen and (max-width: 600px) {
			.topnav a:not(:first-child) {display: none;}
			.topnav a.icon {
			float: right;
			display: block;
			}
			}
			
			@media screen and (max-width: 600px) {
			.topnav.responsive {position: relative;}
			.topnav.responsive .icon {
			position: absolute;
			right: 0;
			top: 0;
			}
			.topnav.responsive a {
			float: none;
			display: block;
			text-align: left;
			}
			}
		</style>
		
		
		<script type="text/javascript">
			
			/*
			$(document).ready( function () {
    
            } );*/

			function myFunction() {
				var x = document.getElementById("myTopnav");
				if (x.className === "topnav") {
					x.className += " responsive";
					} else {
					x.className = "topnav";
				}
			}
			
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
    				
                         /*   
                            dataPointsA.push({ label: "Hate", y: objData.Tweets.hate });
                            dataPointsA.push({ label: "Fact", y: objData.Tweets.fact });
                            dataPointsA.push({ label: "Fake", y: objData.Tweets.fake });
                            console.log("Success" + objData);
                        */
    
    /*
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
        				//$("#chartContainer2").CanvasJSChart(options2);
        			*/
    
                        },
                    error: function () {
                        console.log("error");
                    }
                });
                
                
			}
			
			function chartData(){
			    
			    /*
			    	var dataPoints = [];
var chart = new CanvasJS.Chart("chartContainer",{
    title:{
        text:"Rendering Chart with dataPoints from External JSON"
    },
    data: [{
        type: "line",
        dataPoints : dataPoints,
    }]
});

$.getJSON("https://canvasjs.com/services/data/datapoints.php?xstart=1&ystart=10&length=100&type=json", function(data) {  
    $.each(data, function(key, value){
        dataPoints.push({x: value[0], y: parseInt(value[1])});
    });
    chart.render();
});
$("#chartContainer").CanvasJSChart(options);

*/

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
			    
			    lineChartData();
	
	            $('#dailyInfoTable').DataTable();

	            $('#factCheckerTable').DataTable();
				            


		
				
				
				
				
				
				
				/*
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
						name: "Fake Speech",
						markerType: "square",
						xValueFormatString: "DD MMM, YYYY",
						color: "#F08080",
						yValueFormatString: "#,##0K",
						dataPoints: [
						{ x: new Date(2014, 1, 1), y: 20 },
						{ x: new Date(2014, 2, 1), y: 30 },
						{ x: new Date(2015, 10, 3), y: 65 },
						{ x: new Date(2015, 10, 4), y: 70 },
						{ x: new Date(2015, 10, 5), y: 71 },
						{ x: new Date(2016, 10, 6), y: 65 },
						{ x: new Date(2016, 10, 7), y: 73 },
						{ x: new Date(2016, 10, 8), y: 96 },
						{ x: new Date(2017, 10, 9), y: 84 },
						{ x: new Date(2017, 10, 10), y: 85 },
						{ x: new Date(2017, 10, 11), y: 86 },
						{ x: new Date(2018, 10, 12), y: 94 },
						{ x: new Date(2018, 10, 13), y: 97 },
						{ x: new Date(2019, 10, 14), y: 86 },
						{ x: new Date(2020, 10, 15), y: 89 }
						]
					},
					{
						type: "line",
						showInLegend: true,
						name: "Hate Speech",
						lineDashType: "dash",
						yValueFormatString: "#,##0K",
						dataPoints: [
						{ x: new Date(2014, 1, 1), y: 10 },
						{ x: new Date(2014, 7, 2), y: 30 },
						{ x: new Date(2014, 10, 3), y: 20 },
						{ x: new Date(2015, 5, 4), y: 56 },
						{ x: new Date(2015, 7, 5), y: 54 },
						{ x: new Date(2015, 10, 6), y: 55 },
						{ x: new Date(2016, 5, 7), y: 54 },
						{ x: new Date(2016, 7, 8), y: 69 },
						{ x: new Date(2017, 8, 9), y: 65 },
						{ x: new Date(2017, 10, 10), y: 66 },
						{ x: new Date(2018, 7, 11), y: 63 },
						{ x: new Date(2018, 10, 12), y: 67 },
						{ x: new Date(2019, 5, 13), y: 66 },
						{ x: new Date(2019, 10, 14), y: 56 },
						{ x: new Date(2020, 10, 15), y: 64 }
						]
					}]
				};
				
				
				$("#chartContainer2").CanvasJSChart(options2);
				*/
				
				
				
			}
		</script>
	</head>
	<body>
		<div class="topnav" id="myTopnav">
			<a href="#home" class="active">Home</a>
			<a href="https://bit.bdu.edu.et/ict4d/">ICT4D</a>
			<a href="https://www.inf.uni-hamburg.de/en/inst/ab/lt/people/seid-muhie-yimam.html">LT</a>
			<a href="#about">About</a>
			
		</a>
	</div>
	
	
	
	<div class="container">
		
		<div class="row">
			<div class="col-sm-4">
				<h3>About the chart</h3>
				<p>
					<div id="chartContainer" style="height: 370px; max-width: 100%; margin: 0px auto;"></div>
					
				</p>
			</div>
			<div class="col-sm-4" style="background-color:#DCDCDC;">
				<h3>Check a fact</h3>
				<p>
					<nav class="navbar navbar-light bg-light">
						
						<form class="form-inline" action="index.php" method="post">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchkeyword" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0 btn-primary" type="submit" name="searchusingkeyword">Search</button>
						</form>
						
						<div>
						    					<table id="factCheckerTable" class="table table-theme table-row v-middle">
                <thead>
                    <tr>
                        <th class="text-muted">Sentence</th>
                    </tr>
                </thead>
                <tbody>
							<?php
								if(ISSET($_POST['searchusingkeyword'])){
		
		
		echo feachData();

	}
							?>
								</tbody>
            </table>
						</div>
					</nav>
				</p>
				<p></p>
			</div>
			<div class="col-sm-4">
				<h3>Daily Info</h3>        
				<p>
					<table id="dailyInfoTable" class="table table-theme table-row v-middle">
                <thead>
                    <tr>
                        <th class="text-muted">Sentence</th>
                        <th class="text-muted">Labble</th>
                    </tr>
                </thead>
                <tbody>
							<?php
							
		echo feachDailyData();
		
							?>
							</tbody>
            </table>
						<!--li class="list-group-item d-flex justify-content-between align-items-center">
							የትግራይ ክልል ዋና ሥራ አስፈጻሚ ዶ/ር ሙሉ ነጋ የስልጣን መልቀቂያ ደብዳቤ ለጠቅላይ ሚኒስትር ጽህፈት ቤት አስገብተዋል 
							<span class="badge badge-primary badge-pill">Fake</span>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							ትናንት ከሰአት በሗላ ጀምሮ በትግራይ ክልል አንዳንድ አካባቢዎች የስልክ አገልግሎት እንደገና ስለመቋረጡ የሚገልጹ መረጃዎች በማህበራዊ ሚዲያ ላይ ተሰራጭተዋል። 
							<span class="badge badge-primary badge-pill">Fact</span>
						</li>
						<li class="list-group-item d-flex justify-content-between align-items-center">
							some Hate speech 
							<span class="badge badge-primary badge-pill">Hate</span>
						</li-->
					</ul>  
				</p>
			</div>
		</div>
		<div style="height:150px">&nbsp;</div>
		<div>
			
			<div id="chartContainer2" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
			
		</div>
	</div>
	
	
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>  
	<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
	
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
	
</body>
</html>