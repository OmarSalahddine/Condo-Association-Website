<?php
// Author: rezza-zairan ZAHARIN

session_start();

include_once 'db_connection.php';

if ( mysqli_connect_errno() )
{
	exit('Connection failed:'.mysqli_connect_error());
	print "fail";
}

if (isset($_GET['del']))
{
	echo $_GET['del'];
	$id = $_GET['del'];
	$sql= "DELETE FROM Members WHERE ID='$id'";
	if ($conn->query($sql) === TRUE)
		echo "<meta http-equiv='refresh' content='0;url=OwnerList.php'>";
	else
		echo "FAILED!";
}
$conn->close();
?>