<!DOCTYPE html>
<html>
<head>
	<title>Book Online</title>
</head>
<body>

	<h1>Booking a cab</h1>

	<?php
		/**@author Shibbir Hossain <100864497@student.swin.edu.au>
		 * @version 1.0
		 * Booking page of the cabsOnline 
		 * In this page we take input from the authorized customer for booking request, check the input fields and insert the values into database	
		 *
		 */

		//carry forward the customer name and email through php session
		session_start();
		$customer_name = $_SESSION['customer_name'];
		$email = $_SESSION['email'];

		echo "<p>Welcome <b>".$customer_name."</b>, Thanks for choosing us!!</p>"
	?>

	<p>Please fill the fields below to book a taxi</p>

	<form>
		
		<table>
			
			<tr>
				<td>Passenger Name:</td>
				<td><input type="text" name="passenger_name"></td>
			</tr>
			<tr>
				<td>Contact phone of the passenger:</td>
				<td><input type="text" name="contact_phone"></td>
			</tr>
			<tr>
				<td>Pick up address:</td>
				<td>	
						<tr>
							<td align="right">Unit Number</td>
							<td><input type="text" name="unit_number"></td>
						</tr>
						<tr>
							<td align="right">Street Number</td>
							<td><input type="text" name="street_number"></td>
						</tr>
						<tr>
							<td align="right">Street name</td>
							<td><input type="text" name="street_name"></td>
						</tr>
						<tr>
							<td align="right">Suburb</td>
							<td><input type="text" name="suburb"></td>
						</tr>
				</td>												
			</tr>
				<tr>
					<td>Destination Suburb:</td>
					<td><input type="text" name="destination_suburb"></td>
				</tr>
				<tr>
					<td>Pickup Date:</td>
					<td><input type="date" name="pickup_date"></td>
				</tr>
				<tr>
					<td>Pickup time:</td>
					<td><input type="time" name="pickup_time"></td>
				</tr>

				<tr>
					<td><input type="submit" name="submit" value="Book"></td>
				</tr>
		</table>
	</form>
</body>

<?php
	

	if(isset($_GET['passenger_name']) && isset($_GET['contact_phone']) && isset($_GET['street_number']) && isset($_GET['street_name']) && isset($_GET['suburb']) && isset($_GET['destination_suburb']) && isset($_GET['pickup_date']) && isset($_GET['pickup_time'])) {


		//adding database connection files 
		include 'connection.php';

		//getting values from input fields
		$passenger_name = $_GET['passenger_name']; 
		$contact_phone = $_GET['contact_phone'];
		$unit_number = $_GET['unit_number'];
		$street_number = $_GET['street_number'];
		$street_name = $_GET['street_name'];
		$suburb = $_GET['suburb'];
		$destination_suburb = $_GET['destination_suburb'];
		$pickup_date = $_GET['pickup_date'];
		$pickup_time = $_GET['pickup_time'];
		$pickup_datetime = $pickup_date." ".$pickup_time;
		$booking_datetime = date('Y-M-d H:i:s');
		$generated_status = "UNASSIGNED";


		//echo $pickup_datetime;
		//echo "Booking time ".$booking_datetime;

		//checking to restrict order if the pickup time is less than one hour by adding 60 minutes to current time
		$checktime = strtotime("+60 minutes", strtotime($booking_datetime));

		$checktime = date('H:i:s', $checktime);

		//echo "The adjusted time is :".$checktime;

		$check_datetime = $pickup_date." ".$checktime;

		


		$isValuesNull = false;
		if($passenger_name ==null || $contact_phone== null || $street_name==null || $street_number==null || $suburb == null || $destination_suburb==null || $pickup_date==null || $pickup_time ==null){

			echo "<script type='text/javascript'> alert('All the fields need to be filled in except unit number');</script>";
			$isValuesNull = true;
		}


		if(!$isValuesNull){

			if( $pickup_datetime < $check_datetime){
				echo "Sorry, Pick up time must be at least 1 hour from current date/time.";
			}
			else
			{
				
				if($unit_number == null) $unit_number = 'NULL';

				$query = "INSERT into booking VALUES(default, '$email', '$passenger_name', '$contact_phone', '$destination_suburb', '$pickup_datetime', '$booking_datetime', '$generated_status', '$unit_number','$street_number', '$street_name', '$suburb')";

				$result = mysql_query($query) or die("Query failed: ".mysql_error());


				$query2 = "SELECT booking_number FROM booking WHERE booking_datetime='".$booking_datetime."'";
				$result2 = mysql_query($query2);

				while( $row = mysql_fetch_array($result2, MYSQL_ASSOC)) {
				
					$booking_number = $row['booking_number'];

				}
				echo "Thank you! Your booking reference number is ".$booking_number.". We will pick up the passengers in front of your provided address at ".$pickup_time." on ".$pickup_date.".";

				$mail_to = $email;
				$subject = "Your booking request with CabsOnline!";
				$message = "Dear ".$customer_name.",\nThanks for booking with CabsOnline! Your booking reference number is ".$booking_number.". We will pick up the passengers in front of your provided address at ".$pickup_time. " on ".$pickup_date.".";
				$headers = "From booking@cabsonline.com.au";

				mail($mail_to, $subject, $message, $headers, "-r 100864497@student.swin.edu.au");
				mysql_close($link);	
			}	

		}
		
	}
?>
</html>