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
	?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">
			<?php echo $_SESSION['username'];?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link exit-btn" href="ask.php">Задать вопрос <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Dropdown
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="logout.php">Выход</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Поиск">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
			</form>
		</div>
	</nav>
	<article class="container-fluid">
		<div class="row">
		<div class="col-lg-2 col-md-2"></div>
		<div class="row col-lg-8 col-md-8">
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Имя пользователя</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Вопрос</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Дата</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Актуальность</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'>Рейтинг</div>
			<div class='col-lg-2 col-md-2 bd-question-list name-bd-question-list'></div>
			<?php
			$query = "SELECT * FROM questions";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			while($row = mysqli_fetch_array($result)){
				$name=$row['user'];
				$header = $row['header'];
				$content = $row['content'];
				$date = $row['date_question'];
				$status = $row['status'];
				$rating = $row['rating'];
				if($status == 1){
					$isactive = 'активен';
				}else{
					$isactive = 'закрыт';
				}
				if($rating == "" or $rating == 0){
					$rating = "никто не оценил";
				}
				echo "
				<div class='col-lg-2 col-md-2 bd-question-list'>$name</div>
				<div class='col-lg-2 col-md-2 bd-question-list'><a href='answer.php'>$header</a></div>
				<div class='col-lg-2 col-md-2 bd-question-list'>$date</div>
				<div class='col-lg-2 col-md-2 bd-question-list'>$isactive</div>
				<div class='col-lg-2 col-md-2 bd-question-list'>$rating</div>
				<div class='col-lg-2 col-md-2 bd-question-list'><a href='answer.php'>Ответить</a></div>";
			}
			?>
		</div>
		<div class="col-lg-2 col-md-2"></div>
		</div>
	</article>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>