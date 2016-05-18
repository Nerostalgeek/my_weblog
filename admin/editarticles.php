<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
require_once('db.php');

if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

$recup = $DB->prepare("SELECT * FROM billets WHERE id =" . $_GET['id']);
$recup->execute();
$result = $recup->fetch(PDO::FETCH_OBJ);

$sql = $DB->query("SELECT id, tagname FROM tags");

if (!empty($_POST['title']) && !empty($_POST['content']) && isset($_SESSION['droit']))
{
    $login = $_SESSION['username'];
    $id_user = $_SESSION['droit'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $write = $DB->prepare("UPDATE billets SET title = :title, content = :content, login = :login, id_user = :droit,  updated = CURRENT_DATE WHERE id = :id");
    $write->bindValue(':title', $title);
    $write->bindValue(':content', $content);
    $write->bindValue(':login', $login);
    $write->bindValue(':droit', $id_user);
    $write->bindValue(':id', $_GET['id']);
    $write->execute();

    header('location: articles.php');

}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/panel.css"/>
</head>

<body>
<?php include("nav.php"); ?>
<div class="main">
    <div class="container-fluid">
        <h2>Articles</h2>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <form action="editarticles.php?id=<? echo $_GET['id']; ?>" name="id" method="POST">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input value="<?php echo $result->title; ?>" type="text" class="form-control" id="'title" name="title" required placeholder="Titre">
                    </div>
                    <div class="form-group">
                        <label for="content">Article</label>
                        <textarea  name="content" id="content" cols="30" rows="50" required><?php echo $result->content; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <select class="form-control" name="tags" id="tags" multiple>
                            <?php foreach ($sql as $value) { ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value["tagname"]; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default pull-right">Publier</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>