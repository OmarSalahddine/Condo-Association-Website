<?php
// Author: Omar SALAHDDINE


include_once 'db_connection.php';

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['namee'], $_POST['Adress'], $_POST['psw-repeat'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty ($_POST['Adress'])|| empty($_POST['email']) || empty ($_POST['namee']) || empty($_POST['psw-repeat'])) {
	// One or more values are empty.|| 
	exit('Please complete the registration form');
}
// We need to check if the account with that username exists.
if ($stmt = $conn->prepare('SELECT ID, Passsword FROM Members WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
        // Username doesnt exists, insert new account
		
        if ($stmt = $conn->prepare('INSERT INTO Members (ID, Passsword, username, FirstName, LastName, Email, Address, AdminRights, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$LastName = 'NOTSET';
			$privileges = '0';
			$status ='0';
			$ID = rand();
            $stmt->bind_param("sssssssss",$ID, $_POST['password'], $_POST['username'], $_POST['namee'], $LastName, $_POST['email'], $_POST['Adress'], $privileges, $status);
			if(!$stmt->execute()) echo $stmt->error;		
            header('Location: homepage.html');
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 6 fields.
            echo 'Couuyyyyld not prepare statement!';
        }         
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare staaaaaatement!';
}
$conn->close();
?>