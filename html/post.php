<?php
// Author: Omar SALAHDDINE

session_start();
include('db_connection.php');

//include_once 'db_connection.php';
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if(isset($_POST['post'])) {
    if ($stmt = $conn->prepare('INSERT INTO posts (id, username, body, date_added, hashtags) VALUES (?, ?, ?, ?, ?)')) {
        $hastags ='';
        $ID = rand();
        $user = $_SESSION['username'];
        $time = date("Y/m/d");
        $stmt->bind_param("sssss", $ID, $user, $_POST['post'], $time, $hastags);
        if(!$stmt->execute()) echo $stmt->error;		
        echo "<div class='success'>Correctly posted!</div>";
    } else {
        // Something is wrong with the sql statement
        echo 'noooosasot working Could not prepare statement!';
    }

}
?>


