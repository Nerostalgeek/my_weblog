<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once('db.php');
session_start();

if (!isset($_SESSION["droit"]))
{
    header('location: login.php');
}
if ($_SESSION['droit'] == 3)
{
    header('location: index.php');
}

if ($_SESSION['droit'] == 1 || $_SESSION['droit'] == 2)
{
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['droit']))
    {

        $newIncrement = $DB->lastInsertId() + 1;
        $DB->exec("ALTER TABLE users AUTO_INCREMENT = $newIncrement");

        $login = $_POST['login'];
        $password = $_POST['password'];
        $droit = $_POST['droit'];
        $req_root = "SELECT COUNT(id) AS 'id' FROM users WHERE login = :login";
        $root = $DB->prepare($req_root);

        $root->bindValue(':login', $login);
        $root->execute();
        $no_double = $root->fetchAll(PDO::FETCH_ASSOC);
        var_dump($no_double);

        if ($no_double[0]['id'] == 1)
        {
            header('location: utilisateurs.php?error=login');
        }
        else
        {
            $update = $DB->prepare("UPDATE users
                                SET login = " . '"' . $login . '"' . ", password = " . '"' . $password . '"' . ", droit = " . '"' . $droit . '"' . "
                                WHERE id LIKE :id");
            $update->bindValue(':id', $_GET['id']);
            $update->execute();
            header('location: utilisateurs.php');
        }
    }
}


?>

<div class="update_form">
    <form method="post" name="id" class="form-inline" action="update.php?id=<?= $_GET['id']; ?>">
        <div class="form-group">
            <input type="text" name="login" class="form-control" placeholder="Login" required>
        </div>
        <div class="form-group">
            <input type="text" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group">
            <select name="droit" required>
                <option value="">Droit</option>
                <option value="2">Admin</option>
                <option value="3">Blogger</option>
            </select>
        </div>
        <input type="submit" class="btn btn-default" name="executer" value="Valider">
    </form>
</div>



