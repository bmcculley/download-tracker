<?php
/*
 * Page for users to login to the admin panel
 */
session_start();
require_once('login_controller.php');

$login = new Login();

if (isset($_POST['Submit'])) {
	$login->user_login($_REQUEST['username'], $_REQUEST['password']);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Login page</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
		<style type="text/css">
		<!--
		.wrapper {
			max-height: 300px;
			max-width: 300px;
			margin: 0 auto;
			position: absolute;
		    left: 50%;
		    top: 50%;
		    margin-left: -100px;
		    margin-top: -100px;
		}
		.submit {
			float: right;
		}
		-->
		</style>
	</head>

	<body onload='setFocus()'>
		<div class="wrapper">
			<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<fieldset>
					<legend>Login:</legend>
					<label for="username">Username:</label><br/>
					<input type="text" id="username" name="username" size="20" value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : $my_access->user; ?>"><br>
					<label for="password">Password:</label><br/>
					<input type="password" id="password" name="password" size="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"><br>
					<br/>
					<input type="submit" class="submit" name="Submit" value="Login">
			</fieldset>
			</form>
		</div>
		<script>
		function setFocus(){
		    document.getElementById("username").focus();
		}
		</script>
	</body>
</html>