<!--
		/**@author Shibbir Hossain <100864497@student.swin.edu.au>
		 * @version 1.0
		 * login page of the cabsOnline 
		 * In this page we take the customer email,password and search in customer database for matching and validate the customer if the details matches	
		 *
		 */
-->


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login to CabsOnline</h1>

	<form>
		<table>
			<tr>
				<td>Email:</td>
				<td><input type="email" name="email"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password"></td>
			</tr>

			<tr>
				<td><input type="submit" name="login_button" value="Log in"></td>
			</tr>
		</table>
	</form>

	<p><b>New Member? <a href="register.php">Register now</a></b></p>
</body>

<?php
	
		$database = 's100864497_db';
		$username = 's100864497';
		$password = '080792';
	
		$link = mysql_connect('mysql.ict.swin.edu.au', $username, $password) or die('Could not select database');
		mysql_select_db($database) or die('Could not select database');
	if(isset($_GET['email']) && isset($_GET['password'])){

		$email = $_GET['email'];
		$password = $_GET['password'];
		$password_from_db = NULL;
		//echo $email." ".$password;

		if($email == "" || $password ==""){
			echo "Please fill in all the fields.";
		}
		else{
			$query = "SELECT customer_name, email, password FROM customer WHERE email ='".$email."'";

			$result = mysql_query($query) or die("Query failed: ".mysql_error());


			//print_r($result);

			while( $row = mysql_fetch_array($result, MYSQL_ASSOC)){
				//print_r($row);

				//get the customer deatils from database
				$customer_name_from_db = $row['customer_name'];
				$email_from_db = $row['email'];
				$password_from_db = $row['password'];	
				
				
			}

			if( $password == $password_from_db){
				//echo "Password matches, you are authenticated";

				//storing the customer details in php session to carry forward those values
				session_start();

				$_SESSION['customer_name'] = $customer_name_from_db;
				$_SESSION['email'] = $email_from_db;

				// redirect to booking page if the customer is validated
				echo "<script type='text/javascript'> window.location ='booking.php'</script>";
			}

			else{
				echo "Sorry try again, you are not authorised to view booking";
			}

			//echo "From db : ".$email_from_db." ".$password_from_db;
			mysql_free_result($result);
		
		}
		
		mysql_close($link);


	}
?>
</html>