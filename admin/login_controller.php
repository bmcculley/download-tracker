<?php
/*
 * A Class to control access to the download stats panel.
 */

class Login {

	private $salt = '40be4e59b9a2a2b5dffb918c0e86b3d7';
	private $table_name = 'users';

	function Login() {
		include_once("../_inc/config.php");
		$this->db_connect($host, $user, $pass, $db);
	}

	// start a new connection
	private function db_connect($host, $user, $pass, $db) {
		$this->con = mysqli_connect($host, $user, $pass, $db);
	}

	function user_login($username, $password) {
		$username = mysqli_real_escape_string($this->con, $username);
		$password = md5($password.$this->salt);
		$password = mysqli_real_escape_string($this->con, $password);
		
		$sql = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."' AND active = 'y'";

		if(!$result = mysqli_query($this->con,$sql)){
		    die('There was an error running the query [' . $this->con->error . ']');
		}
		else {
			while($row = $result->fetch_assoc()) {
			    $this->set_user($row['username'], $row['access_level']);
			    header('Location: ./');
			}
		}

		mysqli_close($this->con);
	}

	private function set_user($username, $access_level) {
		setcookie('user', $username);
		$_SESSION['access_level'] = $access_level;
	}

	function access_level() {
		if (isset($_SESSION['access_level'])) {
			return $_SESSION['access_level'];
		}
		else {
			return 0;
		}
	}

	function user_logout() {
		unset($_COOKIE['user']);
		unset($_SESSION['access_level']);
		session_destroy();
		header('Location: ./');
	}

}
?>