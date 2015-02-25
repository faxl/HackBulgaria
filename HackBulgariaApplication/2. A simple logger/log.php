<?php
	$message = $_POST['message'];

	file_put_contents('post.log', $message.PHP_EOL , FILE_APPEND);
?>