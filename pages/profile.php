<?php
session_start();
if (empty($_SESSION['code_vendeur'])) {
    header('Location: login.php');
    exit();
}

require_once '../assets/connexion/database.php';
$db = Database::connect();

$code = $_SESSION['code_vendeur'];
$type = $_GET['q'] ?? '';

// Vendeur
$stmt = $db->prepare("SELECT nom, prenom, email, photo FROM s_vendeur WHERE code_vendeur=?");
$stmt->execute([$code]);
$v = $stmt->fetch();
$photo = !empty($v['photo']) ? '../assets/img/profil/'.$v['photo'] : '../assets/img/photo/avatar.jpeg';

// Statistiques
$stat = $db->prepare("
    SELECT 
        COUNT(*) total,
        SUM(CASE WHEN date_fin IS NULL OR date_fin='' THEN 1 ELSE 0 END) en_vente,
        SUM(CASE WHEN date_fin IS NOT NULL AND date_fin!='' THEN 1 ELSE 0 END) vendus
    FROM s_article 
    WHERE vendeur=?
");
$stat->execute([$code]);
$s = $stat->fetch();

$total   = $s['total'] ?? 0;
$enVente = $s['en_vente'] ?? 0;
$vendus  = $s['vendus'] ?? 0;
$taux    = $total ? round(($vendus/$total)*100) : 0;

// Catégories dynamiques
$catStmt = $db->query("SELECT libelle_categorie FROM s_categorie ORDER BY libelle_categorie ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Vendeur</title>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{background:#f3f4f6}
.layout{display:flex;min-height:100vh}

/* Sidebar */
.sidebar{width:260px;background:#111827;color:#fff;padding:20px;position:fixed;height:100%}
.profile{text-align:center;margin-bottom:30px}
.profile img{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #ff7a18}
.profile h4{margin:10px 0 2px;color:#fff}
.profile small{color:#9ca3af}
.menu a{display:flex;align-items:center;gap:10px;padding:12px;border-radius:10px;color:#d1d5db;text-decoration:none;margin-bottom:6px;}
.menu a.active,.menu a:hover{background:#ff7a18;color:#fff}

/* Main */
.main{margin-left:260px;padding:30px;width:100%}
.header h2{margin-bottom:20px}

/* Dashboard */
.dashboard{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px}
.card-stat{background:#fff;padding:22px;border-radius:18px;box-shadow:0 10px 25px rgba(0,0,0,.06);display:flex;align-items:center;gap:18px}
.card-stat i{font-size:36px;padding:14px;border-radius:14px;color:#fff}
.bg-total{background:#6366f1}
.bg-sale{background:#10b981}
.bg-sold{background:#ef4444}
.bg-rate{background:#f59e0b}
.card-stat h3{margin:0;font-size:26px}
.card-stat small{color:#6b7280}

/* Search */
.search{background:#fff;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:10px;box-shadow:0 10px 25px rgba(0,0,0,.05)}
.search input{border:none;outline:none;width:100%;font-size:15px}

/* Articles */
.articles{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;margin-top:25px}
.article{background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,.06);display:flex;flex-direction:column}
.article img{width:100%;height:180px;object-fit:cover}
.article-body{padding:15px;flex:1}
.article-body h4{margin:0 0 6px;font-size:16px}
.article-body p{margin:3px 0;font-size:14px;color:#6b7280}
.badge{display:inline-block;padding:5px 12px;border-radius:20px;font-size:13px}
.sell{background:#e6f9f0;color:#0f9d58}
.sold{background:#fdeaea;color:#d93025}
.actions{padding:15px;border-top:1px solid #eee}
.btn{width:100%;padding:10px;border:none;border-radius:10px;background:#ff7a18;color:#fff;font-weight:600;cursor:pointer}
.btn:hover{opacity:.9}

</style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="profile">
      <img src="<?= $photo ?>">
      <h4><?= htmlspecialchars($v['prenom'].' '.$v['nom']) ?></h4>
      <small><?= htmlspecialchars($v['email']) ?></small>
    </div>
    <div class="menu">
      <a href="profile.php" class="<?= $type==''?'active':'' ?>"><i class="bx bx-grid-alt"></i> Tableau de bord</a>
      <a href="profile.php?q=v" class="<?= $type=='v'?'active':'' ?>"><i class="bx bx-store"></i> En vente</a>
      <a href="profile.php?q=e" class="<?= $type=='e'?'active':'' ?>"><i class="bx bx-check-circle"></i> Vendus</a>
      <a href="revendre.php"><i class="bx bx-plus-circle"></i> Publier</a>
      <a href="logout.php"><i class="bx bx-log-out"></i> Déconnexion</a>
    </div>
  </div>

  <!-- Main -->
  <div class="main">
    <div class="header"><h2>Tableau de bord</h2></div>

    <div class="dashboard">
      <div class="card-stat"><i class="bx bx-box bg-total"></i><div><h3><?= $total ?></h3><small>Total articles</small></div></div>
      <div class="card-stat"><i class="bx bx-store bg-sale"></i><div><h3><?= $enVente ?></h3><small>En vente</small></div></div>
      <div class="card-stat"><i class="bx bx-check-circle bg-sold"></i><div><h3><?= $vendus ?></h3><small>Vendus</small></div></div>
      <div class="card-stat"><i class="bx bx-line-chart bg-rate"></i><div><h3><?= $taux ?>%</h3><small>Taux de vente</small></div></div>
    </div>

    <div class="search">
      <i class="bx bx-search"></i>
      <input type="text" id="searchInput" placeholder="Rechercher un article…">
    </div>

    <div class="articles" id="articlesContainer"></div>
  </div>
</div>

<script>
const searchInput = document.getElementById("searchInput");
const container = document.getElementById("articlesContainer");
const type = "<?= $type ?>";

// Charger les articles
function loadArticles() {
    fetch("search_articles.php?q="+type+"&search="+encodeURIComponent(searchInput.value))
        .then(r=>r.text())
        .then(html=>container.innerHTML=html);
}

// Marquer vendu
function markSold(id){
    if(!confirm("Confirmer la vente ?")) return;
    fetch("update_article_status.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"id="+id
    }).then(res=>res.text())
      .then(t=>{console.log("RESPONSE:",t);loadArticles();})
      .catch(err=>console.error(err));
}



// Rechercher en direct
searchInput.addEventListener("input",loadArticles);
loadArticles();
</script>

</body>
</html>

<?php
session_start();
if (empty($_SESSION['code_vendeur'])) {
    header('Location: login.php');
    exit();
}

require_once '../assets/connexion/database.php';
$db = Database::connect();

$code = $_SESSION['code_vendeur'];
$type = $_GET['q'] ?? '';

// Vendeur
$stmt = $db->prepare("SELECT nom, prenom, email, photo FROM s_vendeur WHERE code_vendeur=?");
$stmt->execute([$code]);
$v = $stmt->fetch();
$photo = !empty($v['photo']) ? '../assets/img/profil/'.$v['photo'] : '../assets/img/photo/avatar.jpeg';

// Statistiques
$stat = $db->prepare("
    SELECT 
        COUNT(*) total,
        SUM(CASE WHEN date_fin IS NULL OR date_fin='' THEN 1 ELSE 0 END) en_vente,
        SUM(CASE WHEN date_fin IS NOT NULL AND date_fin!='' THEN 1 ELSE 0 END) vendus
    FROM s_article 
    WHERE vendeur=?
");
$stat->execute([$code]);
$s = $stat->fetch();

$total   = $s['total'] ?? 0;
$enVente = $s['en_vente'] ?? 0;
$vendus  = $s['vendus'] ?? 0;
$taux    = $total ? round(($vendus/$total)*100) : 0;

// Catégories dynamiques
$catStmt = $db->query("SELECT libelle_categorie FROM s_categorie ORDER BY libelle_categorie ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Vendeur</title>
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{background:#f3f4f6}
.layout{display:flex;min-height:100vh}

/* Sidebar */
.sidebar{width:260px;background:#111827;color:#fff;padding:20px;position:fixed;height:100%}
.profile{text-align:center;margin-bottom:30px}
.profile img{width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid #ff7a18}
.profile h4{margin:10px 0 2px;color:#fff}
.profile small{color:#9ca3af}
.menu a{display:flex;align-items:center;gap:10px;padding:12px;border-radius:10px;color:#d1d5db;text-decoration:none;margin-bottom:6px;}
.menu a.active,.menu a:hover{background:#ff7a18;color:#fff}

/* Main */
.main{margin-left:260px;padding:30px;width:100%}
.header h2{margin-bottom:20px}

/* Dashboard */
.dashboard{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:30px}
.card-stat{background:#fff;padding:22px;border-radius:18px;box-shadow:0 10px 25px rgba(0,0,0,.06);display:flex;align-items:center;gap:18px}
.card-stat i{font-size:36px;padding:14px;border-radius:14px;color:#fff}
.bg-total{background:#6366f1}
.bg-sale{background:#10b981}
.bg-sold{background:#ef4444}
.bg-rate{background:#f59e0b}
.card-stat h3{margin:0;font-size:26px}
.card-stat small{color:#6b7280}

/* Search */
.search{background:#fff;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:10px;box-shadow:0 10px 25px rgba(0,0,0,.05)}
.search input{border:none;outline:none;width:100%;font-size:15px}

/* Articles */
.articles{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px;margin-top:25px}
.article{background:#fff;border-radius:18px;overflow:hidden;box-shadow:0 10px 25px rgba(0,0,0,.06);display:flex;flex-direction:column}
.article img{width:100%;height:180px;object-fit:cover}
.article-body{padding:15px;flex:1}
.article-body h4{margin:0 0 6px;font-size:16px}
.article-body p{margin:3px 0;font-size:14px;color:#6b7280}
.badge{display:inline-block;padding:5px 12px;border-radius:20px;font-size:13px}
.sell{background:#e6f9f0;color:#0f9d58}
.sold{background:#fdeaea;color:#d93025}
.actions{padding:15px;border-top:1px solid #eee}
.btn{width:100%;padding:10px;border:none;border-radius:10px;background:#ff7a18;color:#fff;font-weight:600;cursor:pointer}
.btn:hover{opacity:.9}

</style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="profile">
      <img src="<?= $photo ?>">
      <h4><?= htmlspecialchars($v['prenom'].' '.$v['nom']) ?></h4>
      <small><?= htmlspecialchars($v['email']) ?></small>
    </div>
    <div class="menu">
      <a href="profile.php" class="<?= $type==''?'active':'' ?>"><i class="bx bx-grid-alt"></i> Tableau de bord</a>
      <a href="profile.php?q=v" class="<?= $type=='v'?'active':'' ?>"><i class="bx bx-store"></i> En vente</a>
      <a href="profile.php?q=e" class="<?= $type=='e'?'active':'' ?>"><i class="bx bx-check-circle"></i> Vendus</a>
      <a href="revendre.php"><i class="bx bx-plus-circle"></i> Publier</a>
      <a href="logout.php"><i class="bx bx-log-out"></i> Déconnexion</a>
    </div>
  </div>

 

<script>
const searchInput = document.getElementById("searchInput");
const container = document.getElementById("articlesContainer");
const type = "<?= $type ?>";

// Charger les articles
function loadArticles() {
    fetch("search_articles.php?q="+type+"&search="+encodeURIComponent(searchInput.value))
        .then(r=>r.text())
        .then(html=>container.innerHTML=html);
}

// Marquer vendu
function markSold(id){
    if(!confirm("Confirmer la vente ?")) return;
    fetch("update_article_status.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"id="+id
    }).then(res=>res.text())
      .then(t=>{console.log("RESPONSE:",t);loadArticles();})
      .catch(err=>console.error(err));
}



// Rechercher en direct
searchInput.addEventListener("input",loadArticles);
loadArticles();
</script>

</body>
</html>

