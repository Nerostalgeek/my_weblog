<?php

session_start();
require_once('db.php');

$username = $_POST['username'];
$password = $_POST['password'];


$sth = $DB->prepare('SELECT * FROM users WHERE login LIKE "' . $username . '" AND password LIKE "' . $password . '"');
$sth->bindValue('username', $username, PDO::PARAM_STR); //attend une string en parametre
$sth->bindValue('password', $password, PDO::PARAM_STR);
$sth->execute();
$rows = $sth->fetchAll(PDO::FETCH_ASSOC);

if (!empty($rows[0]['id'])) {
  $_SESSION['username'] = $rows[0]['login'];
  $_SESSION['droit'] = $rows[0]['droit'];
  $_SESSION['id'] = $rows[0]['id'];
}

else {
  die('Nom d\'utilisateur ou mot de passe incorrect');
}

?>