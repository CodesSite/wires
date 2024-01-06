<?php 
	require "../db.php";

	$data = $_POST;

	// совпадение заголовка поста и в поле поиска
    $query = R::findAll('posts', ' title LIKE ? ', [ '%'.$_POST['search'].'%' ]);

    $search_result = R::findAll('users', 'name LIKE ?', [ '%'.$_POST['search'].'%']);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content= "Пошук, Пошук Wires, Wires, Новини, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="description" content="Результати пошуку платформи Wires">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Результати пошуку - Wires</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>
<body>

	<div class="nav-toggler"></div>

	<section class="container-fluid section-post">
		<div class="header-menu">
			<a href="../index.php" class="logo">Wires<sup>Beta</sup></a>
			<div class="header-button">
				<form action="../search/search-result.php" method="post" style="display: flex;">
					<input type="text" class="search" name="search" placeholder="Поиск по сайту">
					<button class="button button-search" name="do_search"><img src="../img/icons/dark/search.png" width="40px" alt="icon search"></button>
				</form>
				<a href="../index.php" class="button" style="margin: 0 20px 0 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</div>

		<div class="wrapper" id="wrapper-button">
		<a href="../index.php" class="logo">Wires</a>

		<nav>
			<ul class="nav">
				<li><a href="../post/add.php">Добавити публікацію</a></li>
				<li><a href="../index.php"style="margin-right: 20px;">На головну</a></li>
				<li><a href="../reg-login/signup.php" class="login">Увійти / Реєстрація</a></li>
				<li><a href="../reg-login/logout.php" class="logout">Вийти</a></li>
			</ul>
		</nav>

		<footer>
			<hr>
			<p>© Copyright <?php echo date('Y');?> Wires</p>
		</footer>
	</div>

		<div class="owl-carousel owl-theme">
		  	<?php if ($search = $_POST['search'] ?: null): ?>
		  		<?php foreach($search_result as $users): ?>
		    		<a href="../search/profile.php?user_id=<?php echo $users['id'] ?>" class="item-users">
		      			<img src="../file/avatar/<?php echo $users['avatar'] ?>" alt="avatar">
		      			<h3><?php echo $users['login'] ?></h3>
		      			<p><?php echo $users['name'] ?></p>
		    		</a>
		    	<?php endforeach ?>

			<?php else: ?>

				Видимо вы не туда попали :)

			<?php endif ?>
		</div>

		<div class="row__news">
			<?php if ($search = $_POST['search'] ?: null): ?>
				<?php foreach($query as $posts): ?>
					<div class="col-news">
						<img src="../file/<?php echo $posts['image'] ?>" alt="">
							<div class="foreword">
								<a href="..post/post.php?post_id=<?php echo $posts['id'] ?>"><?php echo mb_substr($posts['title'], 0, 45); ?></a>
								<p><?php echo mb_substr($posts['theme'], 0, 100) ?></p>
							</div>
						</div>
				<?php endforeach ?>

			<?php else: ?>

				Походу ви не туди попали :)

			<?php endif ?>
			

		</div>
	</section>

	<?php if(isset($_SESSION['logged_user'])): ?>
			
		<style> .login{ display: none; } </style>

	<?php else : ?>

		<style> .logout{ display: none; } </style>
	
	<?php endif;?>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
	<script type="text/javascript">
	$(function() {
	// Owl Carousel
		var owl = $(".owl-carousel");
		owl.owlCarousel({
	    	items: 8,
	    	margin: 50,
	    	loop: false,
	    	dots: false,
	  	});
	});
	</script>

</body>
</html>