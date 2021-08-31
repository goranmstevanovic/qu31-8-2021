<?php
// core configuration
include_once "config/core.php";

// destroy session, it will remove ALL session settings
session_destroy();
//cache_clear_all();
//sleep(5);




//redirect to login page
header("Location: {$home_url}login.php");
?>