<?php 
$titre = "Login";

$login = $mpasse = ""; 
$erreur = $pw_forgot = null;

if(!empty($_POST['login']) && !empty($_POST['mpasse'])){
  $login = $_POST['login'];
  $mpasse = $_POST['mpasse'];

  include_once '../assets/connexion/database.php'; 
  $db = Database::connect();

  $statement = $db->query('SELECT code_vendeur, nom, prenom, email, telephone_1, telephone_2, mpasse 
                           FROM s_vendeur 
                           WHERE mpasse = "'. $mpasse .'" 
                           AND (email = "'. $login .'" OR telephone_1 = "'. $login . '" OR telephone_2 = "'. $login . '")');
  $item = $statement->fetch();
  
  if($item){
    session_start();
    $_SESSION['code_vendeur'] = $item['code_vendeur'];
    header('Location: profile.php');
    exit();
  } else {
    $erreur = "Identifiants incorrects";
    $pw_forgot = "Mot de passe oublié ?";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seconde Main 224 - Connexion</title>

<link href="../assets/img/icon.png" rel="icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
body {
  background: linear-gradient(135deg, #ff6b35, #fcb045);
  font-family: "Inter", sans-serif;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
.login-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.15);
  padding: 40px 30px;
  max-width: 400px;
  width: 100%;
  text-align: center;
}
.login-card img {
  width: 80px;
  margin-bottom: 10px;
  border-radius: 10px;
}
.login-card h3 {
  font-weight: 700;
  color: #222;
  margin-bottom: 25px;
}
.form-control {
  height: 52px;
  border-radius: 25px;
  padding-left: 45px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  border: 1px solid #ddd;
  transition: all 0.3s ease;
}
.form-control:focus {
  border-color: #ff6b35;
  box-shadow: 0 8px 24px rgba(255,107,53,0.25);
}
.input-icon {
  position: absolute;
  left: 18px;
  top: 50%;
  transform: translateY(-50%);
  color: #ff6b35;
  font-size: 1.2rem;
}
.password-container {
  position: relative;
}
.toggle-password {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  font-size: 1.2rem;
  color: #999;
}
.btn-login {
  width: 100%;
  background: #ff6b35;
  border: none;
  color: #fff;
  font-weight: 600;
  font-size: 1.05rem;
  border-radius: 25px;
  padding: 12px 0;
  box-shadow: 0 6px 18px rgba(255,107,53,0.25);
  transition: all 0.3s ease;
}
.btn-login:hover {
  background: #e85a20;
  transform: translateY(-2px);
}
a {
  text-decoration: none;
  color: #ff6b35;
  font-weight: 500;
}
a:hover {
  color: #e85a20;
  text-decoration: underline;
}
</style>
</head>

<body>

<div class="login-card">
  <img src="../assets/img/logo.png" alt="Seconde Main 224">
  <h3>Seconde Main 224</h3>

  <form method="post">
    <?php if($erreur): ?>
      <div class="alert alert-danger text-center py-2 mb-3"><?= $erreur ?></div>
    <?php endif; ?>

    <!-- Login -->
    <div class="mb-3 position-relative">
      <i class="bx bx-user input-icon"></i>
      <input type="text" name="login" class="form-control" placeholder="Email ou Téléphone *" required>
    </div>

    <!-- Password -->
    <div class="mb-4 password-container position-relative">
      <i class="bx bx-lock input-icon"></i>
      <input type="password" id="password" class="form-control" name="mpasse" placeholder="Mot de passe" required>
      <i class="bx bx-show toggle-password" onclick="togglePassword()"></i>
    </div>

    <!-- Button -->
    <button type="submit" class="btn-login">Se connecter</button>

    <?php if($erreur): ?>
      <div class="text-end mt-3"><a href="#"><?= $pw_forgot ?></a></div>
    <?php endif; ?>

    <hr class="my-4">
    <div class="text-center small">
      <a href="resister.php">Créer un compte</a> ·
      <a href="../index.php">Retour</a>
    </div>
  </form>
</div>

<script>
function togglePassword() {
  const passwordField = document.getElementById('password');
  const toggleIcon = document.querySelector('.toggle-password');
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleIcon.classList.replace('bx-show','bx-hide');
  } else {
    passwordField.type = 'password';
    toggleIcon.classList.replace('bx-hide','bx-show');
  }
}
</script>

</body>
</html>
