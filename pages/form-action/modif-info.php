<?php 

  $vendeur = $_POST['id'];
  include_once '../../assets/connexion/database.php';

  $db = Database::connect();
  $statement = $db->query('SELECT * FROM s_vendeur WHERE code_vendeur ="'. $vendeur .'"');

  $item = $statement->fetch();

?>

<section id="contact" class="contact" style="padding-top: 0">

<div class="container">
    <div class="row">
        <div class="col-lg-4" data-aos="fade-right">
            <div class="section-title">
            <h2>Vendeur</h2>
            <p>Ces informations vont permettre aux clients de vous contacter, veuillez donc saisir vos vraies informations.</p>
            </div>
        </div>
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100" id="publication-form">
            <div data-aos="fade-up" data-aos-delay="100">
                <div id="erreur_msg"></div>
                <form action="forms/contact.php" method="post" role="form" class="php-email-form mt-4">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" value="<?= $item['Prenom']; ?>" class="form-control" name="prenom" id="prenom" placeholder="Votre Prénom *" />
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" value="<?= $item['Nom']; ?>" class="form-control" name="nom" id="nom" placeholder="Votre Nom *" />
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= $item['email']; ?>" class="form-control" name="email" id="email" placeholder="Email" />
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= $item['telephone_1']; ?>" class="form-control" name="tel_1" id="tel_1" placeholder="Téléphone 1 *" />
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= $item['telephone_2']; ?>" class="form-control" name="tel_2" id="tel_2" placeholder="Téléphone 2" />
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?= $item['lieu_residence']; ?>" class="form-control" name="residence" id="residence" placeholder="Lieu de résidence *" />
                    </div>
                    <div class="text-center">
                        <a id="btn_terminer" class="btn" style="background: rgb(225,102,0); color: #FFFFFF">Terminer</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</section>