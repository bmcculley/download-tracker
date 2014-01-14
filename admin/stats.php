<?php
/**
 * Return download count data as json
 */

include_once("../_inc/config.php");
$con = mysqli_connect($host,$user,$pass,$db);

$sql = sprintf("SELECT date, count FROM counter ORDER BY date");
$data = array();

if ($result = $con->query($sql)) {

	for ($x = 0; $x < $result->num_rows; $x++) {
		$data[] = $result->fetch_assoc();
	}
	echo json_encode($data);
}
else {
    return false;
}

?>