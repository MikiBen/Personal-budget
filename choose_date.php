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


<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Budget - view balalcesheet </title>
</head>
	
	
<body>
	    <div class="container">
		
		<header>
            <h1>Choose period time for balance sheet</h1>
        </header>
		
		<main>
		
			<a href="view_balance_for_current_month.php"> Current month</a></br></br>
			<a href="view_balance_for_last_month.php"> Last month</a></br></br>
			
			
			
				<form method="post">
					<div class="row">
							
							<h3>Choose period time manualy for balance sheet</h3>
							<label> Begin date:	<input type="date" name="date_begin" required></label>
						</br></br>
					</div>
					
					
					<div class="row">
						<label> End date:	<input type="date" name="date_end"  required></label>
						</br></br>
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
			 </br><p><a href='menu.php'> Return to the menu</a></p>
		</main>
		
		</div>


</body>

</html>