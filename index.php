<!doctype html>
<html>
	<head>
		<meta charset='utf8'>
		<style>
			*{
				box-sizing: border-box;
				font-family: 'Monda', sans-serif;
			}
		</style>
	</head>
	<body>
		<div>
			<p>Join room</p>
			<form action='room.php' method='POST'>
				<input type='text' name='username' class='usernameJoin' placeholder='username'>
				<input type='text' name='room_id' placeholder="room id">
				<input type='submit' name='join' value="Submit">
			</form>
		</div>
		<div>
			<p>Create new room</p>
			<form action='room.php' method='POST'>
				<input type='text' name='username' class='username' placeholder='username'>
				<input type='text' name='room_name' class='room_name' placeholder="room name">
				<input type='submit' name='create_new' value="Submit">
			</form>
		</div>
		<p>No spaces in names</p>
	</body>
</html>