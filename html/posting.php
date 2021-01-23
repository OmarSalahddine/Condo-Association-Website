<?php
// Author: Omar SALAHDDINE

//Connecting to the Database
/*
            $mysqli = new mysqli("localhost","root","othemans","CON");
            if ($mysqli -> connect_errno) {
              echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
              exit();
            }
			*/
			
			session_start();
			include('db_connection.php');
			
        //Fectching the posts from the Database
			 $result = $conn -> query("SELECT * FROM posts");
			 
             while($row = mysqli_fetch_assoc($result))
             {
              $id = $row["id"];
              $username = $row["username"];
              $body = $row["body"];
              $date_added = $row["date_added"];
              $hashtags = $row["hashtags"];
              //Fetching Username from the members tables
              $get_post_user =  $conn -> query("SELECT * FROM members WHERE username='$username'");
              //$get_post_user2 = mysqli_fetch_assoc($get_post_user);
			  $get_post_user2 = $get_post_user ->fetch_assoc();
              $firstName = $get_post_user2['FirstName'];
              //outputting In a loop
              echo "<div class='post'>";
              echo "<a id ='usernamecolor'>".$firstName."</a>";
              echo "<br/>";
              echo "<br/>";
              echo $body;
              echo "</div>";
             };
?>
