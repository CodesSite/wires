<?php

require "../db.php";
$data = $_POST;

if (isset($data['forgot'])) {
	$user = R::findOne("users", "email = ?", array($data['email']));
	if ($user) {
		$key = md5($user->login.rand(1000, 9999));
		$user->change_key = $key;
		R::store($user);

		$url = '../mail/newpass.php?key='.$key;
		$message = $user->login.", був виконаний запрос на відновлення пароля, будь-ласка перейдіть за посиланням: ".$url."\n\n Якщо це були не ви, тоді рекоментуємо змінити пароль!";

		mail($data['email'], "Змінення пароля", $message);
		header('Location: /');
	}else{
		echo "Цей користувач не зареєстрований";
	}
}
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Відновлення пароля до свого аккаунту на Wires</title>
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/login.css">
	<link rel="stylesheet" href="../css/grid.css">
</head>
<body>

	<div class="container-register">
		<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
		<form action="../reg-login/login.php" method="POST">
			<h3 style="text-align: center;">Відновлення пароля</h3>
			<input type="email" name="email" placeholder="Email">
			<button type="submit" class="button" name="forgot">Відправити</button>
		</form>
	</div>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	
</body>
</html>