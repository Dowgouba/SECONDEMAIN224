<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}

$img = $_FILES['img'];
$extention = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
$nom_image = date('dmyhis').'.'.$extention;

if(isset($_SESSION['code_vendeur'])){
  // Ton code PHP inchangé pour les utilisateurs connectés
}else{
  if(in_array($extention, ['png','jpeg','jpg','gif'])){
    move_uploaded_file($img['tmp_name'], "../../assets/img/article/".$nom_image);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Connexion</title>
<style>
body{
  background:linear-gradient(135deg,#f8f9ff,#eef1ff);
  font-family:Segoe UI, sans-serif;
}

.login-card{
  max-width:420px;
  margin:60px auto;
  background:#fff;
  border-radius:30px;
  box-shadow:0 30px 80px rgba(0,0,0,.15);
  padding:35px;
}

.login-card h3{
  text-align:center;
  font-weight:800;
  color:#ff6b35;
  margin-bottom:10px;
}

.login-card p{
  text-align:center;
  color:#777;
  font-size:.95rem;
  margin-bottom:30px;
}

.form-group{
  margin-bottom:20px;
  position:relative;
}

.form-control{
  width:100%;
  height:55px;
  border-radius:30px;
  padding-left:20px;
  border:1px solid #e0e0e0;
  transition:.3s;
}

.form-control:focus{
  border-color:#ff6b35;
  box-shadow:0 10px 25px rgba(255,107,53,.25);
}

.btn-main{
  width:100%;
  padding:15px;
  border-radius:35px;
  background:linear-gradient(135deg,#ff6b35,#ff8c5a);
  border:none;
  color:#fff;
  font-size:1.05rem;
  font-weight:700;
  transition:.3s;
}

.btn-main:hover{
  transform:translateY(-3px);
  box-shadow:0 15px 35px rgba(255,107,53,.45);
}

.btn-link{
  color:#ff6b35;
  font-weight:600;
  text-decoration:none;
  cursor:pointer;
}

.actions{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:20px;
}

/* ŒIL pour mot de passe */
.toggle-password{
  position:absolute;
  top:50%;
  right:20px;
  transform:translateY(-50%);
  cursor:pointer;
  font-size:1.2rem;
  color:#ff6b35;
}
</style>
</head>

<body>

<div class="login-card">
  <h3>Connexion requise</h3>
  <p>Connectez-vous pour finaliser la publication de votre article</p>

  <div id="erreur_msg"></div>

  <form method="post" class="php-email-form">

    <div class="form-group">
      <input type="text" class="form-control" name="login" id="login"
             placeholder="Téléphone ou adresse e-mail">
    </div>

    <div class="form-group">
      <input type="password" class="form-control" name="mpasse" id="mpasse"
             placeholder="Mot de passe">
      <span class="toggle-password" onclick="togglePassword()">👁️</span>
    </div>
    <input type="hidden" name="nom_image" id="nom_image" value="<?=  $nom_image; ?>">

        <a type="submit" class="btn-main text-center" id="btn_login_termine">
      Connexion & publier
    </a>

    <div class="actions">
      <a id="btn_login_back" class="btn-link">◄ Retour</a>
      <a id="pas_de_compte" class="btn-link">Je n'ai pas de compte</a>
    </div>

  </form>
</div>

<script>
function togglePassword(){
  const passwordInput = document.getElementById('mpasse');
  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);
}
</script>

</body>
</html>

<?php
  }
}
?>
