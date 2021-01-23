<?php
// Author: Judy Mezaber


$dbServerName = "fzc353.encs.concordia.ca";
$dbUsername = "fzc353_2";
$dbPassword = "brgNNr";
$dbName = "fzc353_2";


// $dbServerName = "localhost";
// $dbUsername = "root";
// $dbPassword = "";
// $dbName = "con";

$conn = mysqli_connect($dbServerName, $dbUsername, $dbPassword, $dbName);

// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $conn->prepare('SELECT username, Passsword, Email FROM Members WHERE id = ?');

// In this case we can use the account ID to get the account info.

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $passsword, $email,);
$stmt->fetch();
$stmt->close();
$_SESSION["username"] = $username;
?>