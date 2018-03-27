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
					<img src="../assets/images/csbl.png" width="90" alt="" style="float: right;">
					<img src="../assets/images/lib.png" width="120" alt="" style="float: right;">					
				</div>				
			</nav>

			<div id="slide">
				<h1>Tutorial</h1>
			</div>
			<div id="baseButtons">
				<?php include "buttons.php" ?>
			</div>
			<div id="forms">
				<form >
					<h3>Run (All genes)</h3>
					<p>To run the MDP, you must supply <a href="javascript:;">expression data</a> and <a href="javascript:;">phenotypic data</a>. The expression data is a tab-delimited text table that contains an initial column named "Symbol" with  the rows containing unique gene annotation, and other columns containing gene expression data and sample names in the header.</p>
					<p style="text-align: center;"><img src="../assets/images/expressiondata.png" width="100%" alt=""></p>
					<p style="text-align: center;"><img src="../assets/images/phenodata.png" width="100%" alt=""></p>
					<p>The phenotypic information is also a tab-delimited text table that contains at least two columns. The “Sample” column contains sample IDs and the “Class” column contains the phenotypic information used by the MDP.  Other columns can be provided that contain additional phenotypic information.</p>
					<p>Once the data are uploaded,you can <a href="javascript:;">select the parameter</a> that corresponds to the control class.</p>
					<p>There are some <a href="javascript:;">optional parameters</a> that you can select that will affect how the sample scores are calculated. You can select the <a href="javascript:;">statistics average method</a>, which is the method (median or mean) that will be used to compute the average value of each of the control genes.</p>
					<p>You can also choose the <a href="javascript:;">standard deviation</a> threshold, which controls the threshold at which the normalized gene expression scores are set to zero.</p>
					<p>You can also change the percentage of genes that will contribute to sample scores. Genes are ranked in accordance to their average normalized expression scores in the test classes relative to the controls. You can decide what <a href="javascript:;">top percentage</a> of these perturbed genes will be used to compute the sample scores.</p>

					<h3>Run (Pathways)</h3>
					<p>If you want to use gene sets to calculate the sample scores, select <img src="../assets/images/print1.png" alt=""> along the top panel of the page, which will allow you to upload a pathways gmt file. This is a .gmt format file where gene sets are arranged across the rows. The first column contains the pathway name, the second column contains a shorter description or a dummy field ("NA"), and the remainder of each row contains the gene symbols in that pathway. Rows can have unequal length. See link <a href="https://software.broadinstitute.org/cancer/software/gsea/wiki/index.php/Data_formats#GMT:_Gene_Matrix_Transposed_file_format_.28.2A.gmt.29 for more information." target="_blank">here</a>.</p>
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