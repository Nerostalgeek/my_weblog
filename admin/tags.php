<?php
	require_once("db.php");
	session_start();
	if (!isset($_SESSION["username"])) 
	{
		header('location: login.php');
	}
	
	$sql = $DB->query("SELECT id, tagname FROM tags")
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Tags</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/panel.css"/>
		<script src="js/jquery-2.2.0.min.js" type="text/javascript"></script>
		<script src="modif_tag.js" type="text/javascript"></script>
	</head>

	<body>
		<?php include("nav.php"); ?>
		<div class="main">
			<div class="container-fluid">
				<h2>Tags</h2>
				<div class="row">
					<div class="col-sm-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Nom</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($sql as $value) { ?>
							<tr class="tag_row" data-id="<?= $value['id']; ?>">
								<td><?php echo $value["tagname"];?></td>
								<td>
									<a href="modif_tag.php?id=<?php echo $value['id']; ?>" class="tag_link btn btn-default">Modifier</a>
								</td>
								<td>	
									<a href="del_tag.php?id=<?php echo $value['id']; ?>" class="btn btn-danger">Supprimer</a></td>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>