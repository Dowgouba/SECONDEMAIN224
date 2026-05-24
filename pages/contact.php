<?php 
  $titre = "Contact";
  $newsletter = '';
  include_once 'elements/header.php'; 

  ?>

  <main id="main">
   <!-- ======= Contact Section ======= -->
   <section id="c ontact" class="contact mt-4">
    <div class="container">

    <?= $newsletter; ?>
      <div class="row">
        <div class="col-lg-4" data-aos="fade-right">
          <div class="section-title">
            <h2>Contactez-nous</h2>
            <p>Juste en bas se trouve un formulaire à remplir pour nous contacter ou nous faire part de vos suggestions.</p>
          </div>
        </div>

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d983.5929162339532!2d-13.648249999999999!3d9.5631944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zOcKwMzMnNDcuNSJOIDEzwrAzOCc1My43Ilc!5e0!3m2!1sfr!2s!4v1682721604706!5m2!1sfr!2s" frameborder="0" allowfullscreen></iframe>
          <div class="info mt-4">
            <i class="icofont-google-map"></i>
            <h4>Adresse:</h4>
            <p>Carrière cité, Matam, Conakry</p>
          </div>
          <div class="row">
            <div class="col-lg-6 mt-4">
              <div class="info">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p>secondemain880@gmail.com</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="info w-100 mt-4">
                <i class="icofont-phone"></i>
                <h4>Téléphone:</h4>
                <p>+224 623 02 75 39</p>
              </div>
            </div>
          </div>

          <form action="../forms/contact.php" method="POST" class="php-email-form mt-4">
            <div class="form-row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Votre Nom *" data-rule="minlen:2" data-msg="S'il vous plait, entrez un nom valide" />
                <div class="validate"></div>              
              </div>
              <div class="col-md-6 form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email *" data-rule="email" data-msg="S'il vous plait, entrez un email valide" />
                <div class="validate"></div>              
              </div>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Objet" data-rule="minlen:8" data-msg="S'il vous plait, entrez au moins 8 caractères" />
              <div class="validate"></div>              
            </div>
            <div class="form-group">
              <textarea class="form-control" name="message" rows="5" placeholder="Votre message ici... *" data-rule="required" data-msg="S'il vous plait, écrivez nous quelque chose..."></textarea>
              <div class="validate"></div>            
            </div>
            <div class="mb-3">
              <div class="loading">Chargement...</div>
              <div class="error-message"></div>
              <div class="sent-message">Votre email a été envoyé. Merci !</div>
            </div>
            <div class="text-center"><button type="submit">Envoyer</button></div>
          </form>

          <form action="envoyer_mail.php" method="post">
  <label>Nom :</label><br>
  <input type="text" name="nom" required><br><br>

  <label>Email :</label><br>
  <input type="email" name="email" required><br><br>

  <label>Message :</label><br>
  <textarea name="message" required></textarea><br><br>

  <input type="submit" value="Envoyer">
</form>


        </div>
      </div>

    </div>
  </section><!-- End Contact Section -->

    <!-- ======= Section Commantaire ======= -->
    <?//php include_once 'elements/commentaire.php'; ?>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  
  <?php include_once 'elements/footer.php'; ?>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "abdowgouba@gmail.com"; // Remplace par ton adresse
    $sujet = "Message de $nom depuis le site web";
    $contenu = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $sujet, $contenu, $headers)) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>