<?php 
    include_once '../../assets/connexion/database.php'; 
    $db = Database::connect();
    $statement = $db->query('SELECT `description` FROM s_article WHERE code_article = "'. $_POST['id']. '"');
    $item = $statement->fetch();

?>

<section id="contact" class="contact" style="padding-top: 0">
  <div class="row">
    <div class="col-lg-4" data-aos="fade-right">
      <div class="section-title">
        <h2>Modifications</h2>
        <p>Veuillez saisir dans ce formulaire, les informations réelles de votre produit.</p>
      </div>
    </div>
 
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100" id="publication-form">
      <div id="erreur_msg"></div>
      <form id="form_modif_article" class="php-email-form mt-4">
        <input type="hidden" name="id" id="id">
        <div class="form-group">
          <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Nom de l'article *" />
        </div>
        <div class="form-group">
          <input type="number" class="form-control" name="prix" id="prix" placeholder="Prix en GNF *" />
        </div>
        <div class="form-group">
          <select name="categorie" id="categorie" class="form-control">
            <option value="">Catégorie *</option>
            <?php 
              $db = Database::connect();
              $statement_ = $db->query('SELECT * FROM s_categorie');

              while ($item_ = $statement_->fetch()) {
              ?>
                <option value="<?= $item_['code_categorie']; ?>"><?= $item_['libelle_categorie']; ?></option>
            <?php } ?>
          </select>
        <div class="validate"></div>
        </div>
        <div class="form-group">
          <input type="file" class="form-control" name="img" id="img" />
        </div>
        <div class="form-group">
          <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description de votre article *"><?= $item['description']; ?></textarea>
        </div>
        <div class="text-center">
            <a class="btn" href="" style="background: #F6F6F7">Annuler</a>
            <a class="btn" id="btn_valider" style="background: rgb(225,102,0); color: #FFFFFF">Valider</a>
            </div>
      </form>
    </div>
  </div>
</section><!-- End Contact Section -->
