<?php
// Author: Omar SALAHDDINE
session_start();
session_destroy();
// Redirect to the login page:
header('Location: homepage.html');
?>