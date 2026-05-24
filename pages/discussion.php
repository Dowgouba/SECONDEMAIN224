<?php 
  $titre = "article";
  include_once 'elements/header.php';
  include_once '../assets/connexion/database.php'; 
  
  $id = "";

  if(!empty($_GET['q'])){
    $id = checkInput($_GET['q']);
  }


  function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);

    return $data;
  }
  $db = Database::connect();
  $statement = $db->query('SELECT code_article, vendeur, libelle, prix, currency, s_article.photo, s_article.description, date_fin, nom, prenom, email, telephone_1, telephone_2, lieu_residence FROM s_article, s_vendeur WHERE code_vendeur=vendeur AND code_article="'. $id .'"');
  
  $item = $statement->fetch();

  ?>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Détails sur mon article</h2>
          <?php if($item['date_fin']!= '') { ?>
            <div class="alert"><em>Cet article est déjà vendu, il ne sera plus disponible sur le marché.</em></div>
            <?php } ?>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details" style="padding-top: 10px">
      <div class="container">
        <div id="actions">
          <div id="action_card">
          <p>
            <?php if(!$item['date_fin']!= '') { ?>
              <a id="vendu" style="background: rgb(225,102,0);" class="btn text-white" desabled>Déjà vendu</a>
              <a id="modifier" style="background: rgb(225,102,0);" class="btn text-white">Modifier</a>
              <!-- <a id="supprimer" class="btn btn-danger">Supprimer</a> -->
            <?php } ?>
          </p>
          
          <!-- ========== Modification card ========= -->
          </div>
          <!-- ============ End Modification card ======== -->
        
        </div>
        <div class="portfolio-details-container" data-aos="fade-up" data-aos-delay="100">

            <img src="../assets/img/article/<?= $item['photo']; ?>" class="img-fluid" alt="">

          <div class="portfolio-info">
            <h3><?= number_format((float)$item['prix'], 0, '', ' ') . ' ' . $item['currency']; ?></h3>
            <ul>
              <li><strong>Article</strong>: <?= $item['libelle']; ?></li>
              <li><strong>Vendeur</strong>: <?= $item['prenom']. ' ' .$item['nom']; ?></li>
              <li><strong>Résidence</strong>: <?= $item['lieu_residence']; ?></li>
              <li><strong>E-mail</strong>: <?= $item['email']; ?></li>
              <li><strong>Téléphone</strong>: <?= $item['telephone_1']; ?><?= $item['telephone_2']? '/'.$item['telephone_2']: ''; ?></li>
            </ul>
            <form action="">
              <input id="vendeur" type="hidden" value="<?= $item['vendeur'] ?>">
              <input id="article" type="hidden" value="<?= $item['code_article'] ?>">
            </form>
          </div>

        </div>
      
        <div class="portfolio-description">
          <h2>Détails sur mon article</h2>
          <p><?= $item['description']; ?></p>
        </div>        
        
        <!-- Ecrivez-nous un message -->
        
        <!-- End écrivez-nous un message -->



      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

<?php include_once 'elements/footer.php'; ?>
<script src="form-action/action23.js"></script>