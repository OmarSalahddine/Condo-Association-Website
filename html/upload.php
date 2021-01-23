<?php
// Author: Omar SALAHDDINE

 session_start();
 include('db_connection.php');

  // Initialize message variable
  $msg = "";

  // If upload
  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($conn, $_POST['image_text']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (name, image) VALUES ('$image', '$image_text')";
  	// execute query
  	if (mysqli_query($conn, $sql)){

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "<div class='success'>Correctly posted!</div>";
  	}else{
  		echo "<div>Did not work</div>";
      }
  }
}
  $result = mysqli_query($conn, "SELECT * FROM images");
  
  $get_post_user =  $conn -> query("SELECT * FROM members WHERE username='$username'");
  $get_post_user2 = mysqli_fetch_assoc($get_post_user);
  $firstName = $get_post_user2['FirstName'];

  while($row = mysqli_fetch_assoc($result))
             {
              $name = $row["name"];
              $image = $row["image"];
              echo "<div>";
              echo "<a id ='usernamecolor'>".$firstName."</a>";
              echo "<br/>";
              echo "<br/>";
              echo '<img src="images/'.$name.'" style="margin: 0px;height: 500px; width: 750px;">';
              echo "</div>";
             };
?>