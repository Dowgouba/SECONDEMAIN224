
<style>
  .small-box>.inner {
    padding: 10px;
}
.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}
.bg-green, .callout.callout-success, .alert-success, .label-success, .modal-success .modal-body {
    background-color: #00a65a !important;
}
col-xs-6 {
    width: 50%;
}
</style><?php 
$titre = "Profile";
if(session_status() == PHP_SESSION_NONE){
  session_start();
} 
if(!$_SESSION['code_vendeur']){
  header('Location: login.php');
  exit();
}
$id = null;
  include_once '../assets/connexion/database.php'; 

  // L'authentificaiton du l'utilisateur
  $code = $_SESSION['code_vendeur'];

  include_once 'elements/header.php'; ?>

  <main id="main">
   <!-- ======= Contact Section ======= -->
   <section id="contact" class="contact mt-4">
    <div class="container">
      <div class="row mt-4">

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          <h3 class="mt-2">Dashboard </h3>
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua card">
                <div class="inner">
                  <h3>150</h3>
                  <p>Revendeurs</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer text-center">Plus de détails <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green card">
                <div class="inner">
                  <h3>530</sup></h3>
                  <p>Articles</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer text-center">Plus de détails <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow card">
                <div class="inner">
                  <h3>44</h3>
                  <p>Messages</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer text-center">Plus de détails <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red card">
                <div class="inner">
                  <h3>3</h3>
                  <p>Administrateurs</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer text-center">Plus de détails <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->

          <table class="table table-striped mt-4">
            <tr>
              <th>Prénoms</th>
              <th>Nom</th>
              <th>Téléphone</th>
              <th>Adresse</th>
              <th>Détails</th>
            </tr>
            <?php
              $article_existe = false;
              $db = Database::connect();
              if($id==null){
                $statement = $db->query('SELECT code_vendeur, Nom, `Prenom`, lieu_residence, telephone_1, telephone_2 FROM s_vendeur ORDER BY Nom DESC');
              }elseif($id=="v"){
                $statement = $db->query('SELECT code_article, libelle, `description`, photo, date_debut, date_fin FROM s_article WHERE vendeur = "'. $code .'" AND date_fin = "" ORDER BY code_article DESC');
              }elseif($id=="e"){
                $statement = $db->query('SELECT code_article, libelle, `description`, photo, date_debut, date_fin FROM s_article WHERE vendeur = "'. $code .'" AND date_fin != "" ORDER BY code_article DESC');
              }
              while($item = $statement->fetch()){
                if($item) $article_existe = true;
            ?>
              <tr>
                <td><?= $item['Nom'] ?></td>
                <td><?= $item['Prenom'] ?></td>
                <td><?= $item['telephone_1']. '/' . $item['telephone_2'] ?></td>
                <td><?= $item['lieu_residence'] ?></td>
                <th><a href="admin-revendeurs.php" class="btn btn-primary">+</a></th>
              </tr>
            <?php } ?>
          </table>
          <?php if(!$article_existe){
              echo "<br><p>Seconde main vous remercie d'avoir créé votre compte. A présent, nous vous suggerons de revendre votre premier aricle</p>
              Pour vous lancez, cliquez sur <a href=\"revendre.php\">revendre</a>";
            }
          ?>
        </div>

        <div class="col-lg-4 team" data-aos="fade-right">
        <?php $db = Database::connect();
        $statement = $db->query('SELECT nom, prenom, email FROM s_vendeur WHERE code_vendeur = "'. $code .'"');
        $item = $statement->fetch();
        ?>
          <div class="member" data-aos="zoom-in" data-aos-delay="200">
            <div class="pic"><img src="../assets/img/photo/avatar.jpeg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4><?= $item['prenom'] .' '. $item['nom'] ?></h4>
              <span><?= $item['email'] ?></span><br>
              <a href="logout.php" class="btn btn-warning">Déconnexion</a>
            </div>
          </div>


        </div>
      </div>

    </div>
  </section><!-- End Contact Section -->

    <!-- ======= Testimonials Section ======= -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
<?php include_once 'elements/footer.php'; ?>