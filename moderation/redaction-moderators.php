<?php

	require "../db.php";

	$data = $_POST;

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



?>

<?php if ($_SESSION['logged_user']->login == 'Codes_Site' || $_SESSION['logged_user']->login == 'Codes_Sited'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Модерування публікацій</title>
	<link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/grid.css">
	<link rel="stylesheet" href="../css/control_post.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

	<form class="redaction-write" method="POST" enctype="multipart/form-data">
		<section class="container-fluid" id="news">
			<div class="header-menu" style="padding: 30px;">
				<h1 class="title-content">Свіжі публікації</h1>
				<header class="header-button">
					<a href="../index.php" class="button" style="margin-right: 20px;">На головну <img src="../img/icons/dark/home.png" width="40px" alt="icon home"></a>
				</header>
			</div>

			<div class="row__news">

			<?php foreach ($query as $post): ?>

				<div class="col-news">
					<a href="../work_post/redaction.php?post_id=<?php echo $post['id'] ?>"><img src="../img/icons/dark/setting.png" style="width: auto; height: 30px;" alt="icon setting"></a>
					<img src="../file/<?php echo $post['image'] ?>" alt="<?php echo $post['title'] ?>">
						<div class="foreword">
							<a href="../post/post.php?post_id=<?php echo $post['id']; ?>%!=<?php echo $post['title']; ?>"><?php echo mb_substr($post['title'], 0, 30) ?></a>
							<p><?php echo mb_substr($post['theme'], 0, 100) ?></p>
							<p style="color: #000"><?php echo 'Просмотров '.$post['view'].''; ?></p>
						</div>
				</div>

			<?php endforeach; ?>
				
			</div>

			<div id="pageSelect"><?php echo $pagination; ?></div>
				
		</section>
	</form>

		<?php if(isset($_SESSION['logged_user'])): ?>
					
			<style> .login{ display: none; } </style>

    	<?php else :?>

        	<style> .logout{ display: none; } </style>
		
    	<?php endif;?>

<?php endif; ?>
	
	<script src="../js/adaptation-menu.js"></script>
	<script src="../js/background-setting.js"></script>
	
</body>
</html>