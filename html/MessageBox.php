<?php

// Made by:
// NAME: Rezza-Zairan Zaharin
// ID: 40003377

session_start();
include('db_connection.php');

////------------CHECK IF CONNECTION WORKS------------////
if ( mysqli_connect_errno())
{
	exit('Connection failed:'.mysqli_connect_error());
	print "fail";
}

$id = $_SESSION['id'];

////------------FOR SENDING NEW MESSAGE------------////
if (isset($_POST['send_submit']))
{
	if (isset($_POST['input_subject']) && !empty($_POST['input_subject']) &&
	isset($_POST['input_for_username']) && !empty($_POST['input_for_username']) &&
	isset($_POST['input_message']))
	{
		//Fetching ID of receiver through their username
		$to_username_input = $_POST['input_for_username'];
		$to_fetchID_query = $conn->query("SELECT ID FROM Members WHERE username = '$to_username_input'");
		$to_ID_result = $to_fetchID_query->fetch_assoc();
		
		//Adding an entry into the pm TABLE of DATABASE
		$to_ID = $to_ID_result['ID'];
		$from_ID = $_SESSION['id'];
		$time_sent = date("Y-m-d");
		$subject = $_POST['input_subject'];
		$message= $_POST['input_message'];
		$opened = '0';
		$to_delete = '0';
		$from_delete = '0';
		
		$sql = "INSERT INTO pm 
				(mID, to_ID, from_ID, time_sent, subject, message, opened, to_delete, from_delete) 
				VALUES 
				(DEFAULT, '$to_ID', '$from_ID', '$time_sent', '$subject', '$message', '$opened', '$to_delete', '$from_delete');";
				
		if ($conn->query($sql) === TRUE)
			header("location: MessageBox.php?success");
	}
}


////------------FOR DELETING MESSAGE------------////
if (isset($_GET['del']))
{
	$delID = $_GET['del'];
	$delquery = $conn->query("SELECT * FROM pm WHERE mID = '$delID'");
	$delresult = $delquery -> fetch_assoc();
	
	//If both giver and sender, delete immediately
	if ($delresult['to_ID'] == $id && $delresult['from_ID'] == $id)
		$conn->query("DELETE FROM pm WHERE mID='$delID'");
	
	//If sender, signal that sender deleted
	else if ($delresult['to_ID'] == $id)
		$conn ->query("UPDATE pm SET to_delete = '1' WHERE mID = '$delID]'");
	
	//If receiver, signal that receiver deleted
	else if ($delresult['from_ID'] == $id)
		$conn ->query("UPDATE pm SET from_delete = '1' WHERE mID = '$delID'");
	
	
	//Only deletes if both parties delete
	if ($delresult['to_delete'] == '1' && $delresult['from_delete'] == '1')
		$conn->query("DELETE FROM pm WHERE mID='$delID'");
	
	//For blocking ownerlist if not admin
	$check_tempID = $_SESSION['id'];
	$check_tempsql = $conn->query("SELECT AdminRights FROM Members WHERE ID = '$check_tempID'");
	$check_result = $check_tempsql->fetch_assoc();
}
?>

<style>
	<?php include 'mainStyle.css';?>
</style>

<html>
<head>
    <title>Inbox </title>

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
	<?php
		//Queries FOR the INBOX
		$received_sql = "SELECT mID, from_ID, subject, time_sent, opened, to_delete 
						 FROM pm 
						 WHERE pm.to_ID = '$id'";
						 
		$received_result = $conn->query($received_sql);	
		
		//Queries FOR the OUTBOX
		$sent_sql = "SELECT mID, to_ID, subject, time_sent, opened, from_delete
					 FROM pm 
					 WHERE from_ID = '$id'";
					 
		$sent_result = $conn->query($sent_sql);		
	?>
        <h2>Messages</h2>
					<button style="display:inline-block;width:auto;" 
					onclick="document.getElementById('sendMessageTab').style.display='block'">
					<b>SEND MESSAGE</b></button>
        <div>
            Received messages will be displayed here:
			<table class="tbl_info">
				<thead class="tbl_info_thead">
					<th>Subject</th>
					<th>From</th>
					<th>Time Sent</th>
					<th>Opened</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php
				if ($received_result -> num_rows > 0)
				{
						while ($row = $received_result-> fetch_assoc())
						{
							if ($row['to_delete'] == '0')
							{
								//Fetch username from ID of receiver
								$fromID_temp = $row['from_ID'];
								$fromIDQuery_temp = $conn->query("SELECT username FROM MEMBERS WHERE ID = '$fromID_temp'");
								$fromIDArray_temp = $fromIDQuery_temp -> fetch_assoc();
							
								//Print details
								echo "<tr><td>".$row['subject'].
									"</td><td>".$fromIDArray_temp['username'].
									"</td><td>".$row['time_sent']."</td>";
							
								//If read or not
								if ($row['opened'] == '0') echo "<td>no</td>";
								else echo "<td>yes</td>";
							
								//Actions
								echo "<td>
										<a class='tbl_info_href' href='MessageBox_display.php?messageID=$row[mID]'><b>Open</b></a> 
										<a class='tbl_info_href' href='MessageBox.php?del=$row[mID]'><b>Delete</b>
									</td>";
							}
						}
				}
				?>
				</tbody>
			</table>
        </div>
		<div>
			<br>
			<br>
            Sent messages will be displayed here:
			<table class="tbl_info">
				<thead class="tbl_info_thead">
					<th>Subject</th>
					<th>To</th>
					<th>Time Sent</th>
					<th>Opened</th>
					<th>Action</th>
				</thead>
				<tbody>
				<?php
				if ($sent_result -> num_rows > 0)
						while ($row = $sent_result-> fetch_assoc())
						{
							if ($row['from_delete'] == '0')
							{
								//Fetch username from ID of sender
								$toID_temp = $row['to_ID'];
								$toIDQuery_temp = $conn->query("SELECT username FROM MEMBERS WHERE ID = '$toID_temp'");
								$toIDArray_temp = $toIDQuery_temp -> fetch_assoc();
							
								//Print details
								echo "<tr><td>".$row['subject'].
									"</td><td>".$toIDArray_temp['username'].
									"</td><td>".$row['time_sent']."</td>";
							
								//If read or not
								if ($row['opened'] == '0')
									echo "<td>no</td>";
								else
									echo "<td>yes</td>";
							 
								//Actions
								echo "<td>
									<a class='tbl_info_href' href='MessageBox_display.php?messageID=$row[mID]'><b>Open</b></a> 
									<a class='tbl_info_href' href='MessageBox.php?del=$row[mID]'><b>Delete</b>
									</td>";
							}
						}
				?>
				</tbody>
			</table>

        </div>
    </div>
	<div id="sendMessageTab" class="modal">
			<form class="modal-content animate" action="MessageBox.php" method="post">
				<!--------User prompted fields------------------>
				<label><b>SUBJECT:</b></label>
				<input type="text" name="input_subject" required>
				<label><b>TO:</b></label>
				<input type="text" name="input_for_username" required>
				<label><b>MESSAGE:</b></label>
				<textarea name="input_message" rows ="10" cols="30" placeholder="Type your Messsage here"
							style='width:100%;'>
				</textarea>
				<!----------------------------------------------->
				<table>
					<tr>
						<td>
							<button type="submit" name = "send_submit">SUBMIT</button>
						</td>
						<td>
							<button type="button" onclick="document.getElementById('sendMessageTab').style.display='none'"
									style="background-color:red;">CANCEL</button>
						</td>
					</tr>
				</table>
			</form>
	</div>
</body>

</html>