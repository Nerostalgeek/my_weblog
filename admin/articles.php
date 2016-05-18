<?php 
	require_once("db.php");
	session_start();
	if (!isset($_SESSION["username"])) 
	{
		header('location: login.php');
	}

	$sql = "SELECT * FROM billets";
	$requete = $DB->prepare($sql);
	$requete->execute();
	$count = $requete->rowCount();

	if (!empty($_GET['page'])) {

		$cPage = $_GET['page'];
	}
	else {

		$cPage = 1;
	}

	$nbArt = $count;
	$perPage = 5;
	$nbPage = ceil($nbArt/$perPage);
	$calc = (($cPage - 1) * $perPage);
	$pagination = true;

	$sql = $DB->query("SELECT id, created, title, content
						FROM billets
						LIMIT ". $calc . ", $perPage  ");
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
				<a href="createArticle.php" class="btn btn-default pull-right">Ecrire un article</a>
				<h2>Articles</h2>
				<div class="row">
					<div class="col-sm-12">
						<h3>En ligne</h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Titre</th>
									<th>Date</th>
									<th>Contenu</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($sql as $value) { ?>
								<tr>
									<td><?php echo $value["title"];?></td>
									<td><?php echo $value["created"];?></td>
									<td><?php echo substr($value["content"], 0, 120);?></td>
									<td>
										<a class="btn btn-default" href="editarticles.php?id=<?php echo $value['id']; ?>">Modifier</a>
										<a class="btn btn-danger" href="del_article.php?id=<?php echo $value['id']; ?>">Supprimer</a>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<div class="text-center">
							<?php
								if ($cPage > 1) {
									$pre = $cPage-1;
									echo '<a class="pull-left" href="articles.php?page='. $pre .'">Précédent</a>';
								}
								if ($cPage < $nbPage) {
									$suiv = $cPage+1;
									echo '<a class="pull-right" href="articles.php?page='. $suiv .'">Suivant</a>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>