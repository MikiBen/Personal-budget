<?php
session_start();

	if(isset($_SESSION['registration_OK']))
	{
		echo "You are sign up</br></br>";
		unset($_SESSION['registration_OK']);
	}
	
	if(isset($_SESSION['logged']))
	{
		header('Location:menu.php');
		exit();
	}
	
?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title> Logowanie </title>
	<meta name="description" content="Tworzenie aplikacji do zarządzania budżetem domowym ">
	<meta name="keywords" content="budżer, domowy, wydatko, wpływy">
	<meta name="author" content="Mikołaj Narloch">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="StronaBudzet.css">
	<link rel="stylesheet" href="bootstrap.min.css">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body >

		<main>
			<article>
				<div class="container">

						<header>		
								
									<h1> Personal budget</h1>

						</header>

							<div class="row">
						
										<div class="window mx-auto">		
	
											<form action="log_in.php" method="post">	
												<label><input  type="text" placeholder="Login" name="login"    required></label>
												
												<label><input type="password" placeholder="Password" name="password" required></label>
																						
												<input type="submit" value="Log in">
											</form>
										</div>
										
							<div class="sum" margin-top="10px" >
								
										</br>
											<a> 
												<?php
														if(isset($_SESSION['error']))
														echo '</br></br>'.$_SESSION['error'];
														unset($_SESSION['error']);
												?>
											
											</a>

								</div>

							
							</div>
						

								<div class="sum" color="blue">	
								<p><a href="registration.php"> Registration account</a></p>
								</div>
								
								
								

								
								
								

				
						
						</div>

				</article>
		</main>
						
		<footer>
						
					<div class="footer"> 2020 &copy;  Mikołaj Narloch -  Budżet domowy

					</div>
		</footer>

			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
							

</body>

</html>