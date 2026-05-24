<?php 
$titre = 'Revendre';
include_once 'elements/header.php'; 
?>

<main id="main" style="background:linear-gradient(180deg,#fff,#f6f7fb);min-height:100vh;">
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div id="publication-form" class="col-lg-8">

        <div class="card sell-card border-0" data-aos="fade-up">
          <div class="card-body p-5">

            <h2 class="text-center mb-3 sell-title">
              Mettre en vente votre article
            </h2>
              <p class="text-center text-muted mb-5">
                Donnez des informations précises pour vendre plus vite et au meilleur prix.
              </p>
              <div id="erreur_msg"></div>
              <form id="formulaire_article" class="php-email-form" enctype="multipart/form-data">

                <!-- Nom -->
                <div class="mb-4 position-relative">
                  <i class="bx bx-tag-alt field-icon"></i>
                  <input type="text" class="form-control field-input" 
                        name="libelle" id="article_libelle"
                        placeholder="Nom de l'article *" required>
                </div>

                <!-- Prix & devise -->
                <div class="row g-3 mb-4">
                  <div class="col-md-6 position-relative">
                    <i class="bx bx-dollar field-icon"></i>
                    <input type="number" class="form-control field-input" 
                          name="prix" id="prix" placeholder="Prix *" required>
                  </div>
                  <div class="col-md-6 position-relative">
                    <i class="bx bx-money field-icon"></i>
                    <select class="form-select field-input" name="currency" id="currency">
                      <option value="GNF">GNF</option>
                      <option value="FCFA">FCFA</option>
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                    </select>
                  </div>
                </div>

                <!-- Catégorie -->
                <div class="mb-4 position-relative">
                  <i class="bx bx-category-alt field-icon"></i>
                  <select name="categorie" id="categorie" class="form-select field-input" required>
                    <option value="">Choisir une catégorie</option>
                    <?php 
                    include_once '../assets/connexion/database.php'; 
                    $db = Database::connect();
                    $statement = $db->query('SELECT * FROM s_categorie');
                    while ($item = $statement->fetch()) { ?>
                      <option value="<?= $item['code_categorie']; ?>">
                        <?= $item['libelle_categorie']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>

                <!-- Image -->
                <div class="mb-4">
                  <label class="form-label fw-semibold mb-2">
                    Photo de l'article
                  </label>
                  <div class="upload-box">
                    <input type="file" name="img" id="image" onchange="previewImage(event)">
                    <span><i class="bx bx-image-add"></i> Ajouter une image</span>
                  </div>
                  <div class="mt-3 text-center">
                    <img id="preview" class="preview-img">
                  </div>
                </div>

                <!-- Description -->
                <div class="mb-5 position-relative">
                  <i class="bx bx-detail field-icon textarea-icon"></i>
                  <textarea class="form-control field-input textarea"
                            id="description" name="description"
                            rows="5" placeholder="Décrivez votre article"></textarea>
                </div>

                <!-- Bouton -->
                <div id="cadre_btn_article" class="text-center">
                  <a id="btn_article" class="btn btn-submit">
                    Continuer
                    </a>

              </form>
            </div>  
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
</main>

<style>
/* CARD */
.sell-card{
  border-radius:30px;
  box-shadow:0 25px 60px rgba(0,0,0,0.1);
  background:rgba(255,255,255,0.95);
}

/* TITRE */
.sell-title{
  color:#ff6b35;
  font-weight:800;
}

/* INPUTS */
.field-input{
  width:100%;
  height:56px;
  border-radius:28px;
  border:1px solid #e3e6ec;
  padding-left:52px;
  background:#fff;
  transition:.3s;
}
.field-input:focus{
  border-color:#ff6b35;
  box-shadow:0 8px 24px rgba(255,107,53,0.25);
}

/* ICONES */
.field-icon{
  position:absolute;
  top:50%;
  left:20px;
  transform:translateY(-50%);
  color:#ff6b35;
  font-size:1.3rem;
}
.textarea-icon{
  top:28px;
}
.textarea{
  height:auto;
  padding-top:18px;
}

/* UPLOAD */
.upload-box{
  position:relative;
  border:2px dashed #ff6b35;
  border-radius:20px;
  padding:30px;
  text-align:center;
  cursor:pointer;
  transition:.3s;
}
.upload-box:hover{
  background:rgba(255,107,53,0.05);
}
.upload-box input{
  position:absolute;
  inset:0;
  opacity:0;
  cursor:pointer;
}
.upload-box span{
  color:#ff6b35;
  font-weight:600;
}
.upload-box i{
  font-size:1.8rem;
  display:block;
  margin-bottom:6px;
}

/* IMAGE PREVIEW */
.preview-img{
  display:none;
  max-height:260px;
  border-radius:20px;
  box-shadow:0 12px 30px rgba(0,0,0,0.15);
  object-fit:cover;
}

/* BOUTON */
.btn-submit{
  width:100%;
  padding:15px;
  background:linear-gradient(135deg,#ff6b35,#ff8c5a);
  border-radius:30px;
  font-size:1.1rem;
  font-weight:600;
  color:#fff;
  border:none;
  transition:.3s;
}
.btn-submit:hover{
  transform:translateY(-3px);
  box-shadow:0 15px 35px rgba(255,107,53,0.4);
}
</style>

<script>
function previewImage(event){
  const preview = document.getElementById('preview');
  preview.src = URL.createObjectURL(event.target.files[0]);
  preview.style.display = 'block';
}
</script>

<?php include_once 'elements/footer.php'; ?>
