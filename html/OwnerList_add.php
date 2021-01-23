<?php
// Author: rezza-zairan ZAHARIN

session_start();

include_once 'db_connection.php';

if ( mysqli_connect_errno() )
{
	exit('Connection failed:'.mysqli_connect_error());
	print "fail";
}

if (isset($_POST['submit']))
{
	if (isset($_POST['oid']) && !empty($_POST['oid']) &&
	isset($_POST['ousername']) && !empty($_POST['ousername']) &&
	isset($_POST['ofname']) && !empty($_POST['ofname']) &&
	isset($_POST['olname']) && !empty($_POST['olname']) &&
	isset($_POST['opass']) && !empty($_POST['opass']) &&
	isset($_POST['oemail']) && !empty($_POST['oemail']) &&
	isset($_POST['oaddress']) && !empty($_POST['oaddress']))
	{
		
		$id = $_POST['oid'];
		$username= $_POST['ousername'];
		$fname= $_POST['ofname'];
		$lname= $_POST['olname'];
		$pass= $_POST['opass'];
		$email= $_POST['oemail'];
		$address= $_POST['oaddress'];
		
		$sql = "INSERT INTO `Members` (`ID`, `Passsword`, `username`, `FirstName`, `LastName`, `Email`, `Address`, `Privileges`, `Status`) 
		VALUES ('$id', '$pass', '$username', '$fname', '$lname', '$email', '$address', b'0', b'0')";
				
		if ($conn->query($sql) === TRUE)
			// echo "<meta https-equiv='refresh' content='0;url=OwnerList.php'>";
			header("location: OwnerList.php?success");
		else
			// echo "<meta https-equiv='refresh' content='0;url=OwnerList.php'>";
			header("location: OwnerList.php?success");
	}
	else
		echo "FAILED!";
}
else
		echo "FAILED!";
	
$conn->close();
?>