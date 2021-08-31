<style>
td { font-size: 14px }
</style>
<meta http-equiv="Content-Type"
    content="text/html; charset=utf-8"
    />
<?php
// show error reporting
error_reporting(E_ALL);

ob_start();

// start php session
header('Cache-Control: no cache'); //no cache
// start php session
session_start();

// set your default time-zone
date_default_timezone_set('Europe/Belgrade');

// home page url
   $home_url="http://localhost/quantox/";
 


?>