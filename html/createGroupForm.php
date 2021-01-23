<!DOCTYPE html>
<!-- Author: Judy Mezaber -->
<html>

<head>
	<title>Create a group</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="mainStyle.css">
</head>

<body>

<div class="sidenav">
    <img src="LOGO.jpg">
    <a href="group.php">Groups</a>
    <br/>
    <!--  	<a href="#services">Services</a>
	<a href="#clients">Clients</a>
  	<a href="#homepage">Contact</a> -->
    <a href="group1.html">Group 1</a>
    <br/>
    <a href="Connections.html">Connections</a>
    <br/>
    <a href="OwnerList.php">Owner List</a>
  </div>

	<div class="topnav">
		<a href="homepage.html">HOME</a>
	</div>


	<div class="main">
		<h1>Create a group</h1>
		<div>
			<form action="createGroup.php" method="POST">
				<label for="groupName">Group name:</label><br>
				<input id="groupName" type="text" name="groupName"><br><br>
				<label for="groupDescription">Group description <span style="font-size: 14px">(255 characters
						max)</span>:</label> <br>
				<textarea id="groupDescription" name="groupDescription" rows="4" cols="50" maxlength="255"></textarea>
				<br>
				<button type="submit" name="submit">Submit</button>
			</form>
		</div>
	</div>
</body>

</html>