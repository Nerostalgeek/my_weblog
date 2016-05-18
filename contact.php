<?php 
	require_once("admin/db.php");
	if (!empty($_POST['envoyer'])) {

		$objet = $_POST['objet'];
		$email = $_POST['email'];
		$message = $_POST['message'];

		$to = "marine.delpuechferrari@epitech.eu";
		$sujet = $objet;
		$body = $message;
		$header = "From: " . $email . "\r\n";
		$header .= "Reply-To: " . $email;

		mail($to, $sujet, $body, $header);
		header('location: contact.php?envoi=1');
	}
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
					<?php 
					if (!empty($_GET["envoi"])) {
						echo "<p>Votre message a bien été envoyé</p>";
					}
					?>
					<form class="form-horizontal" method="POST">
						<div class="form-group">
						<label for="objet" class="col-sm-2 control-label">Objet</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="objet" id="objet" required placeholder="Objet">
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10">
								<input type="email" class="form-control" name="email" id="email" required placeholder="Email">
							</div>
						</div>
						<div class="form-group">
							<label for="message" class="col-sm-2 control-label">Message</label>
							<div class="col-sm-10">
								<textarea class="form-control" name="message" id="message" required placeholder="Votre message ici..."></textarea>
							</div>
						</div>
						<div class="form-group"> 
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" value="envoyer" name="envoyer" class="btn btn-default">Envoyer</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>