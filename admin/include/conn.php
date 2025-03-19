<?php
	$conn = new mysqli('localhost', 'root', '', 'dental_appointment');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>