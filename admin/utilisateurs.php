<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once('db.php');


$rudb = $DB->prepare('SELECT id, login, droit FROM users WHERE id > 1');
$rudb->execute();
$result = $rudb->fetchAll(PDO::FETCH_ASSOC);

session_start();
if (!isset($_SESSION["username"])) {
  header('location: login.php');
}
if ($_SESSION['droit'] == 3) {
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Utilisateurs</title>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/panel.css"/>
  <script src="js/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="update.js" type="text/javascript"></script>
  <script src="add.js" type="text/javascript"></script>
</head>

<body>
<?php include("nav.php"); ?>
<div class="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
      <div class="pull-right text-right">
        <form method="post" action="add.php">
          <button type="submit" class="btn btn-default" id="add_btn">Ajouter un membre</button>
        </form>
        <?php if (isset($_GET['error']))
        {
          if ($_GET['error'] == 'login')
          {
            echo '<h3 style="color: #D9534F;">Utilisateur existant</h3>';
          }
        }
        ?>
      </div>
        <h2>Utilisateurs</h2>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Utilisateurs</th>
            <th>Droit</th>
            <th></th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($result as $user) { ?>
            <tr class="user_row" data-id="<?= $user['id']; ?>">
              <td><?php echo $user['login'] ?></td>
              <td><?php echo $user['droit'] ?></td>
              <td>
                <a role="button" name="id" value="<?php echo $user['id'] ?>" class="btn btn-default update">Modifier</a>
              </td>
              <td>
                <form method="post" action="delete.php">
                  <button type="submit" name="id" value="<?php echo $user['id'] ?>" class="btn btn-danger">Supprimer</button>
                </form>
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