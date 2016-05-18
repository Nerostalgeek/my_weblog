<?php
	require_once("admin/db.php");

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

	$sql = $DB->query("SELECT id, login, title, content 
						FROM billets
						LIMIT ". $calc . ", $perPage  ");
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
						<?php foreach ($sql as $value) { ?>
							<article>
								<h2><?php echo $value["title"];?></h2>
								<div class="content"><?php echo substr($value["content"], 0, 450);?>...
									<p class="suite"><a href="detail.php?id=<?php echo $value["id"]; ?>">Lire la suite <span>&#10142;</span></a></p>
								</div>
								<div class="tags">
									<p>Tags</p>
									<?php
									$sql2 = $DB->query("SELECT id_billet, id_tag, tags.tagname AS 'hashtags'
														FROM billets_tags
														LEFT JOIN tags
														ON tags.id = billets_tags.id_tag
														WHERE id_billet =" . $value['id']);
									foreach ($sql2 as $value2) {
									?>
									<span>#<?php echo $value2["hashtags"];?></span>
									<?php } ?>
								</div>
							</article>
						<?php } ?>
						<?php if ($pagination == true) { ?>
						<div class="text-center">
							<?php
								if ($cPage > 1) {
									$pre = $cPage-1;
									echo '<a class="pull-left" href="index.php?page='. $pre .'">Précédent</a>';
								}
							?>
							<select onchange="location.href=this.value">
								<?php 
									for ($page = 1; $page <= $nbPage ; $page++) {
										if ($page == $cPage) {
											echo "<option value='index.php?page=" . $page . "' selected='selected'>$page</option>";
										}
										else {
											echo "<option value='index.php?page=" . $page . "'>$page</option>";
										}
									}
								?>
							</select>
							<?php
								if ($cPage < $nbPage) {
									$suiv = $cPage+1;
									echo '<a class="pull-right" href="index.php?page='. $suiv .'">Suivant</a>';
								}
							?>
						</div>
					<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>