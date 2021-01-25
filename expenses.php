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
	<title>	Wydatki </title>
	<meta name="description" content="Tworzenie aplikacji do zarządzania budżetem domowym ">
	<meta name="keywords" content="budżer, domowy, wydatki, wpływy">
	<meta name="author" content="Mikołaj Narloch">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="StronaBudzet.css">
	<link rel="stylesheet" href="bootstrap.min.css">

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
									<h1> Personal budget</h1>	
						</header>
						
						<div class="row">
<?php
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
								
								echo '<form action="add_expense.php" method="post" encotype="multipart/form-data" class=" col-lg-10 offset-lg-1 offset-xl-2 col-md-12">';
								echo '	<div>';
								echo '		<label> Amount:  <input class="wydatek" type="number" name="amount_expense" placeholder="PLN" min="0" step=0.01 required></label>';
								echo '	</div>';
								
								echo '<div>';
								echo '<label> Date expense	<input class="wydatek" type="date" name="date_expense"  value='.date("Y-m-d").'></label>';
								echo '</div>';
								
								$result = $connection->query("SELECT * FROM payment_methods_assigned_to_users WHERE user_id='$user_id'");

								//if(!$result) throw new Exception($connection->error);
								
								echo'<fieldset class="radio" radio mb-4>';
								
									echo'<legend> Payment methods </legend>';
							
									while($row=mysqli_fetch_array($result))
										{
											$payment_methods= $row['name'];
											echo '<div ><label ><input type="radio" value='.$row["id"].' name="payment_methods" required>'.$payment_methods.' </label></div>';
							
										}	
														
								echo'</fieldset>';
								
								$result = $connection->query("SELECT * FROM expenses_category_assigned_to_users WHERE user_id='$user_id'");
								//if(!$result) throw new Exception($connection->error);
								
								echo'<fieldset class="radio"radio mb-4>';
								
									echo'<legend>Category </legend>';
							
									while($row=mysqli_fetch_array($result))
										{
											$category_expenses= $row['name'];
											echo '<div ><label ><input type="radio" value='.$row["id"]. ' name="category_expenses"  required>'.$category_expenses.' </label></div>';
							
										}	
														
								echo'</fieldset>';
								
								
								echo'	<fieldset>';	
								
								echo'		<legend> Comment</legend>';
								echo'	<div><label for="komentarz">';
								echo'		<textarea  name="expense_coment" id="komentarz" rows="4" cols="48" maxlength="40">  </textarea></label>  </div>';
								echo '</fieldset>';
								
								
								echo'<div class="row">';
								echo'<label class="col-6"><input class="button" type="submit" value="Add expense"></label>';
										
										
								echo' <label class="col-6" ><a  href="menu.php"><input class="button"  id="cancel" value="Cancel"></a></label>';
								echo'	</div>';	
								
								echo'</form>';
									
								}
$connection->close();
}
catch(Exception$e)
{
	echo "Problem z połączeniem </br>";
	//echo "błędy  ".$e;
}			
?>
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