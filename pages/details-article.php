<?php 
$titre = "Détails sur l'article";
include_once 'elements/header.php';
include_once '../assets/connexion/database.php'; 

$id = checkInput($_GET['q']);

function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return $data;
}

$db = Database::connect();
$statement = $db->prepare('
    SELECT a.libelle, a.prix, a.photo, a.description, v.nom, v.prenom, v.email, v.telephone_1, v.telephone_2, v.lieu_residence
    FROM s_article a
    INNER JOIN s_vendeur v ON a.vendeur = v.code_vendeur
    WHERE a.code_article = :id
');
$statement->execute([':id' => $id]);
$item = $statement->fetch();

if (!$item) {
    echo '<div class="container py-5"><div class="alert alert-warning">Article introuvable.</div></div>';
    include_once 'elements/footer.php';
    exit;
}
?>

<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs" style="background:#f7f7f7; padding:15px 0;">
  <div class="container d-flex justify-content-between align-items-center">
    <h2 style="color:#222;">Détails de l'article</h2>
    <a href="../index.php" class="btn btn-outline-secondary btn-sm">Retour à l'accueil</a>
  </div>
</section>

<!-- ======= Article Details Section ======= -->
<section id="article-details" class="py-5" style="background:#f7f7f7;">
  <div class="container">
    <div class="row g-4">
      <!-- Image -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 overflow-hidden rounded-4">
          <img src="../assets/img/article/<?= $item['photo'] ?: 'default.jpg'; ?>" class="img-fluid rounded-4 hover-zoom" alt="<?= htmlspecialchars($item['libelle']); ?>">
        </div>
      </div>

      <!-- Info -->
      <div class="col-lg-6">
        <div class="card shadow-sm border-0 p-4 h-100 d-flex flex-column justify-content-between rounded-4" style="background:#fff;">
          <div>
            <h3 class="mb-2" style="color:#222;"><?= htmlspecialchars($item['libelle']); ?></h3>
            <h4 class="text-orange mb-4" style="color:#ff6b35;"><?= number_format((float)$item['prix'], 0, ',', ' ') ?> GNF</h4>
            <ul class="list-unstyled mb-4">
              <li><i class="bx bx-user me-2 text-orange"></i><strong>Vendeur:</strong> <?= htmlspecialchars($item['prenom']) . ' ' . htmlspecialchars($item['nom']); ?></li>
              <li><i class="bx bx-map me-2 text-orange"></i><strong>Résidence:</strong> <?= htmlspecialchars($item['lieu_residence']); ?></li>
              <li><i class="bx bx-envelope me-2 text-orange"></i><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($item['email']); ?>" style="color:#555; text-decoration:none;"><?= htmlspecialchars($item['email']); ?></a></li>
              <li><i class="bx bx-phone me-2 text-orange"></i><strong>Téléphone:</strong> 
                  <a href="tel:+224<?= $item['telephone_1']; ?>" style="color:#555;">+224<?= $item['telephone_1']; ?></a>
                  <?= $item['telephone_2'] ? '/<a href="tel:+224'.$item['telephone_2'].'" style="color:#555;">+224'.$item['telephone_2'].'</a>' : ''; ?>
              </li>
            </ul>
          </div>
          <a href="tel:+224<?= $item['telephone_1']; ?>" class="btn btn-orange w-100 btn-lg mt-3" style="background:#ff6b35; color:#fff; transition:0.3s;">Contacter le vendeur</a>
        </div>
      </div>
    </div>

    <!-- Description -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card shadow-sm border-0 p-4 bg-white rounded-4">
          <h5 class="mb-3 text-orange" style="color:#ff6b35;">Description</h5>
          <p class="text-muted" style="line-height:1.7;"><?= nl2br(htmlspecialchars($item['description'])); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

<!-- ======= Footer ======= -->
<footer class="mt-5 pt-4 pb-5" style="background:#1b1b1b; color:#fff;">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4">
        <h6>Seconde Main 224</h6>
        <p class="small-muted">Siège Social: Carrière Cité, Matam, Conakry</p>
      </div>
      <div class="col-md-4">
        <h6>Contact</h6>
        <p class="small-muted mb-1"><strong>Téléphone :</strong> +224 623 02 75 39</p>
        <p class="small-muted mb-1"><strong>Email:</strong> <a href="mailto:secondemain880@gmail.com" style="color:#fff; text-decoration:none;">secondemain880@gmail.com</a></p>
      </div>
      <div class="col-md-4">
        <h6>Newsletter</h6>
        <form method="post" class="d-flex gap-2">
          <input name="newsletter" class="form-control form-control-sm" placeholder="Votre email" required>
          <button class="btn btn-sm" style="background:#ff6b35; color:#fff;">OK</button>
        </form>
      </div>
    </div>
    <div class="text-center mt-4 border-top pt-3" style="border-color:rgba(255,255,255,0.1) !important;">
      <small class="small-muted">&copy; <?= date('Y') ?> Seconde Main 224</small>
    </div>
  </div>
</footer>
<!-- Bottom nav -->
<nav class="bottom-nav">
  <a href="../index.php"><i class="bx bx-home"></i><span>Accueil</span></a>
  <a href="revendre.php"><i class="bx bx-plus-circle"></i><span>Vendre</span></a>
  <a href="profile.php" class="active"><i class="bx bx-user"></i><span>Profil</span></a>
</nav>

<style>
.bottom-nav {
  position: fixed;
  bottom: 12px;
  left: 50%;
  transform: translateX(-50%);
  width: calc(100% - 32px);
  max-width: 720px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  z-index: 1200;
  display: flex;
  justify-content: space-around;
  padding: 0.45rem 8px;
}
.bottom-nav a {
  color: #6c757d;
  font-size: 0.85rem;
  text-align: center;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
  padding: 6px 10px;
  transition: color 0.3s;
}
.bottom-nav a.active,
.bottom-nav a:hover {
  color: #ff6b35;
}
</style>

<style>
.hover-zoom {
  transition: transform 0.3s ease;
}
.hover-zoom:hover {
  transform: scale(1.05);
}
.card ul li {
  margin-bottom: 12px;
  display: flex;
  align-items: center;
}
.card ul li i {
  margin-right: 8px;
}
.text-orange { color:#ff6b35; }
.btn-orange:hover {
  background:#e85a20 !important;
  color:#fff;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(255,107,53,0.3);
  transition:0.3s;
}
</style>
