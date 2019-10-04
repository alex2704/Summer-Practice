<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8" >
	<meta name="viewport" content="width=device-width, initial scale=1">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<title>Ответить</title>
</head>
<body>
	<?php
	require_once('connect.php');
	session_start();
	function CheckRatingStatus($id_q, $username, $connection){
		$query = "SELECT * FROM rating_status WHERE id_rating='$id_q' AND username='$username'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		if(mysqli_num_rows($result)==0){
			return 'enabled';
		}
		else{
			return 'disabled';
		}
	}
	$id_question = $_GET['num'];
	$query = "SELECT * FROM questions WHERE id='$id_question'";
	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count = mysqli_num_rows($result);
	$user = NULL;
	$header = NULL;
	$content = NULL;
	$date = NULL;
	$status = NULL;
	$rating = NULL;

	if ($count == 1){
		$row = mysqli_fetch_array($result);
		$user = $row['user']; 
		$header = $row['header'];
		$content = $row['content'];
		$date = $row['date_question'];
		$status = $row['status'];
		$rating = $row['rating'];
		if($status == 1){
			$status_q = "Вопрос открыт:";
		}else{
			$status_q = "Вопрос закрыт:";
		}
		if($rating == 0 or $rating == ""){
			$rating = 0;
		}
	}else {
		$fmsg = "Ошибка";
	}

	if(isset($_POST['up-rating'])){
		$up = $rating + 1;
		$query = "UPDATE questions SET rating = $up WHERE id=$id_question";
		$result = mysqli_query($connection, $query);
		$id_rating = $id_question;
		$username_current = $_SESSION['username'];
		$status_rating = 1;
		$query_rating = "INSERT INTO rating_status (id_rating, username, status_rating) VALUES ('$id_rating','$username_current', '$status_rating')";
		$result_rating = mysqli_query($connection, $query_rating);
		header('Refresh:0');
	}
	if(isset($_POST['close_id'])){
		$status = 0;
		$query = "UPDATE questions SET status = $status WHERE id=$id_question";
		$result = mysqli_query($connection, $query);
	}
	if(isset($_POST['content_answer'])){
		$answer = $_POST['content_answer'];
		$user_answer = $_SESSION['username'];
		$date_answer = date("Y-m-d H-i-s");
		$query = "INSERT INTO answers (user, id_question, answer, date_answer) VALUES ('$user_answer', $id_question, '$answer', '$date_answer')";
		$result = mysqli_query($connection, $query);
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
					<a class="nav-link exit-btn" href="#">Задать вопрос <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link  exit-btn" href="logout.php">Выход</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="wrapper-content-answer container">
	<header>
		<h2 class="h2-class"><?php echo $header ?></h2>
		<span class="description-question">Спросил: <?php echo $user; echo" ".$status_q." ".$date;?></span>
		<span class="rating-question description-question"><?php echo "Текущий рейтинг вопроса: ".$rating;
		$property_status = CheckRatingStatus($id_question, $_SESSION['username'], $connection);
		if($_SESSION['username'] != $user and $status == 1){
			echo "<form method='POST'>
			<input type='submit' name='up-rating' value='Поднять рейтинг вопроса'class='btn btn-secondary btn-up-rating' $property_status></input>
			</form>";
		}
		?></span>
		<?php 
		if($_SESSION['username'] == $user and $status == 1){
			echo "<form method='POST'>
			<input type='hidden' name='close_id' value='$id_question'>
			<input type='submit' value='Закрыть вопрос'class='btn btn-primary'></input>
			</form>";
		}
		else if($_SESSION['username'] == $user and $status != 1){
			echo "<form method='POST'>
			<input type='hidden' name='close_id' value='$id_question'>
			<input type='submit' value='Закрыть вопрос'class='btn btn-primary' disabled></input>
			</form>";
		}
		?>
	</header>
	<article class="container">
		<p class="content-answer"><?php echo $content ?></p>
	</article>
	<article class="answer-textarea-wrapper">
		<?php
		if($_SESSION['username'] != $user and $status == 1){
			echo"
		<form method='POST'>
			<textarea class='answer-textarea' name='content_answer' required></textarea>
			<input type='submit' value='Ответить' class='btn btn-primary'>
		</form>";
		}
		?>
	</article>
	<article>
		<?php
		$query = "SELECT * FROM answers WHERE id_question = $id_question";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		while($row = mysqli_fetch_array($result)){
				$id_user_answer = $row['id'];
				$name_user_answer=$row['user'];
				$date_user_answer = $row['date_answer'];
				$user_answer = $row['answer'];
				echo "
				<div class='user-answer-wrapper'>
				<span class='name-user-answer'>$date_user_answer $name_user_answer</span>
				<p class='user-answer'>$user_answer</p>
				</div>";
			}
			?>
	</article>
	</div>
<?php else: header('Location: index.php');?>
<?php endif; ?>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</html>