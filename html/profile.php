<?php
// Author: Omar SALAHDDINE
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: homepage.html');
	exit;
}

include_once 'db_connection.php';

if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $conn->prepare('SELECT Passsword, Email FROM Members WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($passsword, $email);
$stmt->fetch();
$stmt->close();

//For blocking ownerlist if not admin
$check_tempID = $_SESSION['id'];
$check_tempsql = $conn->query("SELECT AdminRights FROM Members WHERE ID = '$check_tempID'");
$check_result = $check_tempsql->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="mainStyle.css">
</head>
<body>
<div class="sidenav">
    <img src="LOGO.jpg">
    <a href="group.php">Groups</a>
    <br/>
     <?php
		if ($check_result['AdminRights'] == '1')
		{
			echo "<a href='OwnerList.php'>Owner List</a>";
		}
	?>
</div>
  <div class="topnav">
    <a href="home.php">HOME</a>
    <div class="topnav-right">
      <a href="MessageBox.php">Inbox </a>
      <a href="profile.php"></i>Profile</a>
      <a href="logout.php"></i>Logout</a>
    </div>
  </div>
  <div class="main">
    <br>
    <h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td class="tbl_info_thead">Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td class="tbl_info_thead">Password:</td>
						<td><?=$passsword?></td>
					</tr>
					<tr>
						<td class="tbl_info_thead">Email:</td>
						<td><?=$email?>@CON</td>
					</tr>
				</table>
			</div>
		</div>
  </div>
  </div>
</body>
</html>
