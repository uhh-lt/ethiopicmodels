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
			<h2 class="mb-4">About Us</h2>
			<p>Who are we?</p>
			<p>About US</p>
			<p>Contact US</p>
		</div>
	</div>
	
	<?php 
		include("scripts.php");
	?>
	
</body></html>