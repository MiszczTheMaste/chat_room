<?php
	session_start();
	if(isset($_POST['current'])){
		$userArray = [];
		$userList;
		$roomData = file($_SESSION['roomPath'].'-data.txt');
		
		$roomData[1] = preg_replace('/([\r\n\t])/','', $roomData[1]);
		
		$userArray = explode(' ', $roomData[1]);
		echo json_encode($userArray);
		
	}
?>