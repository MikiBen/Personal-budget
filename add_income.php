<?php
session_start();

if(!isset($_POST['category_incomes']))
{
	header('Location:menu.php');
	exit();
}

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
		try 
		{
			$connection = new mysqli($host, $db_user , $db_password, $db_name);
				if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno()); //rzuć nowym wyjątkiem
			}
			else
			{	

					$category_incomes = $_POST['category_incomes'];
					$amount_income = $_POST['amount_income'];
					$income_coment = $_POST['income_coment'];
					$income_date = $_POST['date_income'];
					unset($_POST['category_incomes']);
					
					$result= $connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE id='$category_incomes'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$category_incomes_name = $row['name'];
					
echo<<<END

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title> Rejestracja </title>
	<meta name="description" content="Tworzenie aplikacji do zarządzania budżetem domowym ">
	<meta name="keywords" content="budżer, domowy, wydatko, wpływy">
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
							
								
									<h1> Income added:</h1>
									
								

						</header>
						
						<div class="row"  >
						
							<div class="sum"  >

END;

						
								
							echo 'Amount: '.$amount_income.'</br>';
							echo 'Category: '.$category_incomes_name.'</br>';
							echo 'Coment: '.$income_coment.'</br>';
							echo 'Date: '.$income_date;
							
echo<<<END
							</div>
							
								<div class="sum" color="blue">	
									</br><p><a href='menu.php'> Return to the menu</a></p>
								</div>	
					
						</div>
						
						</div>

					
				</article>
		</main>

						
		<footer>
						
					<div class="footer"> 2020 &copy;  Mikołaj Narloch -  Budżet domowy

					</div>
		</footer>
	
END;
			
				$user_id=$_SESSION['user_id'];
				if($connection->query("INSERT INTO incomes VALUES (NULL, '$user_id', '$category_incomes','$amount_income','$income_date','$income_coment') "));
				
				
			}
			$connection->close();
		}
	

			catch(Exception$e)
			{
				echo "Error with connection </br>";
				//echo "błędy  ".$e;
			}	
			
	
	
?>

