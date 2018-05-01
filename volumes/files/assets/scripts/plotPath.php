<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>MDP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,400i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="../css/global.css">
</head>
<body>
	<div id="main">
	<div class="container">
		<div id="base">
			<nav class="navbar navbar-expand-lg navbar-light bg-white">
				<a class="navbar-brand" href="#"><img src="../images/mdp.png" width="120" alt=""></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa fa-th-list" aria-hidden="true"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<?php include "../../pages/navbar.php" ?>								      
					</ul>
				</div>

				<div class="groups">
					<img src="../images/csbl.png" width="90" alt="" style="float: right;">
					<img src="../images/lib.png" width="120" alt="" style="float: right;">					
				</div>				
			</nav>

			<div id="slide">
				<h1>Results</h1>
			</div>
			<div id="baseButtons">
				<?php include "../../pages/buttons.php" ?>
			</div>
			<div id="forms">
				<?php

					$DEBUG = 0;

					$backR = "run_mdp.R" ;
					
					$expressionDataFile = "edata.tsv" ;
					
					$phenotypicDataFile = "pdata.tsv" ;

					$gmtDataFile = "pathways.gmt" ;
					
					$parameter = $_REQUEST['class'];

					$parameter2 = $_REQUEST['class2'];
					
					$statisticsAverage = strtolower($_REQUEST['stats']);
					
					$standartDeviation = $_REQUEST['stan'];
					
					$topPertubedGenes = $_REQUEST['average'];

					$topPertubedGenes = $_REQUEST['average'];

					$topPertubedGenes = $_REQUEST['average'];
					
					$dataDir = "../../data/";
					$execDir = $dataDir . $_REQUEST['exec'];


					// R need variable HOME defined for user www-data
					putenv("HOME=/tmp");
					
					exec("Rscript " . $backR . " " . $expressionDataFile . " " . $phenotypicDataFile . " " . $parameter . " " . $statisticsAverage . " " . $standartDeviation . " " . $topPertubedGenes . " " . $execDir . " " . $gmtDataFile . " " . $parameter2);

					if ($DEBUG) {

						echo "Rscript " . $backR . " " . $expressionDataFile . " " . $phenotypicDataFile . " " . $parameter . " " . $statisticsAverage . " " . $standartDeviation . " " . $topPertubedGenes . " " . $execDir . " " . $gmtDataFile . " " . $parameter2 . "<br><br>";

						echo "Parameter: " . $parameter . "<br>";
						echo "Parameter2: " . $parameter2 . "<br>";
						echo "StatisticsAverage: " . $statisticsAverage . "<br>";
						echo "StandartDeviation: " . $standartDeviation . "<br>";
						echo "TopPertubedGenes: " . $topPertubedGenes . "<br>";
					}

					//include ($execDir . "/plot1.html");

					//include ($execDir . "/plot2.html");

					//include ($execDir . "/plot3.html");

					//include ($execDir . "/plot4.html");


				?>

				<a href="<?php echo $execDir; ?>/MDP_scores.tsv" download><button class="btn btn-primary" style="margin-bottom: 30px;">Download result data</button></a>

				<iframe class="iframe" src="<?php echo $execDir; ?>/plot1.html" width="100%" frameborder="none" style="border-radius: 8px 8px 0 0"></iframe>
				<iframe class="iframe" src="<?php echo $execDir; ?>/plot2.html" width="100%" frameborder="none" style="margin-top:-5px; border-radius:0 0 8px 8px"></iframe>
				<?php ?>

			</div>

		</div>
	</div>
	</div>
	<div class="container">
		<div class="footer">
			<?php include "../../pages/footer.php" ?>
		</div>
	</div>	
</body>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../js/jquery.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="../js/global.js"></script>

</html>
