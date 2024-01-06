<?php
	
	require "../db.php";

	$data = $_POST;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Wires, Новини, Wires головна сторінка, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="description" content="Сайт блог новини, на якому ти показуэш себе та свій розвиток у суспільному житті. Розкажи новини, які тебе зацікавили!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Wires -  настройки акаунта!</title> 
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body>

	<?php if (isset($_SESSION['logged_user'])): ?>

		<section class="container-fluid section-post">
			<header class="header-menu">
				<h1 class="title-content">Налаштування Профілю</h1>
				<div class="header-button">
					<a href="../index.php" class="button" style="margin-right: 20px;">Головна <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</header>

			<div class="wrapper" id="wrapper-button">
			<a href="../index.php" class="logo">Wires</a>

			<nav>
				<ul class="nav">
					<li>
						<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="img/icons/dark/home.png" width="40px" alt="icon home"></a>
					</li>
					<li>
						<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					</li>
					<li>
						<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					</li>
				</ul>
			</nav>

			<footer>
				<hr>
				<p>© Copyright 2021 wires.com</p>
			</footer>
		</div>

		<div class="background" id="background">
			<h3>Змінити Аватарку</h3>
			<form action="../index.php" class="set_avatar" method="post" enctype="multipart/form-data">
				<input type="file" class="image" name="avatar" accept="image/*">
				<button type="submit" class="button-back" name="set_avatar">Зберегти</button>
			</form>
		</div>

		<div class="background" id="background">
			<h3>Змінити Колір Фону</h3>
			<p>Колір зберігається автоматично</p>
			<div class="background-color">
				<button onclick="setBackgroundColor('#D6E4E5')"></button>
				<button onclick="setBackgroundColor('#D3D3D3')"></button>
				<button onclick="setBackgroundColor('#B7B78A')"></button>
				<button onclick="setBackgroundColor('#5D9C59')"></button>
				<button onclick="setBackgroundColor('#ADD8E6')"></button>
				<button onclick="setBackgroundColor('#FDF0E0')"></button>
			</div>
		</div>

		<div class="background" id="background">
			<h3>Змінити Колір Тексту</h3>
			<p>Колір зберігається автоматично</p>
			<div class="text-color">
				<button class="color-btn" data-color="#000000"></button>
				<button class="color-btn" data-color="#DF2E38"></button>
    			<button class="color-btn" data-color="#609EA2"></button>
    			<button class="color-btn" data-color="#4B56D2"></button>
    			<button class="color-btn" data-color="#1C82AD"></button>
    			<button class="color-btn" data-color="#852999"></button>
			</div>
		</div>

		</section>
		
	<?php endif ?>

	<?php if(isset($_SESSION['logged_user'])): ?>
					
		<style> .login{ display: none; } </style>

    <?php else :?>

        <style> .logout{ display: none; } </style>
		
    <?php endif;?>

    <script src="../js/adaptation_menu.js"></script>
	<script src="../js/background-setting.js"></script>
</body>
</html>