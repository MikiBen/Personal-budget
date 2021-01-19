<?php
session_start();

if(!isset($_SESSION['logged'])&&(!isset($_SESSION['date_begin'])))
{
	header('Location:menu.php');
	exit();
}

		$year = date("Y");
		$month = date("m");
		
		if($month==01)
		{
			$month=12;
			$year=$year-1;
		}
		
		 $_SESSION['date_begin'] = date("$year-$month-01");
		 $_SESSION['date_end'] = date("$year-$month-31");
		
		header('Location:view_balance.php');

?>