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


$prep = $DB->prepare("DELETE FROM users WHERE id LIKE :id");
$prep->bindValue(':id', $_POST['id']);
$prep->execute();
header('location: utilisateurs.php');



?>