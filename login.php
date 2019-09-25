<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Авторизация</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php
require('connect.php');

if(isset($_POST['username']) && isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "INSERT INTO users (username, password) VALUES ('$username','$password')";
	$result = mysqli_query($connection, $query);

	if($result){
		$smsg = "Регистрация прошла успешно";
	} else{
		$fsmsg = "Ошибка";
	}
}
?>
	<div class="log-box">
		<h2>Авторизоация</h2>
		<?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"><?php echo $smsg; ?></div><?php } ?>
		<?php if(isset($fsmsg)){ ?><div class="alert alert-danger" role="alert"><?php echo $fsmsg; ?></div><?php } ?>
		<form method="POST">
			<div class="log-inputBox">
				<input type="text" name="username" required="">
				<label for="">Логин</label>
			</div>
			<div class="log-inputBox">
				<input type="password" name="password" required="">
				<label for="">Пароль</label>
			</div>
			<input type="submit" name="" value="Войти">
		</form>
	</div>
</body>
</html>