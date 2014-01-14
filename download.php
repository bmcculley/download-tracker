<?php

// include class to connect to the database
require_once('./_inc/dbConnect.php');

$update = new dbConnect();


$ip_address = $_SERVER["REMOTE_ADDR"];
$file = $_GET['f'];
$referer = get_referer();
$visitor_id = md5($ip_address);

// add user visit to the database
$update->add_download($ip_address, $file, $referer, $visitor_id);

// some helper functions
function get_referer() {
	if (isset($_GET['ref']))
		return $_GET['ref'];
	else
		return '';
}

// Download the file
//header("Location: ./".$file.".zip");

?>