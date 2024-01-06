<?php
	require "../db.php";

	$data = $_POST;
	// при нажатие кнопки 'Войти'
	if ( isset($data['do_login']) ) {
		$errors = array(); // ошибки в переменной
		$user = R::findOne('users', 'login = ?', array($data['login'])); // проверка на логин

		if($user){
			//логин существует
			if(password_verify($data['psw'], $user->psw)){
				$_SESSION['logged_user'] = $user;
				header ('Location: ../index.php');
        		exit();

			}else{
				$errors[] = 'Невірно введений паролль!';
			}
		}else{
			$errors[] = 'Користувач з таким Логін не знайдено!';
		}

		// если не пусто в переменной $errors (ошибки), тогда выводим ошибку
		if ( ! empty($errors) ) {
			echo '<div style="position: absolute; bottom: 100px; color: red;">'.array_shift($errors).'</div>';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Вхід, Wires вхід, Увійти, увійти в аккаунт, Wires, Новини, Блог, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="description" content="Увійди у свій аккаунт на сайті Wires. Розкажи новини, які тебе зацікавили!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Вхід на сайт Wires</title>
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/login.css">
	<link rel="stylesheet" href="../css/grid.css">
</head>
<body>

		<form action="../reg-login/login.php" method="POST" style="padding: 40px 0;">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="row">
				<a href="../reg-login/signup.php" class="button">Реєстрація</a>
				<a href="../reg-login/login.php" class="button">Вхід</a>
				<input type="login" placeholder="Логін Користувача" name="login" value="<?php echo @$data['login']; ?>">
				<input type="password" placeholder="Пароль" name="psw" value="<?php echo @$data['psw']; ?>">
				<button class="button" name="do_login">Увійти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></button>
			</div>
			<a href="../mail/forgot.php" class="repair-password" >Забули пароль?</a>
		</form>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	
</body>
</html>