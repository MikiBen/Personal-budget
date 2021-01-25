<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
	exit();
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
	<title> Menu główne </title>
	<meta name="description" content="Tworzenie aplikacji do zarządzania budżetem domowym ">
	<meta name="keywords" content="budżer, domowy, wydatko, wpływy">
	<meta name="author" content="Mikołaj Narloch">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="StronaBudzet.css">
	<link rel="stylesheet" href="bootstrap.min.css">
		
	<link rel="stylesheet" href="css/fontello.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body  >
		<main>
				
					
				<article>
						<div class="container">
							<header>

										<h1> Persolnal budget </h1></br>
	

							</header>
		
							<div class="row mt-5">	
							
											<div class=" col-lg-4 col-sm-6" > 
													
													<figure class="tile1">
																<a href="incomes.php" class="tilelink">
																<i class="icon-money" ></i><br/> Add income
																</a>	
														
													</figure>	
											</div>			
											
											<div class=" col-lg-4 col-sm-6 "> 
														<figure class="tile1">
																<a href="expenses.php" class="tilelink">
																<i class="icon-basket" ></i><br/> Add expense
																</a>	
														</figure>	
											</div>		
											
											<div class=" col-lg-4 col-sm-6 "> 
														<figure class="tile1">
																<a href="choose_date.php" class="tilelink">
																<i class="icon-archive" ></i><br/> View balance
																</a>	
														</figure>	
											</div>
											
											<div class="w-100"> </div>
											
											<div class="col-md-6 mt-3 " >
											
														<figure class="tile2">
																<a class="tilelink">
																<i class="icon-wrench" ></i><br/> Settings 
																</a>	
														</figure>	
											</div>
											<div class="col-md-6 mt-3" >
											
														<figure class="tile2">
																<a href="logout.php" class="tilelink">
																<i class="icon-logout" ></i><br/> Log out
																</a>	
														</figure>	
													
											</div>
											
									
									

							</div>
						
						</div>

			</article>
		</main>
						
						<footer>
						
							<div class="footer"> 2020 &copy;  Mikołaj Narloch -  Budżet domowy

							</div>
						</footer>
			

</body>

</html>