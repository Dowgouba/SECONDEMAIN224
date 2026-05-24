<?php
include 'header.php';
$db = Database::connect();

$articles = $db->query("
    SELECT a.*, v.Prenom, v.Nom
    FROM s_article a
    JOIN s_vendeur v ON v.code_vendeur = a.vendeur
    ORDER BY a.code_article DESC
");
?>

<div class="col-12 mt-4">

<h4 class="fw-bold mb-3">Gestion des articles</h4>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success">
    Article supprimé définitivement.
</div>
<?php endif; ?>

<table class="table table-bordered table-hover bg-white shadow-sm">
<thead class="table-dark">
<tr>
  <th>Article</th>
  <th>Prix</th>
  <th>Vendeur</th>
  <th>Image</th>
  <th>Action</th>
</tr>
</thead>

<tbody>
<?php while($a = $articles->fetch()): ?>
<tr>
  <td><?= htmlspecialchars($a['libelle']) ?></td>
  <td><?= number_format($a['prix']) ?> GNF</td>
  <td><?= htmlspecialchars($a['Prenom'].' '.$a['Nom']) ?></td>
  <td>
    <?php if(!empty($a['photo'])): ?>
      <img src="../assets/img/article/<?= $a['photo'] ?>" width="60" class="rounded">
    <?php else: ?>
      —
    <?php endif; ?>
  </td>
  <td>
    <a href="actions.php?type=article&id=<?= $a['code_article'] ?>&action=delete"
       class="btn btn-sm btn-danger"
       onclick="return confirm('ATTENTION : suppression définitive. Continuer ?')">
       Supprimer définitivement
    </a>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>

</div>
</div>
</body>
</html>
