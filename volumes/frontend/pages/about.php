<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>MDP</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,400i,700,700i" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/global.css">
</head>
<body>
	<div id="main">
	<div class="container">
		<div id="base">
			<nav class="navbar navbar-expand-lg navbar-light bg-white">
				<a class="navbar-brand" href="#"><img src="../assets/images/mdp.png" width="120" alt=""></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa fa-th-list" aria-hidden="true"></i>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<?php include "navbar.php" ?>										      
					</ul>
				</div>

				<div class="groups">
					<img src="../assets/images/lib.png" width="120" alt="" style="float: right;">	
					<img src="../assets/images/csbl.png" width="90" alt="" style="float: right;">			
				</div>				
			</nav>

			<div id="slide">
				<h1>About</h1>
			</div>
			<div id="baseButtons">
				<?php include "buttons.php" ?>
			</div>
			<div id="forms">
					
				<form>
					<p>The <a href="javascript:;">M</a>olecular <a href="javascript:;">D</a>egree of <a href="javascript:;">P</a>erturbation webtool quantifies the heterogeneity of samples within a group using transcriptome data. It takes data containing at least two classes (control and test) and assigns a score to all samples based on how perturbed they are compared to the controls. Perturbation can be an infection, drug treatment, siRNA silencing, vaccination, and any type of disease. The MDP analysis is useful for gene expression data, as well as proteomic and metabolomic data, that have control and test samples in the same dataset. The more control and test samples that you have (ideally at least 10), the more accurate the calculation sample scores.</p>

					<div class="row">
						<div class="col-lg-2">
							<img src="../assets/images/MDP_scheme_v3.png" height="235" alt="">
						</div>
						<div class="col-lg-10">
							<h3>The MDP works as follows:</h3>
							<p>
							<a href="javascript:;">Step 1:</a>
							The median and standard deviation of the
							genes from the control samples are calculated.
							</p>
							<p>
							<a href="javascript:;">Step 2:</a>
							The median and standard deviation values
							are used to perform a Z-score normalization of all
							genes.
							</p>
							<p>
							<a href="javascript:;">Step 3:</a>
							The absolute value of these expression
							values are taken, and values less than 2 are set to 0.
							The values that remain represent significant
							deviations from the healthy samples.
							<p>
							<a href="javascript:;">Step 4:</a> The scores for each sample are calculated by
							finding the average of the normalized gene values
							for each sample, using either a) all genes, b)
							perturbed genes and c) optionally supplied gene
							sets.
							</p>

							<p>We define &quot;perturbed genes&quot; as the top 25% genes
							that have the greatest difference in average
							normalized expression value between the case
							samples versus the controls. MDP score can also be</p>
						</div>
					</div>

					<h3>What files do I need to provide?</h3>
					<p>
					You need to provide expression data, a file containing the phenotypic information, and an optional .gmt file if you want run the MDP on different gene sets. <a href="tutorial">See the tutorial</a> for more information.
					</p>

					<h3>Additional details</h3>
					<p>
						The design of the algorithm is based on the Molecular Distance to Health which was first described by <a href="https://genomebiology.biomedcentral.com/articles/10.1186/gb-2009-10-11-r127" target="_blank">Pankla et al. 2009</a>. The MDP, by comparison, does not discretize the Z-score normalised gene scores. We also allow you to use the median rather than mean to compute the gene average, so that the gene average is less sensitive to outliers. You can also select the standard deviation threshold.
					</p>
					<p>The MDP utilizes the ggplot2 R package - <a href="https://CRAN.R-project.org/package=ggplot2" target="_blank">https://CRAN.R-project.org/package=ggplot2</a></p>											
				</form>
			</div>
		</div>
	</div>
	</div>
	<div class="container">
		<div class="footer">
			<?php include "footer.php" ?>
		</div>
	</div>	
</body>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../assets/js/jquery.js"></script>
	<script src="../assets/js/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script src="../assets/js/global.js"></script>

</html>