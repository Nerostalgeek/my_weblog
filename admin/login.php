<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Log In</title>
  <link rel="stylesheet" href="css/bootstrap.min.css"/>
  <link rel="stylesheet" href="css/login.css"/>
  <script src="js/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="login.js" type="text/javascript"></script>
</head>

<body class="login">
<div class="overlay"></div>
<div class="container">
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="form-top">
        <h3>Bienvenue sur notre blog !</h3>
        <p>Entrez votre identifiant et votre mot de passe pour vous
          connecter :</p>
      </div>
    </div>
    <div class="col-sm-6 col-sm-offset-3">
      <div class="form-bottom">
        <div id="error"></div>
        <form action="#" method="POST" class="login-form">
          <div class="form-group">
            <label for="username" class="sr-only">Identifiant</label>
            <input type="text" name="username" placeholder="Identifiant"
                   class="form-control" id="username">
          </div>
          <div class="form-group">
            <label for="password" class="sr-only">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe"
                   class="form-control" id="password">
          </div>
          <button type="submit" class="btn">Connexion</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>