<?php
session_start();

	if (isset($_POST['email'])) 
	{
		$registration_OK = true;
		$login = $_POST['nick'];
		if ((strlen($login)<3) || (strlen($login)>20))
		{
			$registration_OK = false;
			$_SESSION['e_login'] = "Login musi posiadać od 3 do 20 znaków";
		}
		if (ctype_alnum($login)==false)
		{
			$registration_OK  = false;
			$_SESSION['e_login'] = "Nick musi posiadać tylko znaki alfanumeryczne";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
				$registration_OK = false;
				$_SESSION['e_email'] = "Podaj poprawny adres email";
		}
		
		
		$password1=$_POST['password1'];
		$password2=$_POST['password2'];
		
		if ((strlen($password1)<8) || (strlen($password1)>20))
		{
			$registration_OK= false;
			$_SESSION['e_password'] = "Nie poprawna długość hasła. Hasło musi posiadać od 8 do 20 znaków";
		}
		if ($password1!=$password2)
		{
			$registration_OK = false;
			$_SESSION['e_password'] = "Hasła muszą być identyczne";
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
				$result = $connection->query("SELECT id FROM users WHERE Email ='$email'");
					
					if(!$result) throw new Exception($connection->error);
				
					$number_emails = $result->num_rows; //ilość wierszy
					
					if($number_emails>0)
					{
					$registration_OK = false;
					$_SESSION['e_email'] = "Taki Email już istnieje";
					}
					
					$result = $connection->query("SELECT id FROM users WHERE username ='$login'");
					
					if(!$result) throw new Exception($connection->error);
				
					$number_user = $result->num_rows; //ilość wierszy
					
					if($number_user>0)
					{
					$registration_OK = false;
					$_SESSION['e_login'] = "Taki login już istnieje";
					}
					
					if($registration_OK==true)
				{
					if($connection->query("INSERT INTO users VALUES (NULL, '$login', '$password1', '$email')"))
					{
							$_SESSION['registration_OK']=true;
							
							$result= $connection->query("SELECT id FROM users WHERE username='$login'");
							if(!$result) throw new Exception($connection->error);
							
							$row=mysqli_fetch_array($result);
							$user_id = $row['id'];	
							
							//przypisanie kategorii domyślnych dla przychodów
							$result = $connection->query("SELECT name FROM incomes_category_default");
							if(!$result) throw new Exception($connection->error);
							while($row=mysqli_fetch_array($result))
							{
									$category= $row['name'];
									$connection->query("INSERT INTO incomes_category_assigned_to_users VALUES(NULL,'$user_id','$category')");
									if(!$result) throw new Exception($connection->error);
							}
							
							//przypisanie kategorii domyślnych dla wydatków
							$result = $connection->query("SELECT name FROM expenses_category_default");
							if(!$result) throw new Exception($connection->error);
							while($row=mysqli_fetch_array($result))
							{
									$category= $row['name'];
									$connection->query("INSERT INTO expenses_category_assigned_to_users VALUES(NULL,'$user_id','$category')");
									if(!$result) throw new Exception($connection->error);
							}
							
							
							//przypisanie kategorii domyślnych dla płatności
							$result = $connection->query("SELECT name FROM payment_methods_default");
							if(!$result) throw new Exception($connection->error);
							while($row=mysqli_fetch_array($result))
							{
									$category= $row['name'];
									$connection->query("INSERT INTO payment_methods_assigned_to_users VALUES(NULL,'$user_id','$category')");
									if(!$result) throw new Exception($connection->error);
							}			
							

							header('Location:index.php');
					}
					else
					{
					throw new Exception($connection->error);
					}
					
				}
				$connection->close();

			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;"> Błąd serwera! Przepraszamy za niedogności i prosimy o rejestrację w innym terminie </span>';
			echo  '</br> Informacja deweloperska'.$e;
		}
		
	}

?>


<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Budzet - rejestracja</title>
	
		 <style>
		.error
		{
			color:red;
			margin-top:10px;
			margin-bottom:10px;
		}
	 
	 </style>
	 
</head>
	
	
<body>

		<form method="post">
		
			Login: </br> <input type="text" name="nick"/> </br>
				<?php
					if(isset($_SESSION['e_login']))
					{
						echo '<div class="error">'.$_SESSION['e_login'].   '</div>';
						unset($_SESSION['e_login']);
					}
				?>
			Email: </br> <input type="text" name="email"/> </br>
				<?php
					if(isset($_SESSION['e_email']))
					{
						echo '<div class="error">'.$_SESSION['e_email'].   '</div>';
						unset($_SESSION['e_email']);
					}
				?>
			Haslo: </br> <input type="password" name="password1"/> </br>
				<?php
					if(isset($_SESSION['e_password']))
					{
						echo '<div class="error">'.$_SESSION['e_password'].   '</div>';
						unset($_SESSION['e_password']);
					}
				?>
			Powtórz hasło: </br> <input type="password" name="password2"/> </br></br>
			<input type="submit" value="Register">
		
		</form>

</body>

</html>