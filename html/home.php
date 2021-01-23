<?php


// Author: Omar SALAHDDINE
// We need to use sessions, so you should always start sessions using the below code.
session_start();

include_once 'db_connection.php';

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: homepage.html');
	exit;
}

$check_tempID = $_SESSION['id'];
	$check_tempsql = $conn->query("SELECT AdminRights FROM Members WHERE ID = '$check_tempID'");
	$check_result = $check_tempsql->fetch_assoc();
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="mainStyle.css">
  <link href="comments.css" rel="stylesheet" type="text/css">
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
    <br>
    <h1 style =" text-align: center">Timeline</h1>
    <div>
        <p style =" text-align: center">Welcome back, <?=$_SESSION['name']?>!</p>
    </div>
    <div id='post'>
      <!--TEXT UPLOAD FORM-->
      <form action='post.php' method='post' id ='post_form'>
      <script>  
        $(document).ready(function() {
          get_posts();     
          $("#post_form").submit(function () {
            var post = $("#post_body").val();

            $.post('post.php',{post: post},function(data){
              $("#response").html(data);
              get_posts();
              //alert(data);
            });
            return false;
          });

          function get_posts(){
            $.get('posting.php', function(data){
              $('#newsfeed').html(data);
            });
          }
        });
      </script>
      <div id='response'></div>
      <textarea id='post_body' name='post' style="margin: 0px;height: 120px; width: 1669px;" placeholder="Post Something"></textarea>
      <button type='submit' name='submitp' id='submitp' value='Post' style ="height: 40px; width: 1669px;">Post</button>
      </form>
       <!--IMAGE UPLOAD FORM-->
      <form method="POST" action="upload.php" enctype="multipart/form-data">
      <script>  
        $(document).ready(function() {
             get_images();            

            function get_images(){
            $.get('upload.php', function(data){
              $('#newsfeed').html(data);
            });
          }
        });
      </script>

          <input type="hidden" name="size" value="1000000">
          <div>
            <input id="Input" type="file" name="image">
          </div>
          <div>
            <textarea  id="text"   cols="40"  rows="4" name="image_text"  placeholder="Say something about this image..."></textarea>
          </div>
          <div>
            <button type="submit" name="upload" style =" width: 120px;">POST</button>
          </div>
      </form>
      <!--IMAGE UPLOAD FORM-->
    </div>
    <div id='newsfeed'></div>
    <div class="comments"></div>
    <script>
     const comments_page_id = 1; // This number should be unique on every page
     fetch("comments.php?page_id=" + comments_page_id).then(response => response.text()).then(data => {
          document.querySelector(".comments").innerHTML = data;
          document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
             element.onclick = event => {
                event.preventDefault();
                document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
                document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
                  };
              });
              document.querySelectorAll(".comments .write_comment form").forEach(element => {
                element.onsubmit = event => {
                    event.preventDefault();
                    fetch("comments.php?page_id=" + comments_page_id, {
                      method: 'POST',
                      body: new FormData(element)
                    }).then(response => response.text()).then(data => {
                      element.parentElement.innerHTML = data;
                    });
                };
          	});
     });         
     </script>
  </div>
    </div>
</body>
</html>
