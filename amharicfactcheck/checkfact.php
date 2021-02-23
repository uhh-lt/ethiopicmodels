<!DOCTYPE html>

<?php
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
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>amharicfactcheck</title>

			<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="lib/sidebar/css" rel="stylesheet">
	<link rel="stylesheet" href="lib/sidebar/font-awesome.min.css">
	<link rel="stylesheet" href="lib/sidebar/style.css">
			<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
		


<script type="text/javascript">
    		
			window.onload = function() {
			    
			    //chartData();
			    
			    //lineChartData();
	
	            $('#dailyInfoTable').DataTable();

	            //$('#factCheckerTable').DataTable();
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
					<li class="active">
						<a href="checkfact.php">Check a Fact</a>
					</li>
					<li>
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
			<h2 class="mb-4">Check a Fact</h2>
			<p class="text-body">
			    Check fact allows users to check a given fact, using news corpus as supporting documents. It is purely based on <kbd>query matching</kbd> and an <kbd>AI</kbd> component is in the planning.
			</p>
			<p>
			    					<nav class="navbar navbar-light bg-light">

			    <form class="form-inline" action="checkfact.php" method="post">
							<input class="form-control mr-sm-2" type="search" placeholder="Search" name="searchkeyword" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0 btn-primary" type="submit" name="searchusingkeyword">Search a fact</button>
						</form>
						</nav>
			    <table id="dailyInfoTable" class="table table-theme table-row v-middle">
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
			</p>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="lib/sidebar/popper.js.download"></script>
	<script src="lib/sidebar/bootstrap.min.js.download"></script>
	<script src="lib/sidebar/main.js.download"></script>
	<script defer="" src="lib/sidebar/beacon.min.js.download"></script>
	
		
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
	
</body></html>