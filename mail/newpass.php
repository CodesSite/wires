<?php
	
require "../db.php";
$data = $_GET;

if ($_SESSION['users'] != NULL) header('Location: ../index.php');
if ($data['key'] == NULL) header('Location: ../index.php');

$user = R::findOne("users", "change_key = ?", array($data['key']));

if (!$user) header('Location: ../index.php');

if (isset($data['change'])) {
	$user->psw = password_hash($data['password_2'], PASSWORD_DEFAULT);
	$user->change_key = NULL;
	R::store($user);
	header('Location: ../reg-login/login.php');
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">>
	<title>Введення нового пароля на Wires</title>
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/login.css">
	<link rel="stylesheet" href="../css/grid.css">
</head>
<body>

	<div class="container-register">
		<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
		<form action="../newpass.php" method="GET">
			<h3 style="text-align: center;">Новий пароль</h3>
			<input type="hidden" name="key" value="<?php echo $data['key']; ?>">
			<input type="password" name="password_1" placeholder="Пароль">
			<input type="password" name="password_2" placeholder="Повторіть пароль">
			<button type="submit" class="button" name="change">Змінити пароль</button>
		</form>
	</div>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	
</body>
</html>