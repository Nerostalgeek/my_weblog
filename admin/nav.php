
<div class="topbar">
    <h1 class="animation"><a href="index.php">Panel d'administration</a></h1>
    <a href="disconnect.php">Se déconnecter</a>
    <div class="pull-right"><?php echo 'Bonjour <strong>' . $_SESSION['username']; ?></strong></div>
</div>
<nav>
    <ul>
        <li><a href="../index.php">Blog</a></li>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="articles.php">Articles</a></li>
        <li><a href="commentaires.php">Commentaires</a></li>
        <?php if ($_SESSION['droit'] != 3) { ?>
            <li><a href="utilisateurs.php">Utilisateurs</a></li>
        <?php } ?>
        <li><a href="tags.php">Tags</a></li>
    </ul>
</nav>