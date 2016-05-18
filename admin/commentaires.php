<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once("db.php");
session_start();
if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

$sql = "SELECT * FROM commentaires";
$requete = $DB->prepare($sql);
$requete->execute();
$count = $requete->rowCount();

if (!empty($_GET['page']))
{

    $cPage = $_GET['page'];
}
else
{

    $cPage = 1;
}

$nbArt = $count;
$perPage = 5;
$nbPage = ceil($nbArt / $perPage);
$calc = (($cPage - 1) * $perPage);
$pagination = true;

$sql = $DB->query("SELECT commentaires.id, id_billet, commentaires.author, commentaires.content, date, modified, billets.title, validated
					FROM commentaires
                    LEFT JOIN billets
                    ON commentaires.id_billet = billets.id
					LIMIT " . $calc . ", $perPage  ");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Commentaires</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/panel.css"/>
</head>

<body>
<?php include("nav.php"); ?>
<div class="main">
    <div class="container-fluid">
        <h2>Commentaires</h2>
        <div class="row">
            <div class="col-sm-12">
                <h3>Validés</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Article</th>
                        <th>Auteur</th>
                        <th>Contenu</th>
                        <th>Date de création</th>
                        <th>Date de modification</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sql as $value)
                    { ?>
                        <tr>
                            <td><?php echo $value["title"]; ?></td>
                            <td><?php echo $value["author"]; ?></td>
                            <td><?php echo substr($value["content"], 0, 100); ?></td>
                            <td><?php echo $value["date"]; ?></td>
                            <td><?php echo $value["modified"]; ?></td>
                            <td>
                                <a class="btn btn-default" href="edit_commentaire.php?id=<?php echo $value['id']; ?>">Modifier</a>
                                <a class="btn btn-danger" href="del_commentaires.php?id=<?php echo $value['id']; ?>">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="text-center">
                    <?php
                    if ($cPage > 1)
                    {
                        $pre = $cPage - 1;
                        echo '<a class="pull-left" href="commentaires.php?page=' . $pre . '">Précédent</a>';
                    }
                    if ($cPage < $nbPage)
                    {
                        $suiv = $cPage + 1;
                        echo '<a class="pull-right" href="commentaires.php?page=' . $suiv . '">Suivant</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>