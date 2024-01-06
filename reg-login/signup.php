<?php 
	require "../db.php";

	$data = $_POST; 

	if (isset($data['do_signup'])) {
		
		$errors = array();

		if (trim($data['login']) == '') {
			$errors[] = "Введіть логін!";
		}

		if (trim($data['name']) == '') {
			$errors[] = "Введіть ім'я!";
		}

		if ($data['psw'] == '') {
			$errors[] = "Введіть пароль!";
		}

		if ($data['psw_repeat'] != $data['psw']) {
			$errors[] = "Введіть правильно повторний пароль!";
		}

		if (trim($data['email']) == '') {
			$errors[] = "Введіть Email!";
		}

		if (trim($data['region']) == '') {
			$errors[] = "Виберіть регіон";
		}

		if (R::count('users', "login = ?", array($data['login']))>0){
			$errors[] = "Користувач з таким Логіном уже існує!";
		}

		if (R::count('users', "email = ?", array($data['email']))>0){
			$errors[] = "Користувач з таким Email уже існує!";
		}

		if (empty($errors)) {
			$user = R::dispense('users');
			$user->name = $data['name'];
			$user->psw = password_hash($data['psw'], PASSWORD_DEFAULT);
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->region = $data['region'];
			$user->avatar = '1.png';
			R::store($user);
			header('Location: login.php');
			exit();
		}else{
			echo '<div style="position: absolute; bottom: 70px; color: red;">'.array_shift($errors).'</div>';
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Реєстрація, Wires реєстрація, Зареєструватись, зареєстувати аккаунт, Wires, Новини, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини">
	<meta name="description" content="Реєстрація на сайт Wires. Розкажи новини, які тебе зацікавили!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Реєстрація на сайті Wires</title>
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<link rel="stylesheet" type="text/css" href="../css/grid.css">
</head>
<body>

	<form method="POST" style="padding: 40px 0;">

		<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>

		<div class="row">
			<a href="../reg-login/signup.php" class="button">Реєстрація</a>
			<a href="../reg-login/login.php" class="button">Вхід</a>
			<input type="login" name="login" placeholder="Логін Користувача" value="<?php echo @$data['login'] ?>">
			<input type="password" name="psw" placeholder="Пароль" value="<?php echo @$data['name'] ?>">
			<input type="name" name="name" placeholder="Ім'я Користувача" value="<?php echo @$data['psw'] ?>">
			<input type="password" name="psw_repeat" placeholder="Повторіть Пароль" value="<?php echo @$data['psw_repeat'] ?>">
			<input type="email" name="email" placeholder="Email" value="<?php echo @$data['email'] ?>">
			<select name="region" class="dropdown-select">
				<option>Україна</option>
				<option>United States America (USA)</option>
				<option>Россия</option>
				<option>Deutschland</option>
			</select>
			<button class="button" type="submit" name="do_signup">Зареєструватись <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></button>
		</div>
	</form>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>

</body>
</html>