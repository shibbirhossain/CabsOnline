<!--
		/**@author Shibbir Hossain <100864497@student.swin.edu.au>
		 * @version 1.0
		 * Register page of the cabsOnline 
		 * In this page we take the customer details and create a new customer account by saving their details in the database	
		 *
		 */
-->

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>

<h1>Register to CabsOnline</h1>
<p>Please fill the fields below to complete your registration</p>
<form>
	<table>
		<tr>
			<td align="left">Name : </td>
			<td align="right"><input type="text" name="customer_name"></td>
		</tr>
		<tr>
			<td align="left">Password : </td>
			<td align="right"><input type="password" name="password"></td>
		</tr>
		<tr>
			<td align="left">Confirm Password : </td>
			<td align="right"><input type="password" name="confirm_password"></td>
		</tr>
		<tr>
			<td align="left">Email : </td>
			<td align="right"><input type="email" name="email"></td>
		</tr>
		<tr>
			<td align="left">Phone : </td>
			<td align="right"><input type="number" name="phone"></td>
		</tr>
		<tr>

			<td align="left"><input type="submit" name="register" value="Register"></td>
		</tr>
	</table>
</form>

	<p><b>Already Registered? <a href="login.php">Login here</a></b></p>
</body>


<?php
	
	if(isset($_GET['customer_name']) && isset($_GET['password']) && isset($_GET['email']) && isset($_GET['phone'])){




		$database = 's100864497_db';
		$username = 's100864497';
		$password = '080792';
	
		$link = mysql_connect('mysql.ict.swin.edu.au', $username, $password) or die('Could not select database');
		mysql_select_db($database) or die('Could not select database');

		//get values from the input fields into variable
		$customer_name = $_GET['customer_name'];
		$password = $_GET['password'];
		$confirm_password = $_GET['confirm_password'];
		$email = $_GET['email'];
		$phone =$_GET['phone'];

		if($customer_name =="" || $password =="" || $confirm_password =="" || $email =="" || $phone ==""){
			echo "Please fill in all the fields.";
		}
		else{

			if($password != $confirm_password){
				echo "Password mismatch, please try again.";
			}

			else{
				$query = "INSERT INTO customer VALUES ('$email', '$customer_name', '$password', '$phone')";

				$result = mysql_query($query) or die('Query failed: '.mysql_error());

				//echo "Value is added successfully i guess :".$result;

				echo "<br>Successfully inserted customer data into customer table.<br>";	
			}

		}
			//echo $customer_name." ".$password." ".$email." ".$phone;
		mysql_close($link);	
		
	}

?>
</html>