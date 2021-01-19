<?php
session_start();

if(!isset($_SESSION['logged'])&&(!isset($_SESSION['date_begin'])))
{
	header('Location:index.php');
	exit();
}

		 $_SESSION['date_begin'] = date("Y-m-01");
		 $_SESSION['date_end'] = date("Y-m-31");


		header('Location:view_balance.php');

?>