<?php
include_once 'assets/connexion/database.php';
$connexion = "Mon profil";

function cleanInput(string $data): string {
    return htmlspecialchars(trim((string)$data), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function jsonResponse($data) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

// -------- AJAX endpoint: load articles ----------
if (isset($_GET['action']) && $_GET['action'] === 'load_articles') {
    $category = isset($_GET['category']) && $_GET['category'] !== '' ? (string)$_GET['category'] : null;
    $offset = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;
    $limit = isset($_GET['limit']) ? max(1, min(48, (int)$_GET['limit'])) : 12;
    $search = isset($_GET['search']) && $_GET['search'] !== '' ? trim($_GET['search']) : null;

    try {
        $db = Database::connect();
        $sql = "SELECT a.*, c.libelle_categorie 
                FROM s_article a 
                INNER JOIN s_categorie c ON a.categorie = c.code_categorie";
        $conditions = [];
        $params = [];
        if ($category) { $conditions[] = "a.categorie = :cat"; $params[':cat'] = $category; }
        if ($search) { $conditions[] = "(a.libelle LIKE :search OR a.description LIKE :search)"; $params[':search'] = "%$search%"; }
        if ($conditions) { $sql .= " WHERE " . implode(' AND ', $conditions); }
        $sql .= " ORDER BY a.date_debut DESC LIMIT :lim OFFSET :off";

        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        if ($articles) {
            foreach ($articles as $item) {
                $titre = cleanInput($item['libelle']);
                $desc = cleanInput($item['description']);
                $prix = isset($item['prix']) ? number_format((float)$item['prix'],0,',',' ')." GNF" : '—';
                $photo = cleanInput($item['photo'] ?? '');
                $code = urlencode($item['code_article'] ?? '');
                $imgPath = file_exists("assets/img/article/{$photo}") ? "assets/img/article/{$photo}" : "assets/img/article/default.jpg";
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 article-item">
                    <div class="card article-card h-100 border-0 shadow-sm position-relative">
                        <div class="position-relative">
                            <img src="<?= $imgPath ?>" alt="<?= $titre ?>" class="card-img-top">
                            <span class="badge price-badge"><?= $prix ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="title mb-1 text-truncate" title="<?= $titre ?>"><?= $titre ?></h6>
                            <p class="text-muted small mb-1 flex-grow-1"><?= (strlen($desc) > 80) ? substr($desc,0,80).'…' : $desc ?></p>
                            <span class="small text-muted mb-2">Catégorie: <?= cleanInput($item['libelle_categorie']) ?></span>
                            <div class="d-flex gap-2 position-relative">
                                <a href="pages/details-article.php?q=<?= $code ?>" class="btn btn-sm w-100">Voir</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary share-btn" data-url="https://secondemain224.com/pages/details-article.php?q=<?= $code ?>">Partager</button>
                                <div class="share-popup shadow-sm" style="display:none; position:absolute; top:-160px; right:0; z-index:50; background:#fff; border-radius:10px; padding:6px; width:200px;">
                                    <?php $fullUrl = "https://secondemain224.com/pages/details-article.php?q=".$code; ?>
                                    <?php $imgUrl = "https://secondemain224.com/".$imgPath; ?>
                                    <button class="btn btn-sm w-100 text-start" onclick="copyLink('<?= $fullUrl ?>')"><i class='bx bx-link-alt'></i> Copier le lien</button>
                                    <a class="btn btn-sm w-100 text-start" target="_blank" href="https://wa.me/?text=<?= urlencode('Découvrez cet article : '.$titre.' '.$fullUrl) ?>"><i class='bx bxl-whatsapp'></i> WhatsApp</a>
                                    <a class="btn btn-sm w-100 text-start" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($fullUrl) ?>&picture=<?= urlencode($imgUrl) ?>&title=<?= urlencode($titre) ?>&description=<?= urlencode($desc) ?>"><i class='bx bxl-facebook'></i> Facebook</a>
                                    <a class="btn btn-sm w-100 text-start" target="_blank" href="https://twitter.com/intent/tweet?url=<?= urlencode($fullUrl) ?>&text=<?= urlencode($titre) ?>&via=SecondeMain224"><i class='bx bxl-twitter'></i> X (Twitter)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12"><div class="alert alert-warning mb-0">Aucun article trouvé.</div></div>';
        }
        $html = ob_get_clean();
        jsonResponse(['status'=>'ok','html'=>$html]);
    } catch (PDOException $e) {
        jsonResponse(['status'=>'error','message'=>'Erreur de lecture des articles.']);
    }
}

// Newsletter
$newsletterMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newsletter'])) {
    $emailRaw = (string)($_POST['newsletter'] ?? '');
    $email = filter_var(trim($emailRaw), FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newsletterMsg = '<div class="alert alert-danger">Erreur : l\'adresse <strong>' . cleanInput($emailRaw) . '</strong> n\'est pas valide.</div>';
    } else {
        try {
            $db = Database::connect();
            $stmt = $db->prepare('SELECT COUNT(*) AS cnt FROM s_joignez WHERE email = :email');
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && $row['cnt'] > 0) {
                $newsletterMsg = '<div class="alert alert-warning">L\'email <strong>' . cleanInput($email) . '</strong> est déjà inscrit.</div>';
            } else {
                $ins = $db->prepare('INSERT INTO s_joignez (email) VALUES (:email)');
                $ins->execute([':email' => $email]);
                $newsletterMsg = '<div class="alert alert-success">Merci ! <strong>' . cleanInput($email) . '</strong> a bien été enregistré.</div>';
            }
        } catch (PDOException $e) {
            $newsletterMsg = '<div class="alert alert-danger">Erreur serveur. Réessayez plus tard.</div>';
        }
    }
}

// Categories
try {
    $db = Database::connect();
    $catsStmt = $db->query("SELECT code_categorie, libelle_categorie, icon FROM s_categorie ORDER BY libelle_categorie DESC");
    $categories = $catsStmt ? $catsStmt->fetchAll(PDO::FETCH_ASSOC) : [];
} catch (PDOException $e) {
    $categories = [];
}
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Seconde Main 224 — Accueil</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
:root{--primary:#ff6b35;--muted:#6c757d;--bg:#f7f9fb;--card-shadow:0 6px 18px rgba(15,23,42,0.06);}
body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;background:var(--bg);color:#222;padding-bottom:100px;}
header.site-header{background:linear-gradient(90deg,var(--primary),#e85a20);position:sticky;top:0;z-index:1100;box-shadow:0 4px 18px rgba(0,0,0,0.08);}
.site-header .brand{color:#fff;font-weight:700;}
.site-header .nav-link{color: rgba(255,255,255,0.95) !important;}
.site-header .nav-link:hover{text-decoration:underline;color:#fff !important;}
.article-card{border-radius:12px;overflow:hidden;background:#fff;box-shadow:var(--card-shadow);transition:transform .22s ease, box-shadow .22s ease;}
.article-card img{width:100%;height:160px;object-fit:cover;display:block;}
.article-card:hover{transform:translateY(-6px);box-shadow:0 18px 40px rgba(15,23,42,0.08);}
.price-badge{position:absolute;right:10px;top:10px;background:var(--primary);color:#fff;padding:.4rem .6rem;border-radius:8px;font-weight:600;font-size:.85rem;box-shadow:0 6px 18px rgba(255,107,53,0.14);}
.cat-circle{width:72px;height:72px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;background:#fff;box-shadow:var(--card-shadow);cursor:pointer;transition:transform .18s ease;}
.cat-circle:hover{transform:scale(1.08);}
.cat-circle i{font-size:28px;color:var(--primary);}
.cat-item{width:96px;margin:8px;text-align:center;font-size:0.85rem;color:#333;transition:all .2s;}
.cat-item:hover .cat-circle{transform:scale(1.1);}
.bottom-nav{position:fixed;bottom:12px;left:50%;transform:translateX(-50%);width:calc(100% - 32px);max-width:720px;background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,0.08);z-index:1200;display:flex;justify-content:space-around;padding:.45rem 8px;}
.bottom-nav a{color:var(--muted);font-size:.85rem;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:4px;padding:6px 10px;}
.bottom-nav a.active, .bottom-nav a:hover{color:var(--primary);}
.search-wrapper{position:relative;}
.search-wrapper input{border-radius:50px;padding:12px 20px 12px 40px;font-size:1rem;border:1px solid #ddd;box-shadow:0 4px 12px rgba(0,0,0,0.05);transition:all .2s;}
.search-wrapper input:focus{outline:none;border-color:var(--primary);box-shadow:0 4px 12px rgba(255,107,53,0.2);background-color:#fff;}
.search-wrapper input::placeholder{color:#aaa;font-style:italic;}
.search-wrapper i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#aaa;font-size:1.1rem;pointer-events:none;}
.share-popup button, .share-popup a{font-size:0.82rem; display:flex; align-items:center; gap:6px; padding:3px 6px;}
.spinner-container{text-align:center;padding:30px 0;}
</style>
</head>
<body>

<!-- Header -->
<header class="site-header py-2">
<div class="container">
<nav class="navbar navbar-expand-lg navbar-dark" style="padding:0;">
<a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
<img src="assets/img/icon.png" width="44" height="44" style="border-radius:50px;object-fit:cover;">
<span class="brand">Seconde Main 224</span>
</a>

<!-- Search Mobile -->
<form class="d-lg-none w-100 mt-2" id="mobileSearchForm">
<div class="input-group">
<input type="search" name="search" id="mobileSearch" class="form-control" placeholder="Rechercher..." onkeyup="filterArticlesMobile()" style="border-radius:10px;">
</div>
</form>

<!-- Burger -->
<button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
<i class='bx bx-menu' style="font-size:32px; color:white;"></i>
</button>

<!-- Menu -->
<div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
<ul class="navbar-nav align-items-lg-center text-center">
<li class="nav-item"><a class="nav-link px-3" href="index.php">Accueil</a></li>
<li class="nav-item"><a class="nav-link px-3" href="pages/revendre.php">Revendre</a></li>
<li class="nav-item"><a class="nav-link px-3" href="pages/nous.php">Qui sommes-nous</a></li>
<li class="nav-item"><a class="nav-link px-3" href="pages/contact.php">Contact</a></li>
<li class="nav-item mt-2 mt-lg-0">
<a class="btn btn-outline-light px-3" href="pages/profile.php">
<i class='bx bx-user' style="font-size:1.2rem;"></i>
</a>
</li>
</ul>
</div>
</nav>
</div>
</header>

<!-- Hero -->
<section class="py-4">
<div class="container">
<div class="row align-items-center gy-3">
<div class="col-lg-7">
<h2 class="mb-2">Bienvenue sur <span style="color:var(--primary)">Seconde Main 224</span></h2>
<p class="small-muted">Achetez et vendez facilement des biens d'occasion. Publiez en quelques clics, discutez et organisez la livraison.</p>
<form id="searchForm" class="d-flex gap-2 mt-3" onsubmit="event.preventDefault();">
<div class="search-wrapper w-100">
<i class='bx bx-search'></i>
<input id="searchInput" class="form-control form-control-lg" type="search" placeholder="Rechercher un article (titre, description)...">
</div>
</form>
</div>
<div class="col-lg-5 text-center">
<img src="assets/img/hero-bg.jpg" alt="hero" style="max-width:100%; border-radius:10px; box-shadow:var(--card-shadow); height:190px; object-fit:cover;">
</div>
</div>
</div>
</section>

<!-- Categories -->
<section id="categories" class="py-3">
<div class="container d-flex flex-nowrap overflow-auto gap-3">
<div class="cat-item text-center flex-shrink-0" onclick="selectCategory('')">
<div class="cat-circle"><i class="bx bx-list-ul"></i></div>
<div class="mt-1 small">Tous</div>
</div>
<?php foreach($categories as $cat): ?>
<div class="cat-item text-center flex-shrink-0" onclick="selectCategory('<?= cleanInput($cat['code_categorie']) ?>')">
<div class="cat-circle"><i class="bx <?= cleanInput($cat['icon']) ?>"></i></div>
<div class="mt-1 small"><?= cleanInput($cat['libelle_categorie']) ?></div>
</div>
<?php endforeach; ?>
</div>
</section>

<!-- Articles -->
<section class="py-4">
<div class="container">
<div id="articlesGrid" class="row g-4">
<div class="spinner-container">
<div class="spinner-border text-muted" role="status"><span class="visually-hidden">Chargement...</span></div>
</div>
</div>
</div>
</section>

<!-- Bottom nav -->
<nav class="bottom-nav">
<a href="index.php" class="active"><i class="bx bx-home"></i><span>Accueil</span></a>
<a href="pages/revendre.php"><i class="bx bx-plus-circle"></i><span>Vendre</span></a>
<a href="pages/profile.php"><i class="bx bx-user"></i><span>Profil</span></a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const articlesGrid = document.getElementById('articlesGrid');
const searchInput = document.getElementById('searchInput');
let currentCategory = '';
let currentSearch = '';
let offset = 0;
const limit = 12;
let loading = false;
let allLoaded = false;

function renderArticles(html, append=true){
    const tmp = document.createElement('div'); tmp.innerHTML = html;
    if(!append) articlesGrid.innerHTML = '';
    while(tmp.firstChild) articlesGrid.appendChild(tmp.firstChild);
}

function loadArticles(reset=false){
    if(loading || allLoaded) return;
    loading = true;
    if(reset){ offset=0; allLoaded=false; articlesGrid.innerHTML = '<div class="spinner-container"><div class="spinner-border"></div></div>'; }
    fetch(`index.php?action=load_articles&category=${encodeURIComponent(currentCategory)}&search=${encodeURIComponent(currentSearch)}&offset=${offset}&limit=${limit}`)
    .then(res=>res.json())
    .then(data=>{
        if(data.status==='ok'){
            if(data.html.trim()===''){ allLoaded=true; if(reset){ articlesGrid.innerHTML='<div class="col-12"><div class="alert alert-warning mb-0">Aucun article trouvé.</div></div>'; } }
            renderArticles(data.html, !reset);
            offset += limit;
        }
        loading=false;
    }).catch(err=>{ console.error(err); loading=false; });
}

function selectCategory(catCode){ currentCategory = catCode; offset=0; allLoaded=false; loadArticles(true); }
searchInput.addEventListener('keyup', e=>{ currentSearch = e.target.value.trim(); offset=0; allLoaded=false; loadArticles(true); });
window.addEventListener('scroll', ()=>{ if(window.innerHeight + window.scrollY >= document.body.offsetHeight - 150){ loadArticles(); } });
document.addEventListener('DOMContentLoaded', ()=>loadArticles());

document.addEventListener('click', e=>{
    document.querySelectorAll('.share-popup').forEach(sp=>sp.style.display='none');
    if(e.target.classList.contains('share-btn')){
        const popup = e.target.parentNode.querySelector('.share-popup');
        if(popup) popup.style.display='block';
    }
});

function copyLink(url){ navigator.clipboard.writeText(url).then(()=>alert('Lien copié !')); }

function filterArticlesMobile(){
    let value = document.getElementById("mobileSearch").value.toLowerCase();
    let articles = document.querySelectorAll(".article-card");
    articles.forEach(card => {
        let title = card.querySelector(".title").innerText.toLowerCase();
        card.style.display = title.includes(value) ? "block" : "none";
    });
}
</script>
</body>
</html>
