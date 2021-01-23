<?php

  // Author: Judy Mezabe
  
	session_start();
	include_once 'db_connection.php';
	
	if ( mysqli_connect_errno() )
	{
		exit('Connection failed:'.mysqli_connect_error());
		print "fail";
	}
	
	if (isset($_POST['submit_creategroup']))
	{
		if (isset($_POST['name_input']) && !empty($_POST['name_input']) &&
		isset($_POST['description_input']) && !empty($_POST['description_input']))
		{
			$OwnerID = $_SESSION['id'];
			$GroupName = $_POST['name_input'];
			$Description = $_POST['description_input'];
				
			$sql = "INSERT INTO Groups_ 
					(GroupID, GroupName, OwnerID, Description, MemberID) 
					VALUES 
					(DEFAULT, '$GroupName', '$OwnerID', '$Description')";
				
			$conn->query($sql) === TRUE;
		}
	}
	
	$sqlquery = $conn->query("SELECT * from Groups_");
	
	//For blocking ownerlist if not admin
	$check_tempID = $_SESSION['id'];
	$check_tempsql = $conn->query("SELECT AdminRights FROM Members WHERE ID = '$check_tempID'");
	$check_result = $check_tempsql->fetch_assoc();
?>

<style>
	<?php include 'mainStyle.css';?>
</style>
<html>

<head>
	<title>Group</title>
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
	<h1>Groups</h1>
	<div>
		<form>
			<?php
				if($sqlquery -> num_rows > 0)
				{
					while($row = $sqlquery -> fetch_assoc())
					{
						$groupname = $row['GroupName'];
						echo  $groupname . " <input type=\"checkbox\" id=\"" . $groupname . "\" name=\"" . $groupname . "\" value=\"" . $groupname . "\"><br>";
					}
				}
				else 
				{
					echo "There are currently no groups, you can always create one!";					
				}		
			?>
		</form>
	</div>
	<table>
		<tr>
			<td>
				<button style="width:150px;"
				onclick="document.getElementById('createGroup').style.display='block'">
					Create Group
				</button>
			</td>
			<td>
				<a class="href_button" href="group.php" style="width:150px;">
					Join a Group
				</a>
			</td>
		</tr>
	</table>
</div>
<div id="createGroup" class="modal">
	<form class="modal-content animate" action="group.php" method="post">
		<label><b>Group Name:</b></label>
		<input type="text" placeholder="Enter Group Name here" name="name_input" required>
		<label><b>Description:</b></label>
		<textarea placeholder="Enter Description here" 
				  style="width:100%;" name="description_input" required>
		</textarea>
		<table>
			<tr>
				<td>
					<button type="submit" name = "submit_creategroup">SUBMIT</button>
				</td>
				<td>
					<button type="button" onclick="document.getElementById('createGroup').style.display='none'"
						style="background-color:red;">CANCEL</button>
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>