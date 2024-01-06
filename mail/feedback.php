<?php

	require "../db.php";

	$data = $_POST;

	$to = 'ktaras357@gmail.com';

	$login = $data['login'];
	$name = $data['name'];
	$theme = $data['theme'];
	$email = $data['email'];
	$message = $data['message'];
	
	mail($to, $login, $name, $theme, $email, $message);

?>