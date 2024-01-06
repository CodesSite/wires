<?php 
	require "../db.php";

	$data = $_POST;

	// получить данные в posts по id
	$post_id = $_GET['post_id'];
	$posts = R::load('posts', $post_id);

if (isset($data['add_answer'])) {
    $date = date('d.m.y');
    $_SESSION['post_id'] = $_GET['post_id'];

    $comment = R::dispense('answers');

    $comment->post_id = $posts->id;
    $comment->user_id = $_SESSION['logged_user']->id;
    $comment->login = $_SESSION['logged_user']->login;
    $comment->comment = $data['answer'];
    $comment->date = $date;

    R::store($comment);

    header("Location: ../index.php");
    exit();
}

	// просмотры
	$id = $posts['id'];
	$view = "UPDATE `posts` SET `view` = `view` + 1 WHERE `id`= $id";
	R::exec($view);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="<?php echo $posts['title'] ?>, <?php echo $posts['author'] ?>, Wires, Новини, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="author" content="<?php echo $posts['author'] ?>">
	<meta name="description" content="<?php echo $posts['theme'] ?>">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title><?php echo $posts['title'] ?> - Wires</title> 
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

	<aside class="wrapper wrapper-adaption">
		<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>

		<nav>
			<ul class="nav">
				<li>
					<a href="#news" class="active">
						<span>Головна</span>
					</a>
				</li>
				<li>
					<a href="#profile">
						<span>Мій профіль</span>
					</a>
				</li>
				<li>
					<a href="#tegs">
						<span>Категорії</span>
					</a>
				</li>
				<li class="mobile-nav">
					<a href="../post/add.php">
						<span>Добавить публікацію</span>
					</a>
				</li>
				<li>
					<a href="#about">
						<span>Про що сайт?</span>
					</a>
				</li>
				<li>
					<a href="#rule">
						<span>Правила</span>
					</a>
				</li>
				<li>
					<a href="#contact">
						<span>Контакти</span>
					</a>
				</li>
				<li class="mobile-nav">
					<a href="../reg-login/signup.php" class="login">Увійти / Реєстрація</a>
				</li>
				<li class="mobile-nav">
					<a href="../reg-login/logout.php" class="logout">Вийти</a>
				</li>
			</ul>
		</nav>

		<footer>
			<hr>
			<p>© Copyright <?php echo date('Y');?> Wires</p>
		</footer>
	</aside>

	<div class="nav-toggler"></div>

	<?php if($posts): ?>
	<section class="container-fluid section-post">
		<header class="header-menu">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="header-button">
				<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</header>

		<div class="post">
			<div class="content-post">
				<div class="background">
					<h1 class="title-content"><?php echo $posts['title'] ?></h1>
					<hr style="margin-top: 10px;">
					<div class="info-post">
						<div class="one-section">
							<p>Автор: <?php echo $posts['author'] ?></p>
							<p>Дата публікації: <?php echo $posts['datatime'] ?></p>
						</div>
						<div class="two-section">
							<p>Категорія: <?php echo $posts['categoria'] ?></p>
							<p>Переглядів: <?php echo $posts['view']; ?></p>
						</div>
					</div>
					<hr style="margin-bottom: 10px;">
					<p style="line-height: 50px;"><?php echo $posts['content'] ?></p>
				</div>

				<?php if(isset($_SESSION['logged_user'])): ?>

					<div class="between-button">
						<a id="modalBtn" class="button">Відповісти <img src="../img/icons/dark/answer.png" style="width: 40px" alt="icon answer"></a>
						<a id="modalBtn" class="button">Поскаржитися <img src="../img/icons/dark/report.png" style="width: 40px" alt="icon archive"></a>
					</div>
			
					<form action="../post/post.php" method="POST">
						<div class="modal">
							<div class="modal-content">
								<span class="close-icon"><img src="../img/icons/dark/close.png" style="width: 20px" alt="icon close"></span>
								<div class="modal-body">
									<h1>Відповідь на публікацію!</h1>
									<p>Напишіть, що ви думаєте</p>
									<textarea type="text" name="answer" class="answer-text" cols="70" rows="12"></textarea>
									<button class="button" name="add_answer">Готово! <img src="../img/icons/dark/done.png" style="width: 40px" alt="icon done"></button>
								</div>
							</div>
						</div>
					</form>

				<?php else : ?>

					<div class="background">
						<h2>Щоб добавити коментарії, потрібно зареєстуватись або увійти на сайті</h2>
					</div>
	
				<?php endif;?>

				<?php 

					$find_comments = R::findAll('comments'); 

					 foreach($find_comments as $comments):

						$user_id = $comments->user_id;
						$avatar = R::getCell('SELECT avatar FROM users WHERE id = ?', [$user_id]);
				 ?>

					

				<?php endforeach; ?>
			</div>


			<aside class="sidebar">
				<div class="new-posts"> 
					<h2>Останні публікації</h2>
					<?php $query = R::findAll('posts', ' ORDER BY id DESC LIMIT 2 '); ?>

					<?php foreach ($query as $post): ?>
						<div class="col-news-sidebar">
							<img src="../file/<?php echo $post['image'] ?>"  alt="<?php echo $post['title'] ?>" alt="<?php echo $post['title'] ?>">
								<div class="foreword">
									<a href="../post/post.php?post_id=<?php echo $post['id'] ?>"><?php echo mb_substr($post['title'], 0, 45) ?></a>
									<p><?php echo mb_substr($post['theme'], 0, 100) ?></p>
								</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="col-advertisement-sidebar background">
					<p>Тут може бути ваша реклама! :)</p>
				</div>
				
				<div class="new-posts">
					<h2 style="margin-top: 30px;">Популярні публікації</h2>
					<?php $query_best = R::findAll('posts', 'ORDER BY view DESC LIMIT 2'); ?>

					<?php foreach ($query_best as $post): ?>
						<div class="col-news-sidebar">
							<img src="../file/<?php echo $post['image'] ?>"  alt="<?php echo $post['title'] ?>" alt="<?php echo $post['title'] ?>">
								<div class="foreword">
									<a href="../post/post.php?post_id=<?php echo $post['id'] ?>"><?php echo mb_substr($post['title'], 0, 45) ?></a>
									<p><?php echo mb_substr($post['theme'], 0, 100) ?></p>
								</div>
						</div>
					<?php endforeach; ?>		
				</div>
			</aside>
		</div>
	</section>	

	<?php else : ?>
		<h1>Виникла помилка</h1>
	<?php endif; ?>

<?php if(isset($_SESSION['logged_user'])): ?>
			
	<style> .login{ display: none; } </style>

<?php else : ?>

	<style> .logout{ display: none; } </style>
	
<?php endif;?>
	
	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/modal.js"></script>
	<script src="../js/background-setting.js"></script>
</body>
</html>