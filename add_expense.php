<?php
session_start();

if(!isset($_POST['payment_methods']))
	
{
	//echo "sss";
	header('Location:menu.php');
	exit();
}

else{
		
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
					
		
					
					$category_expenses = $_POST['category_expenses'];
					$payment_methods = $_POST['payment_methods'];
					unset($_POST['payment_methods']);
					$amount_expense = $_POST['amount_expense'];
					$expense_coment = $_POST['expense_coment'];
					$expense_date = $_POST['date_expense'];
					
					$result= $connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$category_expenses'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$category_expenses_name = $row['name'];
					
					//wyszukanie metody płatności
					$result= $connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE id='$payment_methods'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$payment_methods_name = $row['name'];
					
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
							
								
									<h1> Expense added:</h1>
									
								

						</header>
						
						<div class="row"  >
						
							<div class="sum"  >

END;
						
								
								echo 'Amount:  '.$amount_expense.' PLN </br>';
				                echo 'Category: '.$category_expenses_name.'</br>';
					            echo 'Payment methods: '.$payment_methods_name.'</br>';
								echo 'Comment: '.$expense_coment.'</br>';
								echo 'Date: '. $expense_date;
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
				if($connection->query("INSERT INTO expenses VALUES (NULL, '$user_id', '$category_expenses', '$payment_methods','$amount_expense','$expense_date','$expense_coment') "));
				
				
			}
			$connection->close();
		}
	

			catch(Exception$e)
			{
				echo "Problem z połączeniem </br>";
				//echo "błędy  ".$e;
			}	
			
}
	
?>



