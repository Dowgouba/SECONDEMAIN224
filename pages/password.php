<?php 
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
  
$mpasse = $cpasse = ""; $erreur = null; $success = true;
if(!empty($_POST['mpasse']) || !empty($_POST['mpasse'])){
  
  $mpasse = $_POST['mpasse'];
  $cpasse = $_POST['cpasse'];

  if(strlen($mpasse) < 8){
    $erreur = 'Mot de passe trop court, entrez 8 caractèrs au moins';
    $success = false;
  } elseif($mpasse !== $cpasse){
    $erreur = 'Le mot de passe saisi ne correspond pas. Veillez reprendre s\'il vous plait';
    $success = false;
  }
  if($success){
    include_once '../assets/connexion/database.php'; 
    $db = Database::connect();
    $statement = $db->query('UPDATE `s_vendeur` SET `mpasse` = "'. $mpasse.'" WHERE `s_vendeur`.`code_vendeur` = "'.$_SESSION['code_vendeur'].'"');
    if($statement){
      header('Location: profile.php');
    }

  }

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Seconde Main - Mot de passe</title>

  <link href="../assets/img/icon.png" rel="icon">
  <link href="../assets/img/apple--icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

<style>
  #contact{
    margin: 0 auto;
    padding: 30px 10px;
    border-radius: 5px;
    background-color: #fff;
  }
  @media (min-width: 768px){
    #contact {
      width: 40%;
      margin-top: 20px;
    }
  }
</style>
</head>
<body style="background: #d2d6de;">
  
   <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact mt-4">
    <div class="container">
      <div class="login-logo" style="text-align: center">
        <img src="../assets/img/logo.png" width="100" >
        <h3>Seconde Main</h3>
      </div>
      <form action="" method="post" role="form" class="php-email-form mt-4">
        <?php if($erreur){ ?>
          <div class="alert alert-danger"><?= $erreur ?></div>
        <?php } ?>
        <div class="form-group">
          <input type="password" name="mpasse" class="form-control" placeholder="Mot de passe *"/>
          <div class="validate"></div>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="cpasse" placeholder="Confirmez votre mot de passe *" />
          <div class="validate"></div>
        </div>
        <div class="text-center"><button type="submit" class="btn btn-primary">Terminer</button></div>
        <a href="login.php">Annuler</a>
      </form>
    </div>
  </section><!-- End Contact Section -->

</body>