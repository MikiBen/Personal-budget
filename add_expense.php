<?php
session_start();

if(!isset($_POST['payment_methods']))
{
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
					echo '<a href="menu.php"> Return to the menu</a> </br></br>';
		
					echo "Expense added:</br>";
					$category_expenses = $_POST['category_expenses'];
					$payment_methods = $_POST['payment_methods'];
					unset($_POST['payment_methods']);
					$amount_expense = $_POST['amount_expense'];
					$expense_coment = $_POST['expense_coment'];
					
					$result= $connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE id='$category_expenses'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$category_expenses_name = $row['name'];
					
					//wyszukanie metody płatności
					$result= $connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE id='$payment_methods'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$payment_methods_name = $row['name'];
					
					echo 'Amount: '.$amount_expense.'</br>';
					echo 'Category: '.$category_expenses_name.'</br>';
					echo 'Payment methods: '.$payment_methods_name.'</br>';
					echo 'Coment: '.$expense_coment;
			
				$user_id=$_SESSION['user_id'];
				if($connection->query("INSERT INTO expenses VALUES (NULL, '$user_id', '$category_expenses', '$payment_methods','$amount_expense','2020-10-10','$expense_coment') "));
				
				
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

