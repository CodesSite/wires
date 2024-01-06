<?php
	require "../db.php";

	$data = $_POST;

	$page= isset($_GET['page']) ? $_GET['page']: 1;

	$limit=20;

	$user_id = $_GET['user_id'];
	$users = R::load('users', $user_id);
	
	$query = R::findAll('posts', 'ORDER BY id DESC LIMIT '.(($page-1)*$limit).', '.$limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="<?php echo $posts['author'] ?> Wires, публікація автора Wires, публікації автора">
	<meta name="author" content="<?php echo $posts['author'] ?>">
	<meta name="description" content="Всі публікації автора платформи Wires - <?php echo $posts['author'] ?>">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Всі публікації автора <?php echo $users['login'] ?> - Wires</title> 
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

	<div class="nav-toggler profile"></div>

	<section class="container-fluid section-post">
		<header class="header-menu">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="header-button">
				<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</header>

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

		<div class="row__news">

		<?php

			// найти имя автора поста и зарегистрированого пользователя
			$search_profile = R::find("posts", "author like ? LIMIT 10", [ $users['login'] ]);

			// вывод постов с одинаковым имям и автором поста
			if($query):

				foreach ($search_profile as $posts):

		?>
			<div class="col-news">
				<img src="../file/<?php echo $posts['image'] ?>" alt="">
					<div class="foreword">
						<a href="../post/post.php?post_id=<?php echo $posts['id'] ?>"><?php echo mb_substr($posts['title'], 0, 45); ?></a>
						<p><?php echo mb_substr($posts['theme'], 0, 100) ?></p>
					</div>
			</div>

				<?php endforeach; ?>

			<?php endif; ?>

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