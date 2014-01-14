<?php
// class to connect to and update the database
class dbConnect {
	
	private $con;

	function dbConnect() {
		include_once("config.php");
		$this->db_connect($host, $user, $pass, $db);
	}

	// start a new connection
	private function db_connect($host, $user, $pass, $db) {
		$this->con = mysqli_connect($host, $user, $pass, $db);
	}

	// add the new visit to the database
	function add_download($ip_address, $file, $referer, $visitor_id) {
		$ip_address = mysqli_real_escape_string($this->con, $ip_address);
		$file = mysqli_real_escape_string($this->con, $file);
		$referer = mysqli_real_escape_string($this->con, $referer);
		$visitor_id = mysqli_real_escape_string($this->con, $visitor_id);
		$time = mysqli_real_escape_string($this->con, date(Y-m-d));
		
		// simple download count tracking
		$sql = sprintf("UPDATE counter SET count=count+1 WHERE file = '%s' AND date = '%s'", $file,$time);
		if ($result = $this->con->query($sql)) {
            return true;
        }
        else {
			mysqli_query($this->con, "INSERT INTO counter
						(file, date, count)
						VALUES ('$file', '$time', '1')");      
        }

		// more advanced tracking
		mysqli_query($this->con, "INSERT INTO download_tracking
							(visitor_id, ip_address, file, referer)
							VALUES ('$visitor_id', '$ip_address', '$file', '$referer')");
	}
}
?>