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
		//$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
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

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title> Registration </title>
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

<body  >

		<main>
			<article>
				<div class="container">

						<header>
							
								
									<h1> Personal budget</h1>
								

						</header>
						
							<div class="row">

										<div class="window mx-auto">
										
												<form method="post">
														<label><input  type="text" placeholder="Login" name="nick"   required></label>
																		<?php
																			if(isset($_SESSION['e_login']))
																			{
																				echo '<div class="error">'.$_SESSION['e_login'].   '</div>';
																				unset($_SESSION['e_login']);
																			}
																		?>
														
														<label><input type="email"  placeholder="E-mail" name="email" required></label>
																			<?php
																				if(isset($_SESSION['e_email']))
																				{
																					echo '<div class="error">'.$_SESSION['e_email'].   '</div>';
																					unset($_SESSION['e_email']);
																				}
																			?>

														<label><input  type="password" placeholder="Password" name="password1" required></label>
																		<?php
																			if(isset($_SESSION['e_password']))
																			{
																				echo '<div class="error">'.$_SESSION['e_password'].   '</div>';
																				unset($_SESSION['e_password']);
																			}
																		?>

														<label><input  type="password" placeholder="Repeat password" name="password2" required></label>
														
														
																			
														<input  type="submit" value="Register">
													</form>
										</div>
										
									<div class="sum" color="blue">	
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