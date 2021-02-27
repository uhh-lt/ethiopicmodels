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
			ICT4D in collaboration with natural language processing experts from the Language Technology group at the University of Hamburg and mobile and web applications from ShegerApps join efforts in the development of this tool, "AmharicFactChek", to help society fight against hate speech and disinformation.
			<h3>Who are we?</h3>
			<p><strong>ICT4D Team</strong>: Information communication technology for development (ICT4D) research center is one of the research centers in Bahir Dar institute of Technology, Bahir Dar University. The aim of the center is to foster the development of the nation by conducting research and developing ICT related projects.</p>
			<p><strong>Dr. Seid Muhie Yimam</strong>: He is a language technology expert from the LT group, University of Hamburg. He has been working on adaptive machine learning integration on the application, research on low-resource language, and social media analysis. He is responsible for the data processing and API endpoint development for the AmharicFactChek.</p>
			<p><strong>Samuel Minal</strong>: Is an expert from the ShegerApps, who is responsible for the development of the front end applications of AmharicFactChek</p>
			<h3>Contact us </h3>
			<p>ICT4D>: ict4dbit at gmail.com OR           ict4dbit at bdu.edu.et </p>
			<p> Seid Muhie Yimam: yimam at informatik.un-hamburg.debug </p>
			<p> Samuel Minal: samuel.minale at gmail.com </p>
		</div>
	</div>

	<?php
		include("scripts.php");
	?>

</body></html>
