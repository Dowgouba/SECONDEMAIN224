<div class="container">
  <div class="row">
    <div class="col-lg-4" data-aos="fade-right">
        <div class="section-title">
        <h2>Sécurité</h2>
        <p>Vous avez presque fini. Pour sécuriser vos données, veuillez entrer un mot de passe de 8 caractères au moins.</p>
        </div>
    </div>
    <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100" id="publication-form">
      <div data-aos="fade-up" data-aos-delay="100">
        <div id="erreur_msg"></div>
        <form action="forms/contact.php" method="post" role="form" class="php-email-form mt-4">
          <div class="form-group password-container">
            <input type="password" id="password" class="form-control" name="mpasse" placeholder="Mot de passe"/>
            <span class="toggle-password" onclick="togglePassword()">👁️</span>
          </div>
          <div class="form-group password-container">
            <input type="password" class="form-control" name="confirm_mpasse" id="confirm_mpasse" placeholder="Confirmer le mot de passe" />
            <span class="toggle-password2" onclick="togglePassword2()">👁️</span>
          </div>
          <div class="text-center">
            <a id="btn_secure_back" class="btn" style="">◄ Précedent</a>
            <a id="btn_secure_termine" class="btn" style="background: rgb(225,102,0); color: #FFFFFF">Terminer ˯</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
