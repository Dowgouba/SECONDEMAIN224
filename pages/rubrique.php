<?php 
  $titre = "Article par catégorie";
  include_once 'elements/header.php';
  include_once '../assets/connexion/database.php'; 
  
  if(!empty($_GET['q'])){
    
    $id = checkInput($_GET['q']);

  }else{
    $id = null;
  }

  function checkInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);

    return $data;
  }
  $db = Database::connect();
  $statement = $db->query('SELECT libelle_categorie, `description` FROM s_categorie WHERE code_categorie="'. $id.'"');
  
  $item = $statement->fetch();

  ?>

<main id="main">

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio mt-4">
      <div class="container">

        <div class="section-title" data-aos="fade-left">
          <h2><?= $item['libelle_categorie']; ?></h2>
          <p><?= $item['description']; ?></p>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
          <?php include_once '../assets/connexion/database.php'; 
            $article_existe = false;
            $db = Database::connect();
            $statement = $db->query('SELECT code_article, libelle, s_article.photo, prix, currency, code_categorie FROM s_article, s_categorie WHERE s_article.categorie = code_categorie AND code_categorie = "'. $id .'" AND date_fin = "" ORDER BY `s_article`.`code_article` DESC');
            While($item = $statement->fetch()){
            if($item) $article_existe = true;
          ?>
            <div class="col-lg-4 col-md-6 portfolio-item fiter-web">
            <a href="details-article.php?q=<?= $item['code_article']; ?>" title="Cliquez pour plus de détails">
              <div>
                <img src="../assets/img/article/<?= ($item['photo'])? $item['photo'] : 'default.png'; ?>" class="img-fluid" alt="" style="height: 15rem">
                <p style="position:absolute; bottom:30px; border-top-right-radius: 10px; padding: 10px; color: #fff; background: #333; display: block; opacity: 0.8"><?= $item['libelle']; ?></p>
                <p class="text-center text-white m-0" style="border: 1px solid; padding: 10px; background:rgb(225,102,0); font-weight:bolder; z-index: 1000"><?= number_format((float)$item['prix'], 0, '', ' ') . ' ' . $item['currency']; ?></p>
              </div>
              </a>
            </div>
          <?php } ?>
          <?php if(!$article_existe){
            echo '<h5 class="text-center">Aucun article disponible pour cette catégorie</h5>';

            }
          ?>

        </div>

      </div>
    </section><!-- End Portfolio Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us mt-4">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-right">
            <div class="content">
              <h3>Achat et vente des biens d'occasion</h3>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-receipt"></i>
                    <h4>Economiser plus</h4>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-cube-alt"></i>
                    <h4>Gagner plus</h4>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-images"></i>
                    <h4>Preserver l'environnement</h4>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->
      
    <!-- ======= Section Commantaire ======= -->
    <?php //include_once 'elements/commentaire.php'; ?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php include_once 'elements/footer.php' ?>


