<?php
	require "../db.php";

	$data = $_POST;

	if ( isset($data['add_news'])) {

		$errors = array();

		if ( empty($errors) ) {

			// при добавление файла в директорию, меняется имя на уникальное
			$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$new_name = uniqid().'.'.$extension;
			move_uploaded_file($_FILES['file']['tmp_name'], '../file/'.$new_name);

			$post = R::dispense('posts'); // создать таблицу

			$post->title = $data['title'];
			$post->content = $data['content'];
			$post->theme = $data['theme'];
			$post->categoria = $data['categoria'];
			$post->author = $_SESSION['logged_user']->login;
			$post->view = $_SESSION['view'] = 0;
			$post->image = $new_name;

			R::store($post); // поместить все данные в таблицу

			header('Location: ../index.php');
        	exit();
		}else{
			echo '<div id="errors">'.array_shift($errors).'</div>';
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Wires, Новини, Wires створити публікацію, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="description" content="Створи сторінку з новиною, на якій ти зможеш розказати про себе, а також розказати цікаву історію!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Wires - створи свою публікацію!</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="stylesheet" href="../css/control_post.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<script src="https://cdn.tiny.cloud/1/fmqoa654k2vb0citdl58kaswkrwdfudss1a7nd3kq89dfbj0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

	<section class="container-fluid section-write" id="write">
		<header class="header-menu">
			<h1 class="title-content">Напиши унікальну публікацію</h1>
			<div class="header-button header-button-add">
				<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon add"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</header>

		<?php if(isset($_SESSION['logged_user'])): ?>

		<form class="write" method="POST" enctype="multipart/form-data">
			<div class="row__form">
				<input type="text" name="title" maxlength="100" placeholder="Назва публікації" required>
				<select name="categoria" class="dropdown-select">
				  <option>wires</option>
				  <option>ігри</option>
				  <option>код</option>
				  <option>системне залізо</option>
				  <option>проблема? відповідь!</option>
				  <option>кіна та серіали</option>
				  <option>книги</option>
				  <option>блог</option>
				  <option>спорт</option>
				</select>
			</div>

			<div class="isset-image">
				<p><i>Обов'язково виберіть широкоформатні зображення, щоб добре відображались! І доброю якісттю</i></p>
				<input type="file" name="file" id="image" class="image" accept=".jpg, .jpeg, .png, .gif" required></div>
			</div>

			<textarea type="text" name="theme" class="theme" cols="90" rows="5" placeholder="Опишіть коротко про що публікація!" required></textarea>

			<textarea id="content" name="content" rows="20" placeholder="Напишість публікацію, яка зацікавить користувача!"></textarea>

			<a id="modalBtn" class="button">Добавити <img src="../img/icons/dark/done.png" width="40px" alt="icon done"></a>
			
			<div class="modal">
				<div class="modal-content">
					<span class="close-icon"><img src="../img/icons/dark/close.png" width="20px" alt="icon close"></span>
					<div class="modal-body">
						<h1>Ви впевнені?</h1>
						<p>Правильно ввели інформацію в поля?</p>
						<button class="button" name="add_news">Так <img src="../img/icons/dark/done.png" width="40px" alt="icon done"></button>
					</div>
				</div>
			</div>
		</form>

		<style> .login{ display: none; } </style>

		<?php else : ?>

			<style> 
				.logout{ display: none; } 
				.container-center{ width: 100%;  }
			</style>

			<div class="background logout-table">
				<h2>Зареєструйтеся на сайті або увійдіть у свій аккаунт</h2>
			</div>
			
		<?php endif;?>

	</section>

	<section class="container-fluid no-write">
		<div class="header-button-add" style="margin-top: 20px; display: flex; justify-content: center;">
			<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon add"></a>
			<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
		</div>

		<div class="background">
			<h2>Щоб добавити публікацію, зайдіть через комп'ютер, або включіть на смартфоні комп'ютерну версію сайта.</h2>
		</div>
	</section>

	<script src="../js/modal.js"></script>
	<script src="../js/background-setting.js"></script>
	
	<script>
		tinymce.init({
			selector : "#content",
    		plugins: "link image code",
    		toolbar: 'undo redo | listnumber | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | copy paste| code'
		});
	</script>

</body>
</html>