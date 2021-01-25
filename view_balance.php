<?php
session_start();

if(!isset($_SESSION['logged'])&&(!isset($_SESSION['date_begin'])))
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
	
	<title> Bilans </title>
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
				<div class="container no-gutters col-12" >

						<header>		
								
									<h1> Personal budget</h1>

						</header>

							<div class="row mx-4">
						
<?php
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
							$date_begin = $_SESSION['date_begin'];
							$date_end = $_SESSION['date_end'];
							unset($_SESSION['date_begin']);
							unset($_SESSION['date_end']);
							
						$result = $connection->query ('SELECT  expenses_category_assigned_to_users.name, 
						payment_methods_assigned_to_users.name AS payment_name,
						expenses.amount, 
						expenses.date_of_expense,
						expenses.expense_comment 
						FROM expenses_category_assigned_to_users,
						payment_methods_assigned_to_users,
						expenses 
						WHERE expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id 
						AND expenses.payment_method_assigned_to_user_id=payment_methods_assigned_to_users.id 
						AND expenses.user_id='.$_SESSION["user_id"]);

					echo'<table class="col-12 col-xl-6 mt-4 offset-xl-1">';							
					echo'<tr><th colspan="5">Expeneses</th></tr>';
					echo'<tr><th class="WAmount">Amount</th><th class="WDate">Date</th><th >Payment methods</th><th >Category</th><th >Comment</th></tr>';

						$id=0;
						$sum_expenses = 0;
						while($row=mysqli_fetch_array($result))
						{
								$a1= $row['amount'];
								$a2= $row['date_of_expense'];
								$a3= $row['payment_name'];
								$a4= $row['name'];
								$a5= $row['expense_comment'];
								$id++;					
					
							if($a2>=$date_begin && $a2<= $date_end)
							{
											$sum_expenses = $sum_expenses + $a1;
											echo'<tr><td>'.$a1.'</td><td>'.$a2.'</td><td>'.$a3.'</td><td>'.$a4.' </td><td>'.$a5.' </td></tr>';
							}

						}
						echo'<tr><td colspan="5"></td></tr>';
						echo'<tr><th colspan="2">Sum incomes</th><th colspan="3">'.$sum_expenses.' PLN</th></tr>';
						echo'</table>';	
						
						
						//Przychody-------------------------------------------------
						
						$result = $connection->query ('SELECT  incomes_category_assigned_to_users.name, 
						incomes.amount, 
						incomes.date_of_income,
						incomes.income_comment 
						FROM incomes_category_assigned_to_users,
						incomes
						WHERE incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id 
						AND incomes.user_id='.$_SESSION["user_id"]);
						
						echo'<table  class="col-12 col-xl-5 mt-4 ">';							
						echo'<tr><th colspan="4" > Przychody </th></tr>';
						echo'<tr><th class="PAmount">Amount</th><th class="PDate">Date</th><th >Category</th><th >Comment</th></tr>';
						
						$id=0;
						$sum_incomes = 0;
						while($row=mysqli_fetch_array($result))
						{
								$a1= $row['amount'];
								$a2= $row['date_of_income'];
								$a3= $row['name'];
								$a4= $row['income_comment'];
								$id++;				
					
							if($a2>=$date_begin && $a2<= $date_end)
							{				
											$sum_incomes = $sum_incomes + $a1;
											echo'<tr><td>'.$a1.'</td><td>'.$a2.'</td><td>'.$a3.'</td><td>'.$a4.' </td></tr>';
							}
						}
						echo'<tr><td colspan="4"></td></tr>';
						echo'<tr><th colspan="2">Sum incomes</th><th colspan="2">'.$sum_incomes.' PLN</th></tr>';
						echo'</table>';
						
						
						
						echo'<div class="sum">';

						$balans_sum = 	$sum_incomes - $sum_expenses;				
						echo'Balance sheet: '.$balans_sum.' PLN';
											
						echo'		</div>';
						
						
						
						
					}
						$connection->close();
					}
			
			
					
catch(Exception$e)
{
echo "Problem z połączeniem </br>";
//echo "błędy  ".$e;
}
		?>						<div class="sum" color="blue">	
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

			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
							

</body>

</html>