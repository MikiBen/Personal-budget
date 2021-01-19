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
					echo '<a href="menu.php"> Return to the menu</a> </br></br>';
		
					echo "Income added:</br>";
					$category_incomes = $_POST['category_incomes'];
					$amount_income = $_POST['amount_income'];
					$income_coment = $_POST['income_coment'];
					$income_date = $_POST['date_income'];
					unset($_POST['category_incomes']);
					
					$result= $connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE id='$category_incomes'");
					if(!$result) throw new Exception($connection->error);
					
					$row=mysqli_fetch_array($result);
					$category_incomes_name = $row['name'];
					
					echo 'Amount: '.$amount_income.'</br>';
					echo 'Category: '.$category_incomes_name.'</br>';
					echo 'Coment: '.$income_coment.'</br>';
					echo 'Date: '.$income_date;
			
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

