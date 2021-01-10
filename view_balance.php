<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
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
				$result = $connection->query ('SELECT  expenses_category_assigned_to_users.name, payment_methods_assigned_to_users.name,expenses.amount, expenses.date_of_expense, expenses.expense_comment FROM expenses_category_assigned_to_users, payment_methods_assigned_to_users,expenses WHERE expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id AND expenses.payment_method_assigned_to_user_id=payment_methods_assigned_to_users.id AND expenses.user_id="31"');
				
				while($row=mysqli_fetch_array($result))
				{
					$a1= $row['amount'];
					$a2= $row['name'];
					$a3= $row['name'];
					$a4= $row['date_of_expense'];
					$a5= $row['expense_comment'];
					
					echo $a1." | ". $a2." | ". $a3." | ". $a4." | ". $a5."  </br>";

				}	
				
				

			}
	$connection->close();
}
catch(Exception$e)
{
	echo "Problem z połączeniem </br>";
	//echo "błędy  ".$e;
}
	
?>

