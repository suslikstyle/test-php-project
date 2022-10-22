<?php
	require_once ".conf.php";

	unset($_SESSION['logged_user']);
	header('Location: /test-php-project/');

?>