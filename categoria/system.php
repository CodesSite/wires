<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Wires, Новини, Wires категорія системне залізо, системне залізо, Windows 10, процесор, материнська плата, відеокарта">
	<meta name="description" content="Збірки комп'ютерів, рекомендації по комп'ютеру, можете показати свої можливості по комп'ютеру.">
	<title>Wires - Категорія Системне залізо</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body>

	<div class="wrapper">
		<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>

		<nav>
			<ul class="nav">
				<li><a href="../categoria/wires.php" class="active">Wires</a></li>
				<li><a href="../categoria/games.php">Ігри</a></li>
				<li><a href="../categoria/coding.php">Код</a></li>
				<li><a href="../categoria/system.php">Системне залізо</a></li>
				<li><a href="../categoria/noproblem.php">Проблема? Відповідь!</a></li>
				<li><a href="../categoria/film.php">Кіна та серіали</a></li>
				<li><a href="../categoria/book.php">Книги</a></li>
				<li><a href="../categoria/blog.php">Блог</a></li>
				<li><a href="../categoria/sport.php">Спорт</a></li>
			</ul>
		</nav>

		<footer>
			<hr>
			<p>© Copyright <?php echo date('Y');?> Wires</p>
		</footer>
	</div>

	<main class="main-content">

		<div class="nav-toggler"></div>

		<section class="container-fluid section active">
			<div class="header-menu">
				<h1 class="title-content">Категорія Системне залізо</h1>
				<div class="header-button">
					<a href="../index.php" class="button" style="margin: 0 30px 0 30px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
					<a href="../signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</div>

			<div class="row__news">

			<?php
				require '../db.php';

				$categoria = R::findLike( 'posts', [ 'categoria' => [ 'системне залізо' ] ] );

				if ($categoria) {	
					foreach ($categoria as $posts){
						echo '	<div class="col-news">
								<img src="../file/'.$posts['image'].'" alt="системне залізо">
									<div class="foreword">
										<a href="../post/post.php?post_id='.$posts['id'].'">'.mb_substr($posts['title'], 0, 45).'</a>
										<p>'.mb_substr($posts['content'], 0, 248), '...'.'</p>
									</div>
							</div>';
					}

				}else{
					echo "В данній категорії іще нема відповідних публікацій, но ви можете це виправити!";
				}
					
			?>
				
			</div>

		</section>

		<?php if(isset($_SESSION['logged_user'])): ?>
						
			<style> .login{ display: none; } </style>

		<?php else : ?>

			<style> .logout{ display: none; } </style>
				
		<?php endif; ?>

	</main>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
</body>
</html>