<?php

// Made by:
// NAME: Rezza-Zairan Zaharin
// ID: 40003377

	session_start();

	include_once 'db_connection.php';
	
	
	if ( mysqli_connect_errno() )
	{
		exit('Connection failed:'.mysqli_connect_error());
		print "fail";
	}

	$ID_edit;
	$result_edit;

	if (isset($_GET['ID']))
	{
		$ID_edit = $_GET['ID'];
		$tempquery_edit = $conn->query("SELECT * FROM MEMBERS WHERE ID = '$ID_edit'");
		$result_edit = $tempquery_edit -> fetch_assoc();
	}
?>

<style>
	<?php include 'mainStyle.css';?>
</style>

<html>
<head>
	<title>Edit List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="mainStyle.css">
</head>
<body>
 <div class="sidenav">
    <img src="LOGO.jpg">
    <a href="group.php">Groups</a>
    <br/>
    <a href="OwnerList.php">Owner List</a>
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
		<h2>Editing <?php echo $result_edit['username'];?></h2>
		<div>
			<form action="OwnerList.php" method="POST">
				<table>
					<tr>
						<td><label><b>USERNAME:</b></label></td>
						<td><input type="text" name="input_username" value=<?php echo $result_edit['username']; ?>></input></td>
					</tr>
					<tr>
						<td><label><b>FIRST NAME:</b></label></td>
						<td><input type="text" name="input_fname" value=<?php echo $result_edit['FirstName']; ?>></input></td>
					</tr>
					<tr>
						<td><label><b>LAST NAME:</b></label></td>
						<td><input type="text" name="input_lname" value=<?php echo $result_edit['LastName']; ?>></input></td>
					</tr>
					<tr>
						<td><label><b>PASSWORD:</b></label></td>
						<td><input type="password" name="input_password" value=<?php echo $result_edit['Passsword']; ?>></input></td>	
					</tr>
					<tr>
						<td><label><b>EMAIL:</b></label></td>
						<td><input type="text" name="input_email" value=<?php echo $result_edit['Email']; ?>></input></td>	
					</tr>
					<tr>
						<td><label><b>ADDRESS:</b></label></td>
						<td><input type="text" name="input_address" value=<?php echo $result_edit['Address']; ?>></input></td>	
					</tr>
					<tr>
						<td><label><b>STATUS:</b></label></td>
						<td>
							<?php
								if ($result_edit['AdminRights'] == '1')
									echo "<input type='checkbox' name='admin_choice' value='1' checked>Admin</input>";
								else
									echo "<input type='checkbox' name='admin_choice' value='1'>Admin</input>";
							?>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td>
							<button type="submit" style="width:200px" name="edit_submit">SUBMIT</button>
						</td>
						<td>
							<form action="OwnerList.php">
								<button type="submit" style="width:200px;">
								BACK
								</button>
							</form>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>