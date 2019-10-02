<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Регистрация</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<?php
session_start();
require('connect.php');

if(isset($_POST['username']) and isset($_POST['password'])){
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = "SELECT * FROM users  WHERE username='$username' and password='$password'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($result);

	if ($count == 1){
		$_SESSION['username'] = $username;
	}else {
		$fsmsg = "Неверный логин или пароль";
	}
}

if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	header('Location: start_page.php');
}
?>
<body>
	<div class="log-box">
		<h2>Вход</h2>
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
			<a href="index.php" class="btn btn-a-login">Регистрация</a>
		</form>
	</div>
</body>
</html>