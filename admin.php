<!--
		/**@author Shibbir Hossain <100864497@student.swin.edu.au>
		 * @version 1.0
		 * Admin page of the cabsOnline 
		 * In this page admin can see the "unassigned" pickup requests which are within next two hours and 
		 * can change the generated status to "assigned".
		 *
		 */
-->

<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
</head>
<body>

<h1>Admin page of CabsOnline</h1>

<p><b>1.Click below button to search for all unassigned booking requests with a pick-up time within 2 hours.</b></p>


		<?php
			
	
			if(isset($_GET['list_all'])){

				//database connection configurations
				include 'connection.php';

				$current_datetime = date('Y-m-d H:i:s');

				//two hours added to current time
				$current_datetime_plus_two = strtotime("+120 minutes", strtotime($current_datetime));
				$current_datetime_plus_two = date('Y-m-d H:i:s', $current_datetime_plus_two);
				
				// query to determine the requests that are unassigned and within next two hours to pickup
				$query = "SELECT * FROM booking WHERE generated_status='UNASSIGNED' AND pickup_datetime > '".$current_datetime."' AND pickup_datetime < '".$current_datetime_plus_two."'";

				$result = mysql_query($query) or die('Query failed: '.mysql_error());

				echo "<table border='1'> 
					<tr>
						<th>reference #</th>
						<th>customer name</th>
						<th>passenger name</th>
						<th>passenger contact phone</th>
						<th>pick-up address</th>
						<th>destination suburb</th>
						<th>pick-time</th>
					</tr>";
				while( $row = mysql_fetch_array($result, MYSQL_ASSOC)){
					
					$reference = $row['booking_number'];
					$passenger_name = $row['passenger_name'];
					$passenger_contact_phone = $row['passenger_phone'];
					$customer_email = $row['email'];

					if($row['unit_number'] == "NULL"){
						$unit_number = "";
						$pickup_address = $row['street_number']." ".$row['street_name'].", ".$row['pickup_suburb'];
					}
					else{
						$pickup_address = $row['unit_number']."/".$row['street_number']." ".$row['street_name'].", ".$row['pickup_suburb'];	
					}
					
					$destination = $row['destination'];
					$pickup_time = $row['pickup_datetime'];

					$query3 = "SELECT customer_name FROM customer WHERE email = '".$customer_email."'";

					$result3 = mysql_query($query3) or die("Query failed: ".mysql_error());

					while ($row = mysql_fetch_array($result3, MYSQL_ASSOC)) {
					
						$customer_name = $row['customer_name'];					 
					}					 

					echo "<tr><td>".$reference."</td>
							  <td>".$customer_name."</td>
							  <td>".$passenger_name."</td>
							  <td>".$passenger_contact_phone."</td>
							  <td>".$pickup_address."</td>
							  <td>".$destination."</td>
							  <td>".$pickup_time."</td></tr>";
				}


			echo "</table>";
				mysql_close($link);	
			}
	
		?>
<form>
	<input type="submit" name="list_all" value="List all">
</form>




<p><b>2.Input a reference number below and click "update" button to assign a taxi to that request</b></p>

<form>
	<table>
		<tr>
			<td>Reference number:</td>
			<td><input type="text" name="ref_number"> <input type="submit" name="update" value="update"></td>
		</tr>
	</table>

</form>


<?php
	
	if(isset($_GET['ref_number'])){

		$ref_number = $_GET['ref_number'];


		include 'connection.php';

		
		//mysql_select_db($database) or die('Could not select database');

		$query1 = "SELECT * FROM booking WHERE booking_number='".$ref_number."'";

		$result = mysql_query($query1) or die("Query failed:" .mysql_error());

		if(mysql_num_rows($result) > 0){
			
			$query2 = "UPDATE booking SET generated_status='ASSIGNED' WHERE booking_number='".$ref_number."'";
			$result2 = mysql_query($query2) or die("Query failed: ".mysql_error());

			echo "The booking request ".$ref_number." has been properly assigned.";
		}
		else echo "Error: No match found for your requested booking reference number";

		

	}
?>
</body>
</html>