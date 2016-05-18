<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once('db.php');
session_start();

if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

$deltag = $DB->prepare("DELETE FROM tags WHERE id LIKE :id");
$deltag->bindValue(':id', $_GET['id']);
$deltag->execute();

$deltagpivot = $DB->prepare("DELETE FROM billets_tags WHERE id_tag LIKE :id");
$deltagpivot->bindValue(':id', $_GET['id']);
$deltagpivot->execute();

header('location: tags.php');

?>