<?php
	session_start();
	if(isset($_POST['current'])){
		$handle = fopen($_SESSION['roomPath'].'.txt', "r");
		$newMessages = [];
		$count = 0;
		$lastLine = intval($_SESSION['lastMessage']);
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				if($count >= $lastLine){
					array_push($newMessages, $line);
				}
				$count++;
			}
		}
		$_SESSION['lastMessage'] = $count;
		echo json_encode($newMessages);
	}
?>