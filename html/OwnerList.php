<?php
// Made by:
// NAME: Rezza-Zairan Zaharin
// ID: 40003377

session_start();

include_once 'db_connection.php';

$sql;
$result;


if ( mysqli_connect_errno() )
{
	exit('Connection failed:'.mysqli_connect_error());
	print "fail";
}
	if (isset($_POST['submit']))
	{
		if (isset($_POST['username_input']) && !empty($_POST['username_input']) &&
		isset($_POST['fname_input']) && !empty($_POST['fname_input']) &&
		isset($_POST['lname_input']) && !empty($_POST['lname_input']) &&
		isset($_POST['pass_input']) && !empty($_POST['pass_input']) &&
		isset($_POST['email_input']) && !empty($_POST['email_input']) &&
		isset($_POST['address_input']) && !empty($_POST['address_input']))
		{
		
			$username= $_POST['username_input'];
			$fname= $_POST['fname_input'];
			$lname= $_POST['lname_input'];
			$pass= $_POST['pass_input'];
			$email= $_POST['email_input'];
			$address= $_POST['address_input'];
			
			$isAdmin = '0';			
			if (!empty($_POST['admin_choice_create'])) $isAdmin ='1';
		
			$tempsql = "INSERT INTO Members 
					(ID, Passsword, username, FirstName, LastName, Email, Address, AdminRights, Status) 
					VALUES 
					(DEFAULT, '$pass', '$username', '$fname', '$lname', '$email', '$address', '$isAdmin', '0')";
				
			if ($conn->query($tempsql) === TRUE) header("location: OwnerList.php?success");
		}
	}
	
		
	if (isset($_POST['edit_submit']))
	{
		if (isset($_POST['input_username']) && !empty($_POST['input_username']) &&
		isset($_POST['input_fname']) && !empty($_POST['input_fname']) &&
		isset($_POST['input_lname']) && !empty($_POST['input_lname']) &&
		isset($_POST['input_password']) && !empty($_POST['input_password']) &&
		isset($_POST['input_email']) && !empty($_POST['input_email']) &&
		isset($_POST['input_address']) && !empty($_POST['input_address']))
		{
			$username= $_POST['input_username'];
			$fname= $_POST['input_fname'];
			$lname= $_POST['input_lname'];
			$pass= $_POST['input_password'];
			$email= $_POST['input_email'];
			$address= $_POST['input_address'];
			
			$isAdmin ='0';			
			if (!empty($_POST['admin_choice'])) $isAdmin ='1';

			//Find ID
			$tempsql = $conn->query("SELECT ID FROM Members WHERE username = '$username'");
			$temp_result = $tempsql->fetch_assoc();
			$IDresult = $temp_result['ID'];
		
			$sql = "UPDATE Members SET
					username = '$username', FirstName = '$fname', LastName = '$lname', Passsword = '$pass', 
					Email = '$email', Address = '$address', AdminRights = '$isAdmin'
					WHERE 
					ID = '$IDresult'";
				
			$conn->query($sql) === TRUE;
		}
	}

	if(isset($_GET['del']))
	{
		$delID = $_GET['del'];
		$tempsql= "DELETE FROM Members 
				   WHERE ID='$delID'";
		
		$tempsql_toletter = "DELETE FROM pm
						   WHERE to_ID = '$delID'";
		$tempsqlquery_toletter = $conn->query($tempsql_toletter);
		
		$tempsql_fromletter = "DELETE FROM pm
						       WHERE from_ID = '$delID'";
		$tempsqlquery_fromletter = $conn->query($tempsql_fromletter);
		
		
		if ($conn->query($tempsql) === TRUE) echo "<meta http-equiv='refresh' content='0;url=OwnerList.php'>";
	}
	
	
	if(isset($_POST['search_submit']))
	{
		$search = $_POST['search_input'];
		$sql = "SELECT 
				ID, Passsword, username, FirstName, LastName, Email, Address, AdminRights
				FROM Members 
				WHERE username LIKE '$search'";
		$result = $conn-> query($sql);
	}
	else
	{
		$sql = "SELECT 
				ID, Passsword, username, FirstName, LastName, Email, Address, AdminRights
				FROM Members";
		$result = $conn-> query($sql);
	}

?>

<style>
	<?php include 'mainStyle.css';?>
</style>

<html>
<head>
	<title>Owner List</title>
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
		<h1>Owner List</h1>
		<div>
			<p>Hello <?php echo $_SESSION['name'] ?>, this is the list of owners:</p>
			<table>
				<tr style="display:inline-block">
					<td>
						<button style="width:100px;"
							onclick="document.getElementById('addOwnerTab').style.display='block'">
							Add Entry
						</button>
					</td>
					<td>
						<a class="href_button"  href="OwnerList.php">
							Refresh
						</a>
					</td>
				</tr>
			</table>
			<table class="tbl_info">
				<thead class="tbl_info_thead">
					<th> ID </th>
					<th> USERNAME </th>
					<th> FIRST NAME </th>
					<th> LAST NAME </th>
					<th> PASSWORD </th>
					<th> EMAIL </th>
					<th> ADDRESS </th>
					<th> ADMIN </th>
					<th> ACTION </th>
				</thead>
				<tbody>
				<?php
					if (isset($_POST['search_submit']))
					{
						if ($result->num_rows > 0)
						{
							$row = $result -> fetch_assoc();
						
							echo "<tr><td>".$row['ID'].
								"</td><td>".$row['username'].
								 "</td><td>".$row['FirstName'].
								 "</td><td>".$row['LastName'].
								 "</td><td>".$row['Passsword'].
								 "</td><td>".$row['Email'].
								 "</td><td>".$row['Address'].
								 "</td>";
							
							if($row['AdminRights'] == '0')
								echo "<td>No</td>";
							else
								echo "<td>Yes</td>";
							
								 
							if ($row['ID'] != $_SESSION['id'] && $row['AdminRights'] == '0')
							{
								echo "<td>
									 <a type='button' class='tbl_info_href' href='OwnerList_edit.php?ID=$row[ID]'><b>Edit</b></a>
									 <a type='button' class='tbl_info_href' href='OwnerList.php?del=$row[ID]'><b>Delete</b></a>
									 </td>";
							}
							else
								echo "<td>
										<a type='button' class='tbl_info_href' href='OwnerList_edit.php?ID=$row[ID]'><b>Edit</b></a>
									  </td>";
						}
						else
							echo "<p style='color:red'>SORRY, YOUR SEARCH DID NOT YIELD ANY RESULTS</p>";
					}
					else
					{
						if ($result -> num_rows > 0)
						while ($row = $result-> fetch_assoc())
						{
							echo "<tr><td>".$row['ID'].
								 "</td><td>".$row['username'].
								 "</td><td>".$row['FirstName'].
								 "</td><td>".$row['LastName'].
								 "</td><td>".$row['Passsword'].
								 "</td><td>".$row['Email'].
								 "</td><td>".$row['Address'].
								 "</td>";
								 
							if($row['AdminRights'] == '0')
								echo "<td>No</td>";
							else
								echo "<td>Yes</td>";
							
							if ($row['ID'] != $_SESSION['id'] && $row['AdminRights'] == '0')
							{
								echo "<td>
									 <a type='button' class='tbl_info_href' href='OwnerList_edit.php?ID=$row[ID]'><b>Edit</b></a>
									 <a type='button' class='tbl_info_href' href='OwnerList.php?del=$row[ID]'><b>Delete</b></a>
									 </td>";
							}
							else
								echo "<td>
										<a type='button' class='tbl_info_href' href='OwnerList_edit.php?ID=$row[ID]'><b>Edit</b></a>
									  </td>";
						}
						
					}
				?>
				</tbody>
			</table>
			<div>
				<table>
					<tr>
						<form action="OwnerList.php" method="post">
							<td><input type="text" placeholder="Enter a username to find" name="search_input"></td>
							<td><button type="submit" name="search_submit">SUBMIT</button></td>
						</form>
					</tr>
				</table>
			</div>
		</div>

		<div id="addOwnerTab" class="modal">
			<form class="modal-content animate" action="OwnerList.php" method="post">
				<label><b>Username</b></label>
				<input type="text" placeholder="Enter Username here" name="username_input" required>
				<label><b>First Name</b></label>
				<input type="text" placeholder="Enter FIRST NAME here" name="fname_input" required>
				<label><b>Last Name</b></label>
				<input type="text" placeholder="Enter LAST NAME here" name="lname_input" required>
				<label><b>Password</b></label>
				<input type="password" placeholder="Enter PASSWORD here" name="pass_input" required>
				<label><b>Email</b></label>
				<input type="text" placeholder="Enter EMAIL here" name="email_input" required>
				<label><b>Address</b></label>
				<input type="text" placeholder="Enter ADDRESS here" name="address_input" required>
				<label><b>Status:</b></label>
				<input type="checkbox" name="admin_choice_create" value="good">Admin</input>
				<table>
					<tr>
						<td>
							<button type="submit" name = "submit">SUBMIT</button>
						</td>
						<td>
							<button type="button" onclick="document.getElementById('addOwnerTab').style.display='none'"
									style="background-color:red;">CANCEL</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>