<?php include 'header.php'; 
$db = Database::connect();

$vendeurs = $db->query("SELECT COUNT(*) FROM s_vendeur")->fetchColumn();
$articles = $db->query("SELECT COUNT(*) FROM s_article")->fetchColumn();
?>

<div class="col-12 mt-4">
<h3 class="fw-bold mb-4">Tableau de bord</h3>

<div class="row g-4">
  <div class="col-md-4">
    <div class="card shadow-sm p-4 text-center">
      <h5>Revendeurs</h5>
      <h2 class="fw-bold"><?= $vendeurs ?></h2>
      <a href="revendeurs.php" class="btn btn-outline-dark mt-2">Voir</a>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm p-4 text-center">
      <h5>Articles</h5>
      <h2 class="fw-bold"><?= $articles ?></h2>
      <a href="articles.php" class="btn btn-outline-dark mt-2">Voir</a>
    </div>
  </div>
</div>
</div>

</div></div>
</body>
</html>
