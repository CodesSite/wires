<?php 

	require "db.php";

	$data = $_POST;

	// сторінкова навігація "пагінація"
	$page= isset($_GET['page']) ? $_GET['page']: 1;

	$limit=12; // ліміт публікацій на одній сторінці

	$query = R::findAll('posts', 'ORDER BY id DESC LIMIT '.(($page-1)*$limit).', '.$limit); // знаходимо всі публікації

	$pagination = ""; // контент пагінації

	$pages_all = R::count('posts'); //підрахунок всіх публікацій

	$pages = ceil($pages_all/$limit); // всі публікації поділити на ліміт

    if ($pages >=1 && $page <= $pages){

        $counter = 1;
        $pagination = "";

        if ($page > ($limit/8)) $pagination .= "<a href=\"?page=1\">1 </a> ... ";

        for ($number=$page; $number<=$pages;$number++)
        {

            if($counter < $limit) $pagination .= "<a href=\"?page=" .$number."\">".$number." </a>";

            $counter++;
        }
        if ($page < $pages - ($limit/2))  $pagination .= "... " . "<a href=\"?page=" .$pages."\">".$pages." </a>"; 
    };


if(isset($_SESSION['logged_user'])){
	$user_id = $_SESSION['logged_user']->id;
}

if (isset($_POST['set_avatar'])) {
    // Отримання вибраного файлу зображення
    $avatar = $_FILES['avatar'];

    // Перевірка, чи було завантажено зображення
    if ($avatar['error'] == 0) {
    	// Перевірка, чи є файл зображення
        if (!in_array($avatar['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
            die('Дозволені формати зображень: JPG, PNG, GIF');
        }

        // Перевірка, чи не перевищено максимальний розмір файлу
        if ($avatar['size'] > 5 * 1024 * 1024) { // 5 МБ
            die('Максимальний розмір файлу: 5 МБ');
        }
        // Видалення попередньої аватарки з папки
        $user = R::load('users', $user_id);
        if ($user->avatar) {
            unlink('file/avatar/' . $user->avatar);
        }

        // Отримання розширення файлу зображення
        $ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);

        // Генерація нового імені для файлу зображення
        $new_name = uniqid() . '.' . $ext;

        // Переміщення файлу зображення в папку з аватарками
        move_uploaded_file($avatar['tmp_name'], 'file/avatar/' . $new_name);

        // Збереження нового імені файлу зображення в базу даних
        $user->avatar = $new_name;
        R::store($user);

        header('Location: ../index.php');
		exit();
    }
}
    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Wires, Новини, Wires головна сторінка, Блог, Особиста думка, Публікація новин, Вести свій блог, Сайт блогінг, Wires новини, Wires блог">
	<meta name="description" content="Сайт блог новини, на якому ти показуэш себе та свій розвиток у суспільному житті. Розкажи новини, які тебе зацікавили!">
	<meta property="site_name" content="Wires">
	<meta property="type" content="website">
	<title>Wires - публікуй себе!</title> 
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="https://cdn.tiny.cloud/1/fmqoa654k2vb0citdl58kaswkrwdfudss1a7nd3kq89dfbj0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

	<aside class="wrapper">
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

	<main class="main-content">

		<div class="nav-toggler"></div>

		<section class="container-fluid section active" id="news">
			<div class="header-menu">
				<h1 class="title-content">Свіжі публікації</h1>
				<header class="header-button">
					<form action="../search/search-result.php" method="post" style="display: flex;">
						<input type="text" class="search" name="search" placeholder="Поиск по сайту">
						<button class="button button-search" name="do_search"><img src="../img/icons/dark/search.png" width="40px" alt="icon search"></button>
					</form>
					<a href="../post/add.php" class="button" style="margin: 0 20px 0 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</header>
			</div>

			<div class="row__news">

			<?php foreach ($query as $post): ?>

				<div class="col-news">
					<img src="../file/<?php echo $post['image'] ?>" alt="<?php echo $post['title'] ?>">
						<div class="foreword">
							<a href="../post/post.php?post_id=<?php echo $post['id']; ?>"><?php echo mb_substr($post['title'], 0, 30) ?></a>
							<p><?php echo mb_substr($post['theme'], 0, 100) ?></p>
							<p style="color: #000"><?php echo 'Просмотров '.$post['view'].''; ?></p>
						</div>
				</div>

			<?php endforeach; ?>
				
			</div>

			<div id="pageSelect"><?php echo $pagination; ?></div>
				
		</section>

		<section class="container-fluid section" id="profile">
			<header class="header-menu">
				<h1 class="title-content">Профіль</h1>
				<div class="header-button">
					<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</header>

			<?php if(isset($_SESSION['logged_user'])): ?>
			<?php

				$login_user = $_SESSION['logged_user']->login;
				$region_user = $_SESSION['logged_user']->region;
				$name_user = $_SESSION['logged_user']->name;

    			$result = R::getRow('SELECT SUM(view) as s FROM posts WHERE author LIKE ? LIMIT 1', [$login_user]);

			?>
			<div class="background info-profile">
				<div class="naming">
					<a class="my-photo">
						<?php

							$user = R::load('users', $user_id);
							if ($user->avatar) {
							    echo '<img src="../file/avatar/' .  $user->avatar . '" alt="Avatar">';
							} else {
							    echo '<img src="../img/avatar/1.png" alt="Default Avatar">';
							}

						?>
					</a>

					<div class="my_name">
						<h2><?php echo $login_user; ?></h2>
						<p><?php echo $name_user; ?></p>
						<?php

							// Перевірка ролі користувача
							switch ($user['login']) {
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

				<div class="row__profile">
					<p class="article">Кіл-сть публікацій: <span><?php echo R::count("posts", "author like ?", [$login_user]); ?></span></p>
					<p class="view">Переглядів: <span><?php print_r($result['s']); ?></span></p>
					<p class="region">Регіон: <span><?php echo $region_user; ?></span></p>
				</div>
			</div>

			<div class="profile-button">
				<?php if ($login_user == 'Codes_Site' || $login_user == 'Codes_Sited'): ?>
					<a href="../moderation/redaction-moderators.php" class="button">Модерувати публікації <img src="../img/icons/dark/moderation_redaction.png" width="40px" alt="icon archive"></a>
				<?php endif; ?>
				<a href="../profile/me-posts.php" class="button">Мої Публікації <img src="../img/icons/dark/archive.png" width="40px" alt="icon archive"></a>
			</div>

			<div class="profile-button">
				<a href="../profile/settings.php" class="button">Налаштування <img src="../img/icons/dark/setting.png" width="40px" alt="icon settings"></a>
				<a href="../profile/settings.php" class="button">Мої відповіді <img src="../img/icons/dark/answer.png" width="40px" alt="icon answer"></a>
			</div>

			<?php else : ?>
				<style> .logout{ display: none; }</style>

				<div class="background logout-table">
					<h2>Зареєструйтеся на сайті або увійдіть у свій аккаунт</h2>
				</div>

			<?php endif; ?>
		</section>

		<section class="container-fluid section" id="tegs">
			<header class="header-menu">
				<h1 class="title-content">Категорії</h1>
				<div class="header-button">
					<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</header>

			<ul class="row__categoria">
				<li>
					<a href="../categoria/wires.php" class="background-categoria">
						<h2 class="logo" style="font-size: 40px; padding: 20px 0;">Wires</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/games.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/game.png" alt="Games Ігри">
						<h2>Ігри</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/coding.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/coding.png" alt="Coding Кодинг">
						<h2>Кодінг</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/system.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/system-hardware.png" alt="System Hardware Системное железо">
						<h2>Системне залізо</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/noproblem.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/question.png" alt="Problem? Answer! Проблема? Ответ!">
						<h2>Проблема? Відповідь!</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/film.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/cinema.png" alt="Movies and series Фильмы и сериалы">
						<h2>Кіна та серіали</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/book.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/book.png" alt="Book Книги">
						<h2>Книги</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/blog.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/blog.png" alt="Blog Блог">
						<h2>Блог</h2>
					</a>
				</li>
				<li>
					<a href="../categoria/sport.php" class="background-categoria">
						<img src="../img/icons/dark/categoria/sport.png" alt="Sport Спорт">
						<h2>Спорт</h2>
					</a>
				</li>
			</ul>
		</section>

		<section class="container-fluid section" id="about">
			<div class="header-menu">
				<h1 class="title-content">Про що сайт</h1>
				<div class="header-button">
					<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</div>

			<div class="content">
				<div class="background about about-website">
					<h1>Про сайт</h1>
					<p>На сайті можна розмістити напис (публікації), в якому ви можете розповісти цікаву історію, вести свій блог, розповісти про ваші проекти, розповсюджувати цікаві ідеї і думки. Ми раді кожному хто завітає нашу платформу. Користуйтеся нею з розумом!</p>
				</div>
				<div class="background about ideas-website">
					<h1>Ідея сайту</h1>
					<p>Наш сайт був створений для того, щоб кожен користувач зміг розказати про свої думки, які не порушують правила нашої платформи, користувач зміг показати, що він вміє, показати свої роботи, а також показати свої творіння для других, щоб змогли поширити їх. Для важливо, що думає користувач, найголовніше це – правильно її подати.</p>
				</div>
				<div class="background about developent-website">
					<h1>Розробка сайту</h1>
					<p>На даний час сайт у беті, адже він ще розробляється, ви можете також допомогти, як найкраще покращити нашу платформу для користування, можете запропонувати ідею та як її реалізувати за <a href="#">посиланням.</a> Ідеї ми записуємо і стараємося їх реалізувати, як найкраще так і найшвидше. Ваша допомога буде дуже цінною, дякую вам!</p>
				</div>

			</div>
			
		</section>

		<section class="container-fluid section" id="rule">
			<div class="header-menu">
				<h1 class="title-content">Правила платформи Wires</h1>
				<div class="header-button">
					<a href="../post/add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</div>

			<div class="rules">
				<div class="background">
					<h1>1.Основні правила платформи Wires</h1>
					<p><strong>1.1 <i>Спам. </i></strong>Публікації або коментарі, в яких були опубліковані з єдиною ціллю, рекламувати бренди інших сервісів, будуть розглядатися, як порушення правила Спам.</p>

					<p><strong>1.2 <i>Порушення законів України. </i></strong>Наша команда знаходиться на території України, будь-яке порушення законів нашої країни буде розглядатися, як зловмисне порушення правил платформи і нашої країни.</p>

					<p><strong>1.3 <i>Заклик до насилля і ворожості. </i></strong>Якщо користувач буде закликати або підштовхувати до насилля людей, а також ворожості до інших рас людини, буде розглядатися, як порушення наших правил платформи.</p>

					<p><strong>1.4 <i>Боти. </i></strong>Будь-яке використання ботів у нас забороняється, оскільки ми хочемо почути думки людей, але не роботів.</p>
				</div>
				<div class="background">
					<h1>2.Правила написання публікації</h1>
					<p><strong>2.1 <i>Категорії для постів. </i></strong>Перед публікацією посту потрібно вказати, в яку категорію вона входить, щоб текст підходив до категорії.</p>

					<p><strong>2.2 <i>Грамотність. </i></strong>Перед публікацією посту потрібно правильно сформулювати думку, про що Ваша публікація, для кого вона орієнтована і так далі.</p>

					<p><strong>2.3 <i>Сексуальний контент. </i></strong>Якщо ваш контент буде опублікуватись у форматі порнографії, тобто оголення тіла, будуть прийматись відповідні дії модератора.</p>

					<p><strong>2.4 <i>Копіювання матеріалів з інших джерел інформації. </i></strong>Нам не подобається плагіат, на сайті можна публікувати події, які задіяні в світі, але не копіюючи інші джерела інформації, текст повинен бути написаним людиною, яка має суб’єктивну думку.</p>

					<p><strong>2.5 <i>Погляд модератора на публікацію. </i></strong>Кожну публікацію модератор розглядає, тому при маніпуляції уникнення правил платформи, модератор прийме дії.</p>
				</div>
				<div class="background">
					<h1>3.Правила для категорій</h1>
					<p><strong>3.1 <i>Категорія Wires. </i></strong>Ця категорія створена для загальної тематики або тематики яка не присутня на сайті.</p>

					<p><strong>3.2 <i>Категорія Ігри. </i></strong>Категорія була створена для публікації новин про індустрію ігор або загальну тематику про ігри.</p>

					<p><strong>3.3 <i>Категорія Кодінг. </i></strong>Категорія про програмування, системні програми, тому подібне.</p>

					<p><strong>3.4 <i>Категорія Системне залізо. </i></strong>Публікації про комп'ютену техніку, також підійде для програмних забеспечень.</p>

					<p><strong>3.5 <i>Категорія Проблема? Відьповідь! </i></strong>Якщо ви столкнулись з тяжкою проблемою і ви її вирішили можете розказати людям, як вам удалося її виправити або якщо ви хочете як можна більше людям розказати і допомоги в їхніх проблемах в житті.</p>

					<p><strong>3.6 <i>Категорія Кіна та серіали. </i></strong>Порекомендуйте людям цікавий фільм або серіал, можете розказати про весь сюжет в текстовому форматі.</p>

					<p><strong>3.7 <i>Категорія Книги. </i></strong>Категорія створена про ваші захоплення про книгу, яку ви прочитали.</p>

					<p><strong>3.8 <i>Категорія Блог. </i></strong>В цій категорії можете розказати про своє життя, хобі, цікавою новиною яка сталася у вашому житті.</p>

					<p><strong>3.9 <i>Категорія Спорт. </i></strong>Атлетика, спортивні змагання, новини у сфері спорту, популярні змагання з вашими спортсменами.</p>
				</div>
				<div class="background">
					<h1>4.Правила для користувачів</h1>
					<p><strong>4.1 <i>Повторні публікації. </i></strong>Якщо модератор помітив у Вас в акаунті однотипні публікації, тоді ваші всі пости будуть видалені і заблокований акаунт на деякий час.</p>

					<p><strong>4.2 <i>Образи користувачів, гостей, третіх осіб або соціальних груп. </i></strong>Ображення гостя, користувача, третіх осіб або соціальних груп буде розцінюватися, як зловмисне порушення нашої платформи.</p>

					<p><strong>4.3 <i>Наклепи, бездоказові звинувачення та вкидання. </i></strong>Ми б не хотіли, щоб користувачі писали коментарі, які будуть звинувачувати людину без яких-небудь доказів.</p>
				</div>
				<div class="background">
					<h1>5.Відповідні дії модераторів щодо порушення правил </h1>
					<p><strong>5.1 <i>Спам </i></strong>- від 7 днів до вічного блокування аккаунта.</p>

					<p><strong>5.2 <i>Порушення законів України </i></strong>- від 30 днів до вічного блокування аккаунта.</p>

					<p><strong>5.3 <i>Заклик до насилля і ворожості </i></strong>- від 24 години до 7 днів блокування аккаунта.</p>

					<p><strong>5.4 <i>Боти </i></strong>- вічне блокування аккаунта та його видалення.</p>

					<p><strong>5.5 <i>Категорії для постів </i></strong>- видалення публікації або виправлення Вашої помилки..</p>

					<p><strong>5.6 <i>Грамотність </i></strong>- видалення публікації або виправлення Вашої помилки.</p>

					<p><strong>5.7 <i>Сексуальний контент </i></strong>- від 30 днів до вічного блокування аккаунта та його видалення.</p>

					<p><strong>5.8 <i>Плагіат </i></strong>- від 14 днів до 30 днів блокування аккаунта.</p>

					<p><strong>5.9 <i>Погляд модератора на публікацію </i></strong>- видалення публікації, а також блокування аккаунта від 24 годин до 30 днів.</p>

					<p><strong>5.10 <i>Повторні публікації </i></strong>- від 7 днів до 365 днів блокування аккаунта.</p>

					<p><strong>5.11 <i>Образи користувачів, гостей, третіх осіб або соціальних груп </i></strong>- від 24 годин до 7 днів блокування аккаунта.</p>

					<p><strong>5.12 <i>Наклепи, бездоказові звинувачення та вкидання </i></strong>- від 24 годин до 7 днів блокування аккаунта.</p>
				</div>
			</div>

		</section>

		<section class="container-fluid section" id="contact">
			<div class="header-menu">
				<h1 class="title-content">Контакти</h1>
				<div class="header-button">
					<a href="add.php" class="button" style="margin-right: 20px;">Добавити публікацію <img src="../img/icons/dark/add.png" width="40px" alt="icon add"></a>
					<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
					<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				</div>
			</div>

			<div class="row__contact">
				<div class="social-media">
					<div class="background media">
						<a href="https://www.youtube.com/channel/UCIoMUt9dYysakFDOLuintTQ/featured" target="_blank"><img src="../img/icons/dark/contact/youtube.png" width="50px" alt="youtube"></a>
						<a href="https://t.me/codes_site" target="_blank"><img src="../img/icons/dark/contact/telegram.png" width="50px" alt="telegram"></a>
						<a href="https://www.instagram.com/taras_kovtunovuch/" target="_blank"><img src="../img/icons/dark/contact/instagram.png" width="50px" alt="instagram"></a>
						<a href="https://www.instagram.com/codes_site/" target="_blank"><img src="../img/icons/dark/contact/instagram.png" width="50px" alt="instagram"></a>
						<a href="#" target="_blank"><img src="../img/icons/dark/contact/pinterest.png" width="50px" alt="pinterest"></a>
						<a href="#" target="_blank"><img src="../img/icons/dark/contact/twitter.png" width="50px" alt="twitter"></a>
					</div>
					<form id="form">
						<div class="feedback">
							<h3>Зворотній зв'язок</h3>
							<input type="text" name="login" placeholder="Логін" required>
							<input type="text" name="name" placeholder="Ім'я" required>
							<input type="text" name="theme" placeholder="Тема" required>
							<input type="email" name="email" placeholder="Email" required>
							<textarea name="message" cols="30" rows="15"  placeholder="Ваш текст...." required></textarea>
							<button class="button" id="btn" style="margin-top: 20px;">Відправити</button>
						</div>
					</form>
				</div>
				<div class="work">
					<div class="background">
						<div class="work-week">
							<div class="work-name">
								<img src="../img/icons/dark/contact/calendar.png" alt="icon calendar">
								<h3>Графік роботи</h3>
							</div>
							<p>Пн-Сб: з 21:00 до 23:00<br>Нд: з 13:00 до 23:00</p>
						</div>
						<div class="work-week">
							<div class="work-name">
								<img src="../img/icons/dark/contact/email.png" alt="icon email">
								<h3>Напишіть нам</h3>
							</div>
							<p>codes_site@gmail.com</p>
						</div>
					</div>
				</div>
			</div>
		</section>

	</main>
	
	<?php if(isset($_SESSION['logged_user'])): ?>
					
		<style> .login{ display: none; } </style>

    <?php else :?>

        <style> .logout{ display: none; } </style>
		
    <?php endif;?>

	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
</body>
</html>