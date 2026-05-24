<?php
session_start();
require_once '../assets/connexion/database.php';

if (!isset($_SESSION['code_vendeur'])) {
    exit();
}

$db = Database::connect();
$vendeur = $_SESSION['code_vendeur'];

$type   = $_GET['q'] ?? '';
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM s_article WHERE vendeur = ?";
$params = [$vendeur];

if ($type === 'v') {
    $sql .= " AND (date_fin IS NULL OR date_fin = '')";
} elseif ($type === 'e') {
    $sql .= " AND date_fin IS NOT NULL AND date_fin != ''";
}

if (!empty($search)) {
    $sql .= " AND libelle LIKE ?";
    $params[] = "%$search%";
}

$sql .= " ORDER BY code_article DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$articles) {
    echo "<p style='padding:20px;color:#6b7280'>Aucun article trouvé</p>";
    exit();
}

foreach ($articles as $a):
    $vendu = !empty($a['date_fin']);
?>
<div class="article">
    <img src="../assets/img/article/<?= htmlspecialchars($a['photo']) ?>" alt="">

    <div class="article-body">
        <h4><?= htmlspecialchars($a['libelle']) ?></h4>
        <p><?= number_format($a['prix'], 0, ',', ' ') ?> FCFA</p>
        <span class="badge <?= $vendu ? 'sold' : 'sell' ?>">
            <?= $vendu ? 'Vendu' : 'En vente' ?>
        </span>
    </div>

    <div class="actions">
        <?php if (!$vendu): ?>
            <button class="btn btn-sold" onclick="markSold(<?= (int)$a['code_article'] ?>)">
                <i class="bx bx-check-circle"></i> Marquer vendu
            </button>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>

<!-- Bottom nav -->
<nav class="bottom-nav">
    <a href="../index.php">
        <i class="bx bx-home"></i>
        <span>Accueil</span>
    </a>

    <a href="revendre.php">
        <i class="bx bx-plus-circle"></i>
        <span>Vendre</span>
    </a>

    <a href="profile.php"  class="active">
        <i class="bx bx-user"></i>
        <span>Profil</span>
    </a>
</nav>

<style>
    .bottom-nav{position:fixed;bottom:12px;left:50%;transform:translateX(-50%);width:calc(100% - 32px);max-width:720px;background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(0,0,0,0.08);z-index:1200;display:flex;justify-content:space-around;padding:.45rem 8px;}
    .bottom-nav a{color:var(--muted);font-size:.85rem;text-align:center;text-decoration:none;display:flex;flex-direction:column;align-items:center;gap:4px;padding:6px 10px;}
    .bottom-nav a.active, .bottom-nav a:hover{color:var(--primary);}
</style>

