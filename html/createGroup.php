<?php
// Author: Judy Mezaber

	include_once 'db_connection.php';

	// $Groupname = $_POST['groupName'];
	// $desc = $_POST['groupDescription'];

	// $sql = "insert into Groups_ (GroupName, Description) values('$Groupname', '$desc');";
	// $result = mysqli_query($conn, $sql);

	if ($stmt = $conn->prepare('INSERT INTO Groups_ (GroupName, Description, GroupID) VALUES (?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			// $LastName = 'NOTSET';
			// $privileges = '';
			// $status ='';
			$groupID = rand();
            $stmt->bind_param("sss", $_POST['groupName'], $_POST['groupDescription'], $groupID);
			if(!$stmt->execute()) echo $stmt->error;		
            header('Location: creatGroup.php?error');
        } 
        else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 6 fields.
            echo 'Couuyyyyld not prepare statement!';
        }

	header("location: group.php?signupsuccess");
?>