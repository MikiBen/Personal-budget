<?php
	session_start();
	
	if((!isset($_POST['login'])) || (!isset($_POST['password'])) )
	{
		header('Location:index.php');
		exit();
	}
	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	$login = $_POST['login'];
	$password = $_POST['password'];

try
{
	
	$connection = new mysqli($host, $db_user,$db_password,$db_name);

	if($connection ->connect_errno!=0) // nie udane logowanie
	{
		throw new Exception(mysqli_connect_errno());
	}
	else
	{
		/*
		$sql = "SELECT * FROM uzytkownicy WHERE Login='$login' AND Haslo='$haslo'";
		$rezultat = $polaczenie->query($sql);
		$wiersz = $rezultat->fetch_assoc();
		$_SESSION['login'] =$wiersz['Login'];
		echo $_SESSION['login'];
		echo $_SESSION['login'];
		echo $_SESSION['login'];
		*/
		$sql = "SELECT * FROM users WHERE username='$login' AND password='$password'";
		$result = $connection->query($sql);
		
		if(!$result)
			throw new Exception($connection->error);
		else
		{
			$number_user=$result->num_rows;
				
				if($number_user==1)
				{
					//$result= $connection->query($sql);
					$record = $result->fetch_assoc();
				
					echo "zalogowałeś sie";
					$_SESSION['logged']  = true;
					$_SESSION['login'] =$record ['username'];
					$_SESSION['email'] =$record ['email'];
					$_SESSION['user_id'] =$record ['id'];
					
					unset($_SESSION['error']);
					$result->close();
					
					
					header('Location:menu.php');
				}
				else
				{
					$_SESSION['error'] = '<span style ="color:red"> Nieprawidłowy login lub hasło</span>';
					header('Location:index.php');
				}
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