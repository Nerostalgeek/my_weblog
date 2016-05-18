<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once('db.php');
session_start();
if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

if ($_SESSION['droit'] == 3)
{
    header('location: index.php');
}

$delcom = $DB->prepare("DELETE FROM commentaires WHERE id LIKE :id");
$delcom->bindValue(':id', $_GET['id']);
$delcom->execute();

if (!empty($_GET["page"])) {

	header('location:' . $_GET['page'] . '.php');
}
else {
	header('location: commentaires.php');
}

?>