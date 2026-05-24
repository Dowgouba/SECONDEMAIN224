<?php 
$titre = "S'inscrire";
$prenom = $nom = $email = $tel_1 = $tel_2 = $residence = ""; 
$erreur = null; 
$success = false;

if(!empty($_POST)){
  $prenom = checkInput($_POST['prenom']);
  $nom = checkInput($_POST['nom']);
  $email = checkInput($_POST['email']);
  $tel_1 = checkInput($_POST['tel_1']);
  $tel_2 = checkInput($_POST['tel_2']);
  $residence = checkInput($_POST['residence']);

  if($prenom == "" || $nom == "" || $tel_1 == "" || $residence ==""){
    $erreur = "Les champs avec * sont obligatoires";
  }else{
    $success = true;
  }
}

function checkInput($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = htmlentities($data);
  return $data;
}

if($success){
  include_once '../assets/connexion/database.php'; 
  $db = Database::connect();
  $code = rand(0, 99) . date('ss') . rand(0, 99);
  $statement = $db->query('INSERT INTO `s_vendeur` (`code_vendeur`, `Nom`, `Prenom`, `email`, `telephone_1`, `telephone_2`, `lieu_residence`, `photo`, `mpasse`) 
                           VALUES ("'.$code.'","'.$nom.'","'.$prenom.'","'.$email.'","'.$tel_1.'","'.$tel_2.'","'.$residence.'","","")');
  if($statement){
    session_start();
    $_SESSION['code_vendeur'] = $code;
    header('Location: password.php');
  } 
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seconde Main 224 - S'inscrire</title>

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

.register-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.15);
  padding: 40px 30px;
  max-width: 450px;
  width: 100%;
  text-align: center;
}

.register-card img {
  width: 80px;
  margin-bottom: 10px;
  border-radius: 10px;
}

.register-card h3 {
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
  width: 100%;
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

.btn-register {
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

.btn-register:hover {
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

<div class="register-card">
  <img src="../assets/img/logo.png" alt="Seconde Main 224">
  <h3>Créer un compte</h3>

  <form method="post">
    <?php if($erreur): ?>
      <div class="alert alert-danger text-center py-2 mb-3"><?= $erreur ?></div>
    <?php endif; ?>

    <!-- Prénom -->
    <div class="mb-3 position-relative">
      <i class="bx bx-user input-icon"></i>
      <input type="text" name="prenom" class="form-control" value="<?= $prenom ?>" placeholder="Prénoms *" required>
    </div>

    <!-- Nom -->
    <div class="mb-3 position-relative">
      <i class="bx bx-user-circle input-icon"></i>
      <input type="text" name="nom" class="form-control" value="<?= $nom ?>" placeholder="Nom *" required>
    </div>

    <!-- Email -->
    <div class="mb-3 position-relative">
      <i class="bx bx-envelope input-icon"></i>
      <input type="email" name="email" class="form-control" value="<?= $email ?>" placeholder="Email">
    </div>

    <!-- Téléphone 1 -->
    <div class="mb-3 position-relative">
      <i class="bx bx-phone input-icon"></i>
      <input type="text" name="tel_1" class="form-control" value="<?= $tel_1 ?>" placeholder="Téléphone 1 *" required>
    </div>

    <!-- Téléphone 2 -->
    <div class="mb-3 position-relative">
      <i class="bx bx-phone-call input-icon"></i>
      <input type="text" name="tel_2" class="form-control" value="<?= $tel_2 ?>" placeholder="Téléphone 2">
    </div>

    <!-- Résidence -->
    <div class="mb-4 position-relative">
      <i class="bx bx-map input-icon"></i>
      <input type="text" name="residence" class="form-control" value="<?= $residence ?>" placeholder="Résidence *" required>
    </div>

    <button type="submit" class="btn-register">Suivant</button>

    <hr class="my-4">
    <div class="text-center small">
      <a href="login.php">Déjà un compte ? Se connecter</a> · 
      <a href="../index.php">Retour</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="form-compte/compte.js"></script>
</body>
</html>
