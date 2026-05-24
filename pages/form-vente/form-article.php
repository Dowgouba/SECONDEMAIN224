<div class="container">
  <div class="row">
    <div class="col-lg-4" data-aos="fade-right">
      <div class="section-title">
        <h2>Renvendre</h2>
        <p>Veuillez saisir dans ce formulaire, les informations réelles de votre produit.</p>
      </div>
    </div>

    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100" id="publication-form">

      <div id="erreur_msg"></div>
      <form action="revendre-info.php" method="post" id="formulaire_article" class="php-email-form mt-4">
        <div class="form-group">
          <input type="text" class="form-control" name="article_libelle" id="article_libelle" placeholder="Nom de l'article *" />
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="prix" id="prix" placeholder="Prix en GNF *" />
        </div>
        <div class="form-group row">
          <div class="col-md-6 col-lg-6">
            <input type="number" class="form-control" name="prix" id="prix" placeholder="Prix en GNF *" />
          </div>             
          <div class="col-md-6 col-lg-6">
          <select  class="form-control" id="currency" name="currency">
            <option value="GNF">Franc Guinéen (GNF)</option>
            <option value="FCFA">Franc CFA (FCFA)</option>
            <option value="USD">Dollar Américain (USD)</option>
            <option value="EUR">Euro (EUR)</option>
          </select>
          </div>
        </div>
        <div class="form-group">
          <select name="categorie" id="categorie" class="form-control">
            <option value="">Catégorie *</option>
            <?php include_once '../../assets/connexion/database.php'; 
              $db = Database::connect();
              $statement = $db->query('SELECT * FROM s_categorie');

              while ($item = $statement->fetch()) {
              ?>
                <option value="<?= $item['code_categorie']; ?>"><?= $item['libelle_categorie']; ?></option>
            <?php } ?>
          </select>
        <div class="validate"></div>
        </div>
        <div class="form-group">
          <input type="file" class="form-control" name="img" id="image" />
        </div>
        <div class="form-group">
          <textarea class="form-control" id="message" name="message" rows="5" placeholder="Description de votre article *"></textarea>
        </div>
        <div class="text-center"><a class="btn" id="btn_article" style="background: rgb(225,102,0); color: #FFFFFF">Suivant</a></div>
      </form>
    </div>
  </div>
</div>