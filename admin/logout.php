<?php
/* 
 * Log the user out of the admin section
 */
session_start();
require_once('login_controller.php');
$logout = new Login();
$logout->user_logout();
?>