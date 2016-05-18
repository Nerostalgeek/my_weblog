<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
session_start();
require_once('db.php');

if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

if (!empty($_POST['title']) && !empty($_POST['content']) && isset($_SESSION['id']))
{
    $login = $_SESSION['username'];
    $id_user = $_SESSION['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $write = $DB->prepare("INSERT INTO billets(title, content, login, id_user, created)
                            VALUE ('" . addslashes($title) . "', '" . addslashes($content) . "', '$login', '$id_user', CURDATE())");
    $write->execute();

    $id_billet = $DB->lastinsertid();

    $tags = explode(" ", $_POST['tagname']);

    foreach ($tags as $key => $value)
    {
        $req = $DB->prepare("SELECT * FROM tags WHERE tagname = '$value'");
        $req->execute();
        $result = $req->fetch();

        if ($result)
        {
            $pivot = $DB->prepare("INSERT INTO billets_tags (id_billet, id_tag)
                                    VALUE ('" . $id_billet . "', '" . $result['id'] . "')");
            $pivot->execute();
        }

        else
        {
            $tag = $DB->prepare("INSERT INTO tags (tagname) VALUE ('$value')");
            $tag->execute();

            $id_tag = $DB->lastinsertid();
            
            $pivot = $DB->prepare("INSERT INTO billets_tags (id_billet, id_tag) VALUE ('$id_billet', '$id_tag') ");
            $pivot->execute();
        }
    }

    foreach ($_POST['tags'] as $value) {

        $pivot = $DB->prepare("INSERT INTO billets_tags (id_billet, id_tag)
                                    VALUE ('" . $id_billet . "', '" . $value . "')");
        $pivot->execute();
    }

    header('location: articles.php');
}

$sql = $DB->query("SELECT id, tagname FROM tags");

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
                <form action="createArticle.php" name="id" method="POST">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="'title" name="title" required placeholder="Titre">
                    </div>
                    <div class="form-group">
                        <label for="content">Article</label>
                        <textarea name="content" id="content" class="form-control" rows="10" required placeholder="Votre article ici..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tagname">Ajouter un tag</label>
                        <input type="text" class="form-control" id="tagname" name="tagname" placeholder="tagname">
                        <label for="tags">Tags</label>
                        <select class="form-control" name="tags[]" id="tags" multiple>
                            <?php foreach ($sql as $value)
                            { ?>
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
