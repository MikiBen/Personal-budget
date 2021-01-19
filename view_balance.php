<?php
session_start();

if(!isset($_SESSION['logged'])&&(!isset($_SESSION['date_begin'])))
{
	header('Location:index.php');
	exit();
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
					//$date_begin = new DateTime($_SESSION['date_begin']);
					//$date_end = new DateTime($_SESSION['date_end']);
					//$date_begin->format('Y-m-d');
					//$date_end->format('Y-m-d');
						//echo $_SESSION['date_begin'];
						//echo $_SESSION['date_end'];
						$date_begin = $_SESSION['date_begin'];
						$date_end = $_SESSION['date_end'];
						unset($_SESSION['date_begin']);
						unset($_SESSION['date_end']);
						
						$result = $connection->query ('SELECT  expenses_category_assigned_to_users.name, 
						payment_methods_assigned_to_users.name AS payment_name,
						expenses.amount, 
						expenses.date_of_expense,
						expenses.expense_comment 
						FROM expenses_category_assigned_to_users,
						payment_methods_assigned_to_users,
						expenses 
						WHERE expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id 
						AND expenses.payment_method_assigned_to_user_id=payment_methods_assigned_to_users.id 
						AND expenses.user_id='.$_SESSION["user_id"]);    
					//'AND expenses.date_of_expense="2021-01-19"');
						//AND expenses.date_of_expense< CAST(2020-10-11 as DATE)');
						

				
echo<<<END

			<table width="950" align="center" border="2px solid">
				<thead>
					<tr><th colspan="6" align="center"> Balance sheet</th></tr>
					<tr><th colspan="6" align="center"> Expenses</th></tr>
					<tr>
					<th width="50" align="center">Id</th>
					<th width="100" align="center">Amount</th>
					<th width="200" align="center">Category</th>
					<th width="200" align="center">Payment methods</th>
					<th width="100" align="center">Date</th>
					<th width="300" align="center">Comment</th>
					</tr>
				</thead>
END;
				
				
				$id=0;
				$sum_expenses = 0;
				while($row=mysqli_fetch_array($result))
				{
					$a1= $row['amount'];
					$a2= $row['name'];
					$a3= $row['payment_name'];
					$a4= $row['date_of_expense'];
					$a5= $row['expense_comment'];
					$sum_expenses = $sum_expenses + $a1;
					$id++;					
					
				if($a4>=$date_begin && $a4<= $date_end)
				{
echo<<<END
					
				<tbody>
					<tr>
					<td width="50" align="center"> $id</td>
					<td width="100" align="center"> $a1</td>
					<td width="200" align="center"> $a2</td>
					<td width="200" align="center"> $a3</td>
					<td width="100" align="center"> $a4</td>
					<td width="300" align="center"> $a5</td>
					</tr>
				</tbody>

END;
					
				}			
								}	
				echo "</table></br></br>";				
				



						$result = $connection->query ('SELECT  incomes_category_assigned_to_users.name, 
						incomes.amount, 
						incomes.date_of_income,
						incomes.income_comment 
						FROM incomes_category_assigned_to_users,
						incomes
						WHERE incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id 
						AND incomes.user_id='.$_SESSION["user_id"]);
				
echo<<<END

			<table width="950" align="center" border="2px solid">
				<thead>
					<tr><th colspan="6" align="center"> Balance sheet</th></tr>
					<tr><th colspan="6" align="center"> Incomes</th></tr>
					<tr>
					<th width="50" align="center">Id</th>
					<th width="100" align="center">Amount</th>
					<th width="200" align="center">Category</th>
					<th width="100" align="center">Date</th>
					<th width="300" align="center">Comment</th>
					</tr>
				</thead>
END;
				
				$sum_incomes = 0;
				$id=0;
				while($row=mysqli_fetch_array($result))
				{
					$a1= $row['amount'];
					$a2= $row['name'];
					$a3= $row['date_of_income'];
					$a4= $row['income_comment'];
					$sum_incomes = $sum_incomes + $a1;
					$id++;
					
				if($a3>=$date_begin && $a3<= $date_end)
				{
echo<<<END
				<tbody>
					<tr>
					<td width="50" align="center"> $id</td>
					<td width="100" align="center"> $a1</td>
					<td width="200" align="center"> $a2</td>
					<td width="100" align="center"> $a3</td>
					<td width="300" align="center"> $a4</td>
					</tr>
				</tbody>

END;
					
				}					
								}	
				echo "</table>";
				
				
				echo "</br></br> Sum incomes: ".$sum_incomes. " PLN";
				echo "</br></br> Sum expenses: ".$sum_expenses. " PLN";
				echo "</br></br> Balance:  ".($sum_expenses - $sum_incomes). " PLN";

				}
					$connection->close();
				}
				catch(Exception$e)
				{
					echo "Problem z połączeniem </br>";
					//echo "błędy  ".$e;
				}
				
				echo "</br><p><a href='menu.php'> Return to the menu</a></p>"; 
	
?>


