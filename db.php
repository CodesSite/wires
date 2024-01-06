<?php 
	require "libs/rb.php"; // підключення до бібліотеки RedBeanPHP (ORM)
	$connection = R::setup( 'mysql:host=localhost;dbname=wires', 'root', '' ); // підключення до БД
	session_start(); // запамятати користувача
	
?>