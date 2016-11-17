<?php
		/**@author Shibbir Hossain <100864497@student.swin.edu.au>
		 * @version 1.0
		 * Database Connection page of the cabsOnline 
		 * Database Connection credentials
		 */
	
		$database = 's100864497_db';
		$username = 's100864497';
		$password = '080792';
	
		$link = mysql_connect('mysql.ict.swin.edu.au', $username, $password) or die('Could not select database');
		mysql_select_db($database) or die('Could not select database');

?>