<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}
require_once('db.php');
if ($_SESSION['droit'] == 1 || $_SESSION['droit'] == 2 || $_SESSION['droit'] == 3)
{
    $recup = $DB->prepare("SELECT * FROM commentaires WHERE id =" . $_GET['id']);
    $recup->execute();
    $modif_com = $recup->fetch(PDO::FETCH_OBJ);
    if (!empty($_POST['author']) && !empty($_POST['content']))
    {

        $newIncrement = $DB->lastInsertId() + 1;
        $DB->exec("ALTER TABLE users AUTO_INCREMENT = $newIncrement");


        $auteur = $_POST['author'];
        $content = $_POST['content'];


        $update = $DB->prepare("UPDATE commentaires
        SET author = " . '"' . $auteur . '"' . ", content = " . '"' . $content . '"' . ", modified = now(), validated = 1
        WHERE id LIKE :id");
        $update->bindValue(':id', $_GET['id']);
        $update->execute();


        header('location: commentaires.php');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modération des commentaires</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/panel.css"/>
</head>

<body>
<?php include("nav.php"); ?>
<div class="main">
    <div class="container-fluid">
        <h2>Modification du commentaire</h2>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="update_form">
                    <form method="post" name="id" action="edit_commentaire.php?id=<?= $_GET['id']; ?>">
                        <div class="form-group">
                            <label for="author">Auteur</label>
                            <input value="<?php echo $modif_com->author; ?>" type="text" class="form-control" id="author" name="author" required placeholder="Titre">
                        </div>
                        <div class="form-group">
                            <label for="content">Commentaire</label>
                            <textarea class="form-control" id="content" name="content" required placeholder="Commentaire"><?php echo $modif_com->content; ?></textarea>
                        </div>

                        <input type="submit" name="executer" class="btn btn-default" value="Valider">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>