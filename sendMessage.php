<?php
	session_start();
	if(isset($_POST['message'])){
		$room = fopen($_SESSION['roomPath'].'.txt', "a");
		fwrite($room, $_SESSION['username'].' '.$_POST['message'].PHP_EOL);
	}
?>