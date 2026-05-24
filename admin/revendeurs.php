<?php include 'header.php'; 
$db = Database::connect();
$revendeurs = $db->query("SELECT * FROM s_vendeur");
?>

<div class="col-12 mt-4">
<h4 class="fw-bold mb-3">Revendeurs</h4>

<table class="table table-bordered table-hover bg-white shadow-sm">
<thead class="table-dark">
<tr>
<th>Nom</th>
<th>Email</th>
<th>Téléphone</th>
<th>Statut</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($v = $revendeurs->fetch()): ?>
<tr>
<td><?= $v['Prenom'].' '.$v['Nom'] ?></td>
<td><?= $v['email'] ?></td>
<td><?= $v['telephone_1'] ?></td>
<td>
  <?= $v['statut'] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-danger">Bloqué</span>' ?>
</td>
<td>
  <a href="actions.php?type=vendeur&id=<?= $v['code_vendeur'] ?>&action=<?= $v['statut'] ? 'block':'unblock' ?>"
     class="btn btn-sm <?= $v['statut']?'btn-danger':'btn-success' ?>">
     <?= $v['statut']?'Bloquer':'Débloquer' ?>
  </a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</div></div>
</body>
</html>
