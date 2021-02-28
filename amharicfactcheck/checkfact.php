<?php
	include("header.php");
?>

<?php
    function feachData()
    {
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

        $server_output = curl_exec($ch);

        //echo $server_output . " " . $url;
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!$status  || !($status == 201 || $status == 200)) {
            /*print("Error: call to URL $url failed with status $status, response $server_output, curl_error " . curl_error($ch) . ", curl_errno " . curl_errno($ch));*/
            echo "Error";
			} else {
            $decoded = json_decode($server_output, true);



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

            curl_close($ch);

            return $output;
		}
	}
?>



<script type="text/javascript">

	window.onload = function() {

		//chartData();

		//lineChartData();

		$('#dailyInfoTable').DataTable( {
    "order": []
} );

		//$('#factCheckerTable').DataTable();
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
			<h2 class="mb-4">Check a fact</h2>
			<p class="text-body">
				<kbd> Check a fact </kbd> allows users to check a given fact, using news corpus as supporting documents or a database of facts. It is purely based on <kbd>query matching</kbd>. Employing an <kbd>AI</kbd> component is in the planning.
			</p>
			<p>
				<nav class="navbar navbar-light bg-light">

					<form class="form-inline" action="checkfact.php" method="post">
						<input class="form-control mr-sm-2" type="search" placeholder="search" name="searchkeyword" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0 btn-primary" type="submit" name="searchusingkeyword">Search a fact</button> (You can search in any language, results are in Amharic!)
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
							if (isset($_POST['searchusingkeyword'])) {
								echo feachData();
							}
						?>
					</tbody>
				</table>
			</p>
		</div>
	</div>

	<?php
		include("scripts.php");
	?>
</body></html>
