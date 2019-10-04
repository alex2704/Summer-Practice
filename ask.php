<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8" >
	<meta name="viewport" content="width=device-width, initial scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<title>Задать вопрос</title>
</head>
<body>
	<?php
	require_once('connect.php');
	session_start();

	if(isset($_POST['name_question']) and isset($_POST['content_question'])){
		$user = $_SESSION['username'];
		$theme = $_POST['name_question'];
		$content = $_POST['content_question'];
		$date = date("Y-m-d H-i-s");
		$status = 1;
		$rating = 0;
		$query = "INSERT INTO questions (user, header, content, date_question, status, rating) VALUES ('$user', '$theme','$content', '$date', '$status', '$rating')";
		$result = mysqli_query($connection, $query);

		if($result){
			header('Location: start_page.php');
		} else{
			$fsmsg = "Во время публикации вашего запроса произошшла ошибка, попробуйте позже";
		}
	}
	?>
	<?php if( isset($_SESSION['username']) ) : ?>
	<nav class="navbar navbar-expand-lg navbar-light nav-color">
		<a class="navbar-brand" href="start_page.php">
			@<?php echo $_SESSION['username'];?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="start_page.php">Главная</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link exit-btn disabled" href="#">Задать вопрос <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="logout.php">Выход</a>
				</li>
			</ul>
		</div>
	</nav>
	<header>
		<h2 class="h2-class">Задайте вопрос другим пользователям</h2>
		<?php if(isset($fsmsg)){ ?><div class="alert alert-danger" role="alert"><?php echo $fsmsg; ?></div><?php } ?>
	</header>
	<article class="container-fluid">
		<form method="POST">
			<div class="question">
				<label><strong>Тема вопроса:</strong></label>
				<input type="text" name="name_question" class="col-lg-12" maxlength="150" required="">
				<label><strong>Текст вопроса:</strong></label>
				<textarea name="content_question" required=""></textarea>
			</div>
			<input type="submit" name="" value="Опубликовать вопрос" class="ask_btn btn btn-lg btn-primary">
		</form>
	</article>
	<?php else: header('Location: index.php');?>
<?php endif; ?>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>