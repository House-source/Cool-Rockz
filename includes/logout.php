<?php

// includes/logout.php
// Safely logs the user out of the website by ending their session.

session_start(); // Start or resume the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or homepage
header('Location: ../login.php');
exit();
?>