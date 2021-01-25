<?php
session_start();
if(!isset($_SESSION['logged']))
{
	header('Location:index.php');
	exit();
}
			$month;
			$year;
	
			if(date('m')==01)
			{
				$month=12;
				$year=date('Y')-1;
				
			}

			$_SESSION['date_begin'] = date($year.'-'.$month.'-01');
			$_SESSION['date_end'] = date($year.'-'.$month.'-31');
			
	
			header('Location:view_balance.php'); 
	
?>
