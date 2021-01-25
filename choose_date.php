<?php
session_start();
unset($_SESSION['wrong_date']);

if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
	exit();
}
	if (isset($_POST['date_begin']) && isset($_POST['date_end']) )
	{

		
		if($_POST['date_begin']<=$_POST['date_end'])
		{
			$_SESSION['date_begin'] =$_POST['date_begin'];
			$_SESSION['date_end'] = $_POST['date_end'];
			header('Location:view_balance.php');
			exit();
		}
		else
		{
			$_SESSION['wrong_date'] = "You choose wrong period of time";
		}

	}

?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Budget - choose date </title>
	<meta name="description" content="Tworzenie aplikacji do zarządzania budżetem domowym ">
	<meta name="keywords" content="budżer, domowy, wydatki, wpływy">
	<meta name="author" content="Mikołaj Narloch">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="StronaBudzet.css">
	<link rel="stylesheet" href="bootstrap.min.css">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">

</head>

	
<body  >

	<main>
			
			<article>
				<div class="container">
				
						<header>		
								
									<h1>Choose period time for balance sheet</h1>

						</header>
            
					<div class="row">
		
		
					
						<a href="view_balance_for_current_month.php"> Current month</a>
						</br></br>
				</div>
						<div class="row">
						<a href="view_balance_for_last_month.php"> Last month</a></br></br>
			
					</div>
			
				<form method="post">
					<div class="row">
					
									<div >
									<label> Date income <input class="przychod" type="date" name="date_begin" required></label>
									</div></br></br>
									
									<div >
									<label> Date income <input class="przychod" type="date" name="date_end" required></label>
									</div></br></br>
					</div>
										
					<?php
						if(isset($_SESSION['wrong_date']))
						{
							echo '<div class="error">'.$_SESSION["wrong_date"]. '</div>';
							unset($_SESSION['wrong_date']);
						}
					?>
					
					<input type="submit" value="Accept date">

					
				</form>	
			 <div class="sum" color="blue">	
									</br><p><a href='menu.php'> Return to the menu</a></p>
									</div>	
		</main>
		
		</div>


</body>

</html>