<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
require_once('db.php');
if (!isset($_SESSION["username"])) {
  header('location: login.php');
}
if (!empty($_POST['tagname'])) {
  $tag = $_POST['tagname'];
  $modif_tag = $DB->prepare("UPDATE tags SET tagname = :tagname WHERE id LIKE :id");
  $modif_tag->bindValue(':tagname', $tag);
  $modif_tag->bindValue(':id', $_GET['id']);
  $modif_tag->execute();
  header('location: tags.php');
}


?>

<div class="tag_form">
  <form method="post" name="id" class="form-inline" action="modif_tag.php?id=<?= $_GET['id']; ?>">
  <div class="form-group">
    <input type="text" name="tagname" class="form-control" placeholder="Saisissez le nouveau tag">
  </div>
    <input type="submit" name="Envoyer" class="btn btn-default" value="Valider">
  </form>
</div>