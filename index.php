<?php
session_start();

	if(isset($_SESSION['registration_OK']))
	{
		echo "You are sign up</br></br>";
		unset($_SESSION['registration_OK']);
	}
	
	if(isset($_SESSION['logged']))
	{
		header('Location:menu.php');
		exit();
	}
	
	
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Budzet </title>
</head>
	
	
<body>

	Budżet domowy
	</br></br>
	<a href="registration.php"> Rejestracji konta!</a>
	</br></br>
	
		<form action="log_in.php" method="post">
		
			Login: </br> <input type="text" name="login"/> </br>
			Password: </br> <input type="password" name="password"/> </br></br>
			<input type="submit" value="Log In"/>
			
<?php
	
		if(isset($_SESSION['error']))
		echo '</br></br>'.$_SESSION['error'];
	
?>

</body>

</html>