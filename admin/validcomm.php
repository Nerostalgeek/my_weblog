<?php 
	session_start();
	require_once('db.php');
	if (!isset($_SESSION["username"]))
	{
		header('location: login.php');
	}

	$id = $_GET["id"];

	$validate = $DB->prepare("UPDATE commentaires
							SET validated = 1 
							WHERE id = $id");
	$validate->execute();

	header('location: index.php');
 ?>