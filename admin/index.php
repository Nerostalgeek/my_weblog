<?php
session_start();
require_once('db.php');
if (!isset($_SESSION["username"]))
{
    header('location: login.php');
}

$counts = $DB->prepare('SELECT COUNT(title) AS nbr_billet,
								COUNT(commentaires.id) AS nbr_comment,
						(SELECT COUNT(*) FROM commentaires WHERE commentaires.validated = 0) AS attente
						FROM billets
						LEFT JOIN commentaires
						ON billets.id = commentaires.id');
$counts->execute();
$result = $counts->fetch(PDO::FETCH_ASSOC);

$sql = $DB->query("SELECT * FROM commentaires WHERE commentaires.validated = 0")

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/panel.css"/>
</head>

<body>
<?php include("nav.php"); ?>
<div class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h2>Pannel d'administration</h2>
                <div class="stats box">
                    <h3>D'un coup d'oeil</h3>
                    <ul>
                        <li>
                            <?php
                            if ($result['nbr_billet'] == 1)
                            {
                                echo $result['nbr_billet'] . " billet";

                            }
                            else
                            {
                                echo $result['nbr_billet'] . " billets";
                            } ?>
                        </li>
                        <li>
                            <?php
                            if ($result['nbr_comment'] == 1)
                            {
                                echo $result['nbr_comment'] . " commentaire";
                            }
                            else
                            {
                                echo $result['nbr_comment'] . " commentaires";
                            } ?>
                        </li>
                        <li>
                            <?php
                            if ($result['attente'] == 0)
                            {
                                echo "Pas de commentaire à valider";
                            }
                            elseif ($result['attente'] == 1)
                            {
                                echo $result['attente'] . " commentaire en attente";
                            }
                            else
                            {
                                echo $result['attente'] . " commentaires en attente";
                            } ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="commentaires box">
                    <h3>Commentaires à valider</h3>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Auteur</th>
                            <th>Contenu</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($sql as $value)
                        { ?>
                            <tr>
                                <td><?php echo $value["author"]; ?></td>
                                <td><?php echo substr($value["content"], 0, 150); ?></td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="validcomm.php?id=<?php echo $value['id']; ?>">Valider</a>
                                    <a class="btn btn-danger btn-sm" href="del_commentaires.php?id=<?php echo $value['id']; ?>&page=index">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>