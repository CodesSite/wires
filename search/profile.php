<?php 
	require "../db.php";

	$data = $_POST;

	// получити дані про користувача
	$user_id = $_GET['user_id'];
	$users = R::load('users', $user_id);

	$login_users = $users['login'];

    $result = R::getRow('SELECT SUM(view) as s FROM posts WHERE author LIKE ? LIMIT 1', [$login_users]);
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="<?php echo $users['login'] ?>, <?php echo $users['name'] ?>, Wires, Користувач, Автор">
	<meta name="author" content="<?php echo $users['login'] ?>">
	<meta name="description" content="Профіль користувача <?php echo $users['login'] ?> платформи Wires">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Користувач <?php echo $users['login'] ?></title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

	<div class="nav-toggler profile"></div>

	<section class="container-fluid section-post">
		<div class="header-menu">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="header-button">
				<form action="../search/search-result.php" method="post" style="display: flex;">
					<input type="text" class="search" name="search" placeholder="Поиск по сайту">
					<button class="button button-search" name="do_search"><img src="../img/icons/dark/search.png" width="40px"></button>
				</form>
				<a href="../post/add.php" class="button" style="margin: 0 20px 0 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</div>

		<div class="wrapper" id="wrapper-button">
			<a href="../index.php" class="logo">Wires</a>

			<nav>
				<ul class="nav">
					<li><a href="../index.php" class="" style="margin-right: 20px;">На головну</a></li>
					<li><a href="../post/add.php" class="">Добавити публікацію</a></li>
					<li><a href="../reg-login/signup.php" class="login">Увійти / Реєстрація</a></li>
					<li><a href="../reg-login/logout.php" class="logout">Вийти</a></li>
				</ul>
			</nav>

			<footer>
				<hr>
				<p>© Copyright <?php echo date('Y');?> Wires</p>
			</footer>
		</div>


	<?php if($users): ?>
	<div class="background info-profile">
		<form method="POST">
			<div class="base-info">
				<div class="naming">
					<a class="my-photo">
						<img src="../file/avatar/<?php echo $users['avatar']; ?>" alt="avatar">
					</a>

					<div class="my_name">
						<h2><?php echo $users['login']; ?></h2>
						<p><?php echo $users['name'] ?></p>
						<?php

						switch ($users['login']) {
						    case 'Codes_Site':
						        echo '<samp style="color: var(--light-red);">Адмін</samp>';
						        break;
						    case 'Codes_Site':
						    case 'Codes_Sited':
						        echo '<samp style="color: var(--blue);"> Модератор</samp>';
						        break;
						    default:
						        echo '<samp style="color: var(--green);">Користувач</samp>';
						        break;
						}

						?>
					</div>
				</div>
			</div>
		</form>

		<div class="row__profile">
			<p class="article">Кіл-сть публікацій: <span><?php echo R::count('posts', 'author LIKE ?', [$users['login']]); ?></span></p>
			<p class="view">Переглядів: <span><?php print_r($result['s']); ?></span></p>
			<p class="region">Регіон: <span><?php echo $users['region'] ?></span></p>
		</div>
	</div>

	<div class="profile-button">
		<a href="../search/all-posts-author.php?user_id=<?php echo $users['id'] ?>/\?all-posts!-Author" class="button">Публікації користувача <img src="../img/icons/dark/archive.png" width="40px" alt=""></a>
	</div>

	<?php else : ?>
		<h1>Виникла помилка</h1>
	<?php endif; ?>

	</section>

	<?php if(isset($_SESSION['logged_user'])): ?>
			
		<style> .login{ display: none; } </style>

	<?php else : ?>

		<style> .logout{ display: none; } </style>
	
	<?php endif;?>


	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
</body>
</html>