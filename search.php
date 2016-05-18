<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once('admin/db.php');

if (!empty($_GET['search'])) {
  $tag = $_GET['search'];
  $tag_id = $DB->query("SELECT id FROM tags WHERE tagname = '$tag';")->fetchAll(PDO::FETCH_ASSOC);
  foreach ($tag_id as $value) {
    $tag_id = $value['id'];
  }
  if(!empty($tag_id)) {
    $tag_search = $DB->query("SELECT *, billets.id AS 'test' FROM billets
INNER JOIN billets_tags
ON billets.id = billets_tags.id_billet
INNER JOIN tags
ON tags.id = billets_tags.id_tag
WHERE tags.id = '$tag_id'
ORDER BY billets.id")->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($tag_search);
    $count = count($tag_search);
  }
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
        <h1><?php if(isset($tag_search)){echo $count."\n"; if($count > 1){echo "résultats";} else{echo "résultat";}} else{echo "0 résultat";} ?> pour la recherche "<?php echo $tag; ?>":</h1>
        <div class="articles">
          <?php if(isset($tag_search)){foreach ($tag_search as $tag_value) {
            ; ?>
            <article>
              <h2><?php echo $tag_value["title"]; ?></h2>
              <div class="content"><?php echo substr($tag_value["content"], 0, 450); ?>...
                <p class="suite"><a href="detail.php?id=<?php echo $tag_value["test"]; ?>">Lire la suite <span>&#10142;</span></a></p>
              </div>
              <div class="tags">
                <p>Tags</p>
                <?php
                $sql2 = $DB->query("SELECT tagname FROM tags
INNER JOIN billets_tags
ON tags.id = billets_tags.id_tag
INNER JOIN billets
ON billets.id = billets_tags.id_billet
WHERE billets.id = " . $tag_value['test']);

                foreach ($sql2 as $value2) {
                  ?>
                  <span>#<?php echo $value2['tagname']; ?></span>
                <?php } ?>
              </div>
            </article>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>