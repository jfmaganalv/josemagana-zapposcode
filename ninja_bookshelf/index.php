<?php

	//Unsorted books array
	$books = array("The Silent Killer", "JQuery Ninja", "The Ninja Next Door", "Master of Disguise", "Skills of Discipline", "The Night Stalker", "One Man Army", "Man in Black", "One Man, Two Lives", "The Unarmed Assassin", "The Katana", "Ninjutsu");
	
?>
<!doctype html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<meta charset="utf-8">
	
		<title>Zappos.code() Application | Ninja Bookshelf</title>
		
		<meta name="description" content="">
		<meta name="author" content="Jose Magana">

		<link rel="shortcut icon" href="../_/img/favicon.ico">
		<link rel="stylesheet" href="_/css/style.css">
		
	</head>
	<body>
	<div id="header-wrap">
		<header class="clearfix">
			<nav>
				<p><a href="../index.html" title="Application Home">Home</a></p>
			</nav>
			<img src="_/img/project-num.jpg" alt="Project Number 2">
			<h1>Ninja Bookshelf</h1>
			<h2>PHP powered sorted and unsorted ninja book titles</h2>
					
		</header>		
	</div><!-- End header-stripe -->
	<div id="wrapper">
				<div class="content clearfix">
			<div class="list-col">
				<div class="unsorted-books">
					<h3>Unsorted Ninja Book Titles</h3>
					<ol>
					<?php 
					
						foreach($books as $unsorted_title){
							echo "
								<li>{$unsorted_title}</li>
							" ;
						}
					?>
					</ol>
				</div>			
			</div><!-- End left-col -->
			<div class="book-col">
				<?php 
					if(isset($_POST['Sort']) || !isset($_POST['Sort']) && !isset($_POST['Unsort'])){
						$value = "Unsort";
					}
					if(isset($_POST['Unsort'])){
						$value = "Sort";
					}	
					$class = strtolower($value);
				?>
				<form method="post" action="index.php">
					<?php echo "<input class=\"{$class}\" type=\"submit\" value=\"{$value}\" name=\"{$value}\" "; ?> />
				</form>
				<h3>Sorted Ninja Book Titles</h3>
				<div class="bookshelf clearfix">
					<?php 
						
						if(isset($_POST['Sort']) || !isset($_POST['Sort']) && !isset($_POST['Unsort'])){
							sort($books);
							foreach($books as $sorted_title){
								echo "
									<div class=\"book\">
										<p>{$sorted_title}</p>
									</div>
								" ;
							}
						}else{
							foreach($books as $sorted_title){
								echo "
									<div class=\"book\">
										<p>{$sorted_title}</p>
									</div>
								" ;
							}
						}	
					?>
				</div><!-- End bookshelf -->
			</div><!-- End right-col -->
		</div><!-- End content -->
	</div><!-- End wrapper -->
	<div id="footer-wrap">
		<footer>
			<p><small>Zappos.code() Application -- Project #2: Ninja Bookshelf -- Jose Magana</small></p>
		</footer>
	</div>
	</body>
</html>