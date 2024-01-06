<?php
	
	$recepient = "wires.com";
	$sitename = "Wires"

	$login = trim($_POST['login']);
	$name = trim($_POST['name']);
	$theme = trim($_POST['theme']);
	$email = trim($_POST['email']);
	$message = trim($_POST['message']);
	$message_form = "Login: $login \nName: $name \nTheme: $theme \nEmail: $email \nMessage: $message";

	$pagetitle = "Нове повыдомлення від \'$name'\";
	mail($recepient, $pagetitle, $message_form, "Content-type: text/plain; charset=\'utf-8\'\n From: $recepient);
	
?>