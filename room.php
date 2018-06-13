<?php
	session_start();
	$roomId = 0;

	if (strpos($_POST['room_name'], ' ') !== false || strpos($_POST['username'], ' ') !== false){
	   header('Location: index.php');
	}
	
	if(isset($_POST['create_new'])){
		$roomId = rand(1,100000);
		$roomList = scandir(getcwd());
		for($i = 0; $i < count($roomList); $i++){
			$roomList[$i] = str_replace('.txt', '', $roomList[$i]);
		}
		$check = true;
		while($check == true){
			for($i = 0; $i < count($roomList); $i++){
				if($roomList[$i] == $roomId){
					$roomId = rand(1,100000); 
				}
				else if($i == count($roomList) - 1){
					$check = false;
				}
			}
		}
		$room = fopen($roomId.".txt", "w");

		$room = fopen($roomId."-data.txt", "w");
		fwrite($room, $_POST['room_name']);
		fwrite($room, PHP_EOL.' '.$_POST['username'].' '.PHP_EOL);
		$_SESSION['username'] = $_POST['username'];
	}
	if(isset($_POST['join'])){
		if(!is_nan($_POST['room_id'])){
			$roomId = $_POST['room_id'];
			$_SESSION['username'] = $_POST['username'];
			$roomData = file($roomId.'-data.txt');
			$roomData[1] = preg_replace('/([\r\n\t])/','', $roomData[1]);
			$tmp = $roomData[1].' '.$_SESSION['username'];
			$room = fopen($roomId."-data.txt", "w");
			fwrite($room, $roomData[0].$tmp);
		}
	}
	$_SESSION['roomPath'] = $roomId;
	$roomWhole = file($_SESSION['roomPath'].'.txt');
	$_SESSION['lastMessage'] = count($roomWhole);
	$roomWhole = file($_SESSION['roomPath'].'-data.txt');
?>
<!doctype html>
<html>
	<head>
		<meta charset='utf8'>
		<title><?php echo $roomWhole[0]; ?></title>
		<style>
			*{
				box-sizing: border-box;
				font-family: 'Monda', sans-serif;
			}
			main > div > div{
				min-height: 20px;
				font-size: 20px;
			}
			main > div > div:first-child{
				display: inline;
				height: 100%;
				line-height: 100%;
			}
			main > div > div:last-child{
				display: inline;
				margin-left: 20px;
			}
			main > div:not(:last-child){
				border-bottom: dashed 1px #000;
				margin-bottom: 5px;
			}
			main > div{
				padding-top 5px;
				padding-bottom: 5px;
			}
			main{
				padding-left: 50px;
				padding-right: 50px;
				overflow: auto;
				width: 80vw;
				height: 60vh;
				border: 2px solid #000;
				position: relative;
				left: 50%;
				transform: translate(-50%, 0);
			}
			header{
				text-align: center;
			}
			header > h3 > span:not(:first-child){
				margin-left: 5px;
			}
			#chat{
				position: relative;
				left: 50%;
				transform: translate(-50%, 0);
				display: table;
				width: 80%;
			}
			#chat > input{
				width: 90%;
			}
			#chat > button{
				width: 9%;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
            window.setInterval("getChat(44);getUsers(44)", 250);
            function refreshDiv(kkk){
				for(var i = 0; i < kkk.length; i++){
					var nmsg = document.createElement("div");
					var usrnm = document.createElement("div");
					var msgtxt = document.createElement("div");
					usrnm.appendChild(document.createTextNode(kkk[i].substr(0,kkk[i].indexOf(' ')) + ':'));
					msgtxt.appendChild(document.createTextNode(kkk[i].substr(kkk[i].indexOf(' ')+1)));
					
					nmsg.appendChild(usrnm);
					nmsg.appendChild(msgtxt);				
					
					document.querySelector('main').appendChild(nmsg);
				}
            }
			function refreshUsers(kkk){			
				var userList = document.querySelector("header > h3");
				userList.innerHTML = '';
				for(var i = 0; i < kkk.length; i++){
					if(kkk[i] != '' && kkk[i] != ' '){
						var usrnm = document.createElement("span");
						usrnm.appendChild(document.createTextNode('@'+kkk[i]));
						userList.appendChild(usrnm);
					}		
				}
            }
			function getChat(kut){
				$.ajax({
					type: "POST",
					url: 'getChat.php',
					dataType:"json",
					data: {
						current: kut
						}
				}).done(function(newMessages) {
					if(newMessages != ''){
						refreshDiv(newMessages);
					}
					 
				});
			}
			function getUsers(usr){
				$.ajax({
					type: "POST",
					url: 'getUsers.php',
					dataType:"json",
					data: {
						current: usr
						}
				}).done(function(userArray) {
					if(userArray != ''){
						refreshUsers(userArray);
					}
					 
				});
			}
        </script>
	</head>
		
	<body>
		<header>
			<h1><?php echo $roomWhole[0];?></h1>
			<h2><?php echo 'ID: '.$roomId;?></h2>
			<h3></h3>
		</header>
		<main>
		</main>
		<div id='chat'>
			<script>
				function pushMessage() {
					$.ajax({
						type: "POST",
						url: 'sendMessage.php',
						data: {
							message: $('#sendMessage').val()
							}
					});
					document.querySelector("#sendMessage").value = '';
				}
			</script>
				<input type='text' id='sendMessage' placeholder='type message...'>
				<button onclick="pushMessage()">send</button>
			<script>
					document.querySelector('#sendMessage').addEventListener("keydown", function (e) {
						if (e.keyCode === 13) { 
						pushMessage()
						}
					});
			</script>
		</div>
	</body>
</html>

