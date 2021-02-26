<?php
	include("header.php");
?>
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
			<h2 class="mb-4">Home</h2>
			<p>
			   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-50" src="https://ltdemos.informatik.uni-hamburg.de/amsol/static/dailyhate.png" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Daily Hate</h5>
    <p>Daily Hate </p>
    </div>
    <div class="carousel-item">
      <img class="d-block w-50" src="https://ltdemos.informatik.uni-hamburg.de/amsol/static/dailyfake.png" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Daily Fake</h5>
    <p>Daily Fake </p>
    </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-50" src="https://ltdemos.informatik.uni-hamburg.de/amsol/static/dailytweet.png" alt="Third slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Daily Tweet</h5>
    <p>Daily Tweet </p>
    </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-50" src="https://ltdemos.informatik.uni-hamburg.de/amsol/static/dailynews.png" alt="Third slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Daily News</h5>
    <p>Daily News </p>
    </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
			</p>
			<p>
			<h4>How the tool works</h4>
			<ol>
					<li>  Allow users to search for supporting arguments using an underlying database (news collection) 	<a href="checkfact.php">Check a Fact</a>
					</li>
			    <li>
			        "Indicate" a Tweet is hate speech based on selected keywords 	<a href="dailyinfo.php">Daily Info</a>
			    </li>
			    <li>
			        "Indicate" a tweet is fake if it is not covered in our news article collection 	<a href="dailyinfo.php">Daily Info</a>
			    </li>
			    <li>
			        Provide daily information of such categories (fact, fake, hate) 	<a href="dailyinfo.php">Daily Info</a>
			    </li>
			    <li>
			        A graph showing the hate speech distribution over several years <a href="yearlygrowth.php">Yearly Growth</a>
			    </li>
			    <li>
			        A chart showing the distribution of "hate, fact, and fake" tweets from 2020 onwards. 	<a href="chartreport.php">Chart Report</a>
			    </li>
			</ol>
 </p>
<p>
<h4>Future plan of the tool</h4>
<ol>
    <li>
Collect more data to build better "AI" components for the classification
</li>
<li>
Improve the tool so that it can be used by data journalists to analyze and report their findings
</li>
<li>
Build a browser plugin that automatically detects disinformation and abusive texts for users
</li>
</ol>
</p>
		</div>
	</div>
		<?php
		include("scripts.php");
	?>

</body></html>
