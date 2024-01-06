<?php 
	require "../db.php";

	$data = $_POST;

	// ПОЛУЧИТИ ДАНІ В posts ПО id
	$post_id = $_GET['post_id'];
	$posts = R::load('posts', $post_id);

	// КНОПКА ВИДАЛЕННЯ ПУБЛІКАЦІЇ
	if (isset($data['delete'])) {
		$path = '../file/'.$posts['image'];
		//видалення разом з картинкою
		if (!unlink($path)) {
			echo 'Error';
		}else{
			R::trash('posts', $post_id);
			header('Location: ../work_post/delete_post.php?post_id= echo $posts[id]');
			exit();
		}
	}

// ЗАВАНТАЖЕННЯ ЗОБРАЖЕННЯ ПУБЛІКАЦІЇ
if (isset($_POST['redaction-news'])) {

    $new_image = $_FILES['image'];

    if ($new_image['error'] == 0) {
    	// Перевірка, чи є файл зображення
        if (!in_array($new_image['type'], array('image/jpeg', 'image/png', 'image/gif'))) {
            die('Дозволені формати зображень: JPG, PNG, GIF');
        }

        // Перевірка, чи не перевищено максимальний розмір файлу
        if ($new_image['size'] > 8 * 1024 * 1024) { // 8 МБ
            die('Максимальний розмір файлу: 8 МБ');
        }
        // Видалення попередньої аватарки з папки
        $post = R::load('posts', $post_id);
        if ($post->image) {
            unlink('../file/' . $post->image);
        }

        // Отримання розширення файлу зображення
        $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);

        // Генерація нового імені для файлу зображення
        $new_name = uniqid() . '.' . $ext;

        // Переміщення файлу зображення в папку з аватарками
        move_uploaded_file($new_image['tmp_name'], '../file/' . $new_name);

        // Збереження нового імені файлу зображення в базу даних
        $post->image = $new_name;
        R::store($post);

        header('Location: ../index.php');
		exit();
    }
}

	// ЗАВАНТАЖЕННЯ КОНТЕНТУ В БАЗУ ДАНИХ
	if (isset($data['redaction-news'])) {
		$posts->title = $data['title'];
		$posts->content = $data['content'];
		$posts->theme = $data['theme'];
		$posts->categoria = $data['categoria'];
		$posts->image = $target_file;

		R::store($posts);

		header('Location: ../index.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Редагування публікації - Wires</title>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="stylesheet" href="../css/control_post.css">
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="https://cdn.tiny.cloud/1/fmqoa654k2vb0citdl58kaswkrwdfudss1a7nd3kq89dfbj0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>

	<?php if($posts): ?>

	<section class="container-fluid section-write" id="write">
		<div class="header-menu">
			<h1 class="title-content">Редакция поста</h1>
			<div class="header-button">
				<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				<a href="../reg-login/signup.php" class="button login">Увійти / Реєстрація <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
				<a href="../reg-login/logout.php" class="button logout">Вийти <img src="../img/icons/dark/login.png" width="40px" alt="icon login"></a>
			</div>
		</div>

		<form class="redaction-write" method="POST" enctype="multipart/form-data">
			<button name="delete" class="button_delete"><i class="fas fa-trash"></i></button>
			<div class="redaction-title">
				<h4>Старий заголовок <i class="fa fa-level-down"></i></h4>
				<input type="text" name="title" maxlength="100" value="<?php echo $posts['title']?>">
			</div>

			<div class="redaction-title">
				<h4>Стара категорія <i class="fa fa-level-down"></i></h4>
				<p><i>"<?php echo $posts['categoria'] ?>"</i></p>
				<select name="categoria" class="dropdown-select">
				<?php echo '<option>'.$posts['categoria'].'</option>' ?>
				  <option>wires</option>
				  <option>ігри</option>
				  <option>кодінг</option>
				  <option>системне залізо</option>
				  <option>проблема? відповідь!</option>
				  <option>кіна та серіали</option>
				  <option>книги</option>
				  <option>блог</option>
				  <option>спорт</option>
				</select>
			</div>

			<div class="redaction-title row">
				<div class="isset-image">
					<h4>Вибрати нову картинку <i class="fa fa-level-down"></i></h4>
					<p><i>Обов'язково виберіть широкоформатні зображення, щоб добре відображались. І з добрим качеством!</i></p>
					<input type="file" name="image" id="image" class="image" accept=".jpg, .jpeg, .png, .gif" required>
				</div>
				<div class="new-img">
					<h4>Стара картинка <i class="fa fa-level-down"></i></h4>
					<img class="old-img" src="../file/<?php echo $posts['image'] ?>" alt="<?php echo $posts['title'] ?>">
				</div>
			</div>

			<div class="redaction-title">
				<h4>Старий текст "Про що публікація" <i class="fa fa-level-down"></i></h4>
				<textarea type="text" name="theme" class="theme" cols="120" rows="10" placeholder="Опишіть коротко про що публікація!"><?php echo $posts['theme'] ?></textarea>
			</div>

			<div class="redaction-title">
				<h4>Старий текст Основного тексту <i class="fa fa-level-down"></i></h4>
				<textarea id="content" name="content" rows="20" placeholder="Напишіть публікацію яка зацікавить читача!"><?php echo $posts['content'] ?></textarea>
			</div>

			<button class="button" name="redaction-news">Змінити <img src="../img/icons/dark/done.png" width="40px" alt="icon done"></button>
		</form>

		<?php endif;?>



		<?php if(isset($_SESSION['logged_user'])): ?>

		<style> .login{ display: none; } </style>

		<?php else : ?>

			<style> .logout{ display: none; } 
					.container-center{ width: 100%;  }
			</style>

			<div class="container-center">
				<h2>Зареєструйтеся на сайті або увійдіть у свій аккаунт</h2>
			</div>
			
		<?php endif;?>

	</section>
	
	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	<script>
		tinymce.init({
			selector : "#content",
    		plugins: "link image code",
    		toolbar: 'undo redo | styleselect | fontsizeselect | fontselect | forecolor backcolor | listnumber | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image | copy paste| code'
		});
	</script>
</body>
</html>