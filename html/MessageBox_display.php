<?php

// Made by:
// NAME: Rezza-Zairan Zaharin
// ID: 40003377

session_start();
include('db_connection.php');

////------------CHECK IF CONNECTION WORKS------------////
if ( mysqli_connect_errno() )
{
	exit('Connection failed:'.mysqli_connect_error());
	print "fail";
}

$id = $_SESSION['id']; //We can assume the id is valid; page is only accessible if logged in

//--------------INITIALIZATIONS---------------------////
//MessageBox.php shoudl toss the message ID here
$mID;
if (isset($_GET['messageID'])) $mID = $_GET['messageID'];

//Fetching the row from pm TABLE
$table_query = $conn->query("SELECT * FROM pm WHERE mID = '$mID'");
$table_result = $table_query -> fetch_assoc();

//Updating to tell that this message is read
$conn->query("UPDATE pm SET opened = '1' WHERE mID = '$mID'");

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
    <title>Read Mail from Inbox </title>

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
        <h2>
			Here is the message:
		</h2>
		<table style="width:1000px;">
			<?php
				
				//Fetching username by referencing ID
				$fromIDNameQuery = $conn->query("SELECT username FROM Members WHERE ID = '$table_result[from_ID]'");
				$fromIDResult = $fromIDNameQuery -> fetch_assoc();
			
				echo "<tr>
						<td class='tbl_info_thead' style='text-align: center;'>
							<label>
								<b>SUBJECT:</b>
							</label>
						</td>
						<td>" 
							. $table_result['subject'] . 
						"</td>
					</tr>" .
					 "<tr>
						<td class='tbl_info_thead' style='text-align: center;'>
							<label>
								<b>DATE RECEIVED:</b>
							</label>
						</td>
						<td>" 
							. $table_result['time_sent']. "
						</td>
					</tr>".
					 "<tr>
						<td class='tbl_info_thead' style='text-align: center;'>
							<label>
								<b>FROM:</b>
							</label>
						</td>
						<td>" 
							. $fromIDResult['username']. 
						"</td>
					</tr>" .
					 "<tr>
						<td class='tbl_info_thead' style='text-align: center;'>
							<label>
								<b>MESSAGE:</b>
							</label>
						</td>
						<td> 
							<div style='word-wrap: break-word; width:1000px;'>"
								. $table_result['message']. 
							"</div>
						</td>
					</tr>";
			?>	
		</table>
		<br>
		<form action='MessageBox.php?success'>
			<button type="submit" style="display:inline-block;width:200px;">
				BACK
			</button>
		</form>
    </div>
</body>

</html>