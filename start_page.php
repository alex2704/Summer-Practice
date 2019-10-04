<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8" >
	<meta name="viewport" content="width=device-width, initial scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<title>Главная</title>
</head>
<body>
	<?php
	require_once('connect.php');
	session_start();
	$var_val = 2;
	?>
	<?php if( isset($_SESSION['username']) ) : ?>
	<nav class="navbar navbar-expand-lg navbar-light nav-color">
		<a class="navbar-brand" href="#">
			@<?php echo $_SESSION['username'];?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="#">Главная</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link exit-btn" href="ask.php">Задать вопрос <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="logout.php">Выход</a>
				</li>
			</ul>
		</div>
	</nav>
	<article class="container-fluid">
		<div class="row">
		<div class="col-lg-2 col-md-2"></div>
		<div class="row col-lg-8 col-md-8">
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Имя пользователя</div>
			<div class='col-lg-4 col-md-2 bd-question-list name-bd-question-list'>Вопрос</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Дата</div>
			<div class='col-lg-1 col-md-2 bd-question-list name-bd-question-list'>Статус</div>
			<div class='col-lg-1 col-md-2 bd-question-list name-bd-question-list'>Рейтинг</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'></div>
			<?php
			$query = "SELECT * FROM questions";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row = mysqli_fetch_array($result)){
				$id = $row['id'];
				$name=$row['user'];
				$header = $row['header'];
				$date = $row['date_question'];
				$status = $row['status'];
				$rating = $row['rating'];
				if($status == 1){
					$isactive = 'активен';
				}else{
					$isactive = 'закрыт';
				}
				if($rating == "" or $rating == 0){
					$rating = "-";
				}
				echo "
				<div class='col-lg-2 col-md-2 bd-question-list'>$name</div>
				<div class='col-lg-4 col-md-4 bd-question-list'><a href='answer.php?num=$id'>$header</a></div>
				<div class='col-lg-2 col-md-2 bd-question-list'>$date</div>
				<div class='col-lg-1 col-md-1 bd-question-list'>$isactive</div>
				<div class='col-lg-1 col-md-1 bd-question-list'>$rating</div>
				<div class='col-lg-2 col-md-2 bd-question-list'><a href='answer.php?num=$id'>Ответить</a></div>";
			}
			?>
		</div>
		<div class="col-lg-2 col-md-2"></div>
		</div>
	</article>
	<?php else: header('Location: index.php');?>
<?php endif; ?>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>