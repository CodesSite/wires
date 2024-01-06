<?php
	require "../db.php";

	$data = $_POST;

	$page= isset($_GET['page']) ? $_GET['page']: 1;

	$limit=20;

	$query = R::findAll('posts', 'ORDER BY id DESC LIMIT '.(($page-1)*$limit).', '.$limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Мої публікації Wires, пости, Wires, <?php echo $_SESSION['logged_user']->login ?>">
	<meta name="author" content="<?php echo $_SESSION['logged_user']->login ?>">
	<meta name="description" content="Всі публікації автора <?php echo $_SESSION['logged_user']->login ?> платформи Wires!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Всі публікації <?php echo $_SESSION['logged_user']->login ?> - Wires</title> 
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

	<div class="nav-toggler"></div>

	<section class="container-fluid section-post">
		<div class="header-menu">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="header-button">
				<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</div>

		<div class="wrapper" id="wrapper-button">
		<a href="../index.php" class="logo">Wires</a>

		<nav>
			<ul class="nav">
				<li>
					<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				</li>
				<li>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</li>
				<li>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="login" alt="icon login"></a>
				</li>
			</ul>
		</nav>

		<footer>
			<hr>
			<p>© Copyright 2021 wires.com</p>
		</footer>
	</div>

		<div class="row__news">

		<?php

			// найти имя автора поста и зарегистрированого пользователя
			$search_profile = R::find("posts", "author like ? LIMIT 10", [$_SESSION['logged_user']->login]);

			// вывод постов с одинаковым имям и автором поста
			if($query):

				foreach ($search_profile as $posts):

		?>
			<div class="col-news">
				<a href="../work_post/redaction.php?post_id=<?php echo $posts['id'] ?>"><img src="../img/icons/dark/setting.png" style="width: auto; height: 30px;" alt="icon setting"></a>
				<img src="../file/<?php echo $posts['image'] ?>" alt="">
					<div class="foreword">
						<a href="../post/post.php?post_id=<?php echo $posts['id'] ?>"><?php echo mb_substr($posts['title'], 0, 45); ?></a>
						<p><?php echo mb_substr($posts['theme'], 0, 100) ?></p>
					</div>
			</div>

				<?php endforeach; ?>

			<?php endif ?>

		</div>
		</section>

	<?php if(isset($_SESSION['logged_user'])): ?>
			
		<style> .login{ display: none; } </style>

	<?php else : ?>

		<style> .logout{ display: none; } </style>

		<div class="logout-table">
			<h2>Зареєструйтеся на сайті або увійдіть у свій аккаунт</h2>
		</div>
	
	<?php endif;?>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>

</body>
</html>