<?php
session_start();

if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
	exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Budzet - Menu </title>
</head>
	
	
<body>


			
<?php
			
			echo "<p>Witaj<b>  ".$_SESSION['login']."</b></br></p>";
			echo "<p>E-mail: ".$_SESSION['email']."</br></p>";
			echo "<p><a href='expenses.php'> Add expenses </a></p>";
			echo "<p><a href='incomes.php'> Add income</a></p>";
			echo "<p><a href='choose_date.php'> View balance sheet </a></p>";
			echo "<p><a href='kategorie.php'> Ustawienia kategorii - opcja jeszcze nie dostępna</a></p>";
			echo "<p><a href='ustawienia.php'> Ustawienia konta - opcja jeszcze nie dostępna</a></p>";
			echo "<p><a href='logout.php'> Logout</a></p>"; 
	
?>

</body>

</html>