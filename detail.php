<?php 
	require_once("admin/db.php");

	$id = $_GET['id'];

	$ok = false;

	if (!empty($_POST['envoyer'])) {

		$sqlajout = "INSERT INTO commentaires(id, id_billet, author, content, date, validated)
					VALUE (DEFAULT, " . $id . ", '" . addslashes($_POST['pseudo']) . "', '" . addslashes($_POST['message']) . "', CURDATE(), 0)";
		$requete = $DB->prepare($sqlajout);
		$requete->execute();

		$ok = true;
	}

	$sql = "SELECT id, created, login, title, content
			FROM billets WHERE id = " . $id;
	$requete = $DB->prepare($sql);
	$requete->execute();
	$affichage = $requete->fetchAll();

	$sql = "SELECT author, content, date
			FROM commentaires
			WHERE id_billet = " . $id ."
			AND validated = 1";

	$requete = $DB->prepare($sql);
	$requete->execute();
	$commentaires = $requete->fetchAll();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Blog</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/index.css">
	</head>

	<body>
		<?php include("nav.php"); ?>
		<div class="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="articles">
							<?php for($i=0; $i < count($affichage); $i++) { ?>
							<article>
								<h2><?php echo $affichage[$i]['title'];?></h2>
								<div class="content">
									<?php echo $affichage[$i]['content']; ?>
								</div>
								<div class="tags">
									<p>Tags</p>
									<?php
									$sql2 = $DB->query("SELECT id_billet, id_tag, tags.tagname AS 'hashtags'
														FROM billets_tags
														LEFT JOIN tags
														ON tags.id = billets_tags.id_tag
														WHERE id_billet =" . $affichage[$i]['id']);
									foreach ($sql2 as $value2) {
									?>
									<span>#<?php echo $value2["hashtags"];?></span>
									<?php } ?>
								</div>
							</article>
							<?php } ?>
						</div>
						<aside>
							<h2>Commentaires</h2>
							<div class="ajoutcomm">
							<?php 
								if ($ok == true){ 
									echo "<p>Votre commentaire à bien été envoyé</p>";
								}
								else { ?>		
									<h3>Ajouter un commentaire</h3>
									<form action="detail.php?id=<?php echo $id; ?>" method="POST">
										<div class="form-group">
											<label for="pseudo" class="control-label">Pseudo</label>
											<input type="text" class="form-control" id="pseudo" name="pseudo" required placeholder="Pseudo">
										</div>
										<div class="form-group">
											<label for="message" class="control-label">Message</label>
											<textarea class="form-control" rows="5" name="message" required placeholder="Votre message ici..."></textarea>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-default" name="envoyer" value="envoyer">Envoyer</button>
										</div>
									</form>
								<?php }?>	
							</div>
							<?php for($i=0; $i < count($commentaires); $i++) { ?>
							<div class="commentaires">
								<p class="pull-right date"><?php echo $commentaires[$i]['date'];?></p>
								<h3><?php echo $commentaires[$i]['author'];?></h3>
								<p class="text-justify"><?php echo $commentaires[$i]['content'];?></p>
							</div>
							<?php } ?>
						</aside>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>