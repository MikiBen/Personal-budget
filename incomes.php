<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
	exit();
}
	
	
	echo '<a href="menu.php"> Return to the menu</a> </br></br>';
			$user_id=$_SESSION['user_id'];

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
			
					echo '<form action="add_income.php" method="post" encotype="multipart/form-data">';
						
						echo '<div class="row">';
									
						echo '<label> Amount:  <input type="number" name="amount_income" min="0" step=0.01></label>';
						echo '</div></br>';
						
			
			
			
					$result = $connection->query("SELECT * FROM incomes_category_assigned_to_users WHERE user_id='$user_id'");
					//if(!$result) throw new Exception($connection->error);
						
						
						
						
						
						echo '<div class="row">';
						echo '<fieldset>';
						echo '<legend> Incomes category </legend>';
						
						while($row=mysqli_fetch_array($result))
						{
							$category_incomes= $row['name'];
							
							echo '<label><input type="radio" value='.$row["id"].' name="category_incomes">'.$category_incomes.'</label></br>';
							
						}	
						echo '</fieldset>';
						echo '</div></br>';
						
						echo '<div class="row">';
						echo	'<div><label for="coment"> Coment for income</label></div>';
						echo '<textarea name="income_coment" rows="4" cols="80" maxlength="100"></textarea>';
						echo '</div></br>';
						
				
						
						echo '<div class="row">';
						echo '<input type="submit" value="Coment for income";>';
						echo '</div>';
						echo '</form>';	
	
			}
	$connection->close();
}
catch(Exception$e)
{
	echo "Problem z połączeniem </br>";
	//echo "błędy  ".$e;
}

?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Budzet - expenses </title>
</head>
	
	
<body>


</body>

</html>