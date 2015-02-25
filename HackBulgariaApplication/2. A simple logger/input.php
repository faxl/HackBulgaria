<?php
	include_once('lib.php');

	$level = $_POST['level'];
	$message = $_POST['message'];

	$logger = new FileLogger('message.log');
	$logger->log((int) $level, $message);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>