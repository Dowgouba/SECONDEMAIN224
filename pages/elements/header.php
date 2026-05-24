<?php
  $connexion = "Mon profil";

  if(!empty($_POST['newsletter'])){

    function isEmailValid($email) {
        // Expression régulière pour vérifier l'adresse email
        $pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
        return preg_match($pattern, $email);
    }
    
    
    function checkInput($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = htmlentities($data);
      
      return $data;
    }
    $email = checkInput($_POST['newsletter']);
    
    if (isEmailValid($email)) {
        include_once '../assets/connexion/database.php'; 
        // L'adresse email est valide
        $email_exist = false;
        $newsletter = "";
        $db = Database::connect();
        $statement = $db->query('SELECT email FROM s_joignez');
        
        while($item = $statement->fetch()){
          if($item['email'] == $email) { 
            $email_exist = true;
            $newsletter = '<div class="alert alert-warning">Desolé, l\'email ' . $email . ' est déjà enregistré dans notre newsletter</div>';
          }
        }
        if(!$email_exist){
          $statement = $db->query('INSERT INTO `s_joignez` (`email`) VALUES ("'. $email .'")');
          $newsletter = '<div class="alert alert-success">L\'email ' . $email . ' est enregistré avec succès dans notre newsletter</div>';
          
        }
      
    } else {
        // L'adresse email n'est pas valide
        $newsletter = '<div class="alert alert-danger">Erreur, l\'email ' . $email . ' n\'est pas valide. Veuillez saisir un email valide</div>';

    }

  }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Seconde Main - <?= (isset($titre))? $titre: '' ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/icon.png" rel="icon">
  <link href="../assets/img/apple-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="../assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style3.css" rel="stylesheet">
  <style>


</style>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center">
        <div class="logo mr-auto">
          <h1 class="text-light"><a href="../index.php"><span>Seconde Main 224</span></a></h1>
        </div>

        <nav class="nav-menu d-none d-lg-block">
          <ul>

            <li><a href="../index.php">Acceuil</a></li>
            <li class="<?= $titre == 'Revendre'? 'active': '' ?>" ><a href="revendre.php">Revendre</a></li>
            <li class="<?= $titre == 'Qui sommes-nous'? 'active': '' ?>" ><a href="nous.php">Qui sommes-nous</a></li>
            <li class="<?= $titre == 'Contact'? 'active': '' ?>" ><a href="contact.php">Contact</a></li>

            <li class="get-started"><a href="profile.php"><?= $connexion ?></a></li>
          </ul>
        </nav><!-- .nav-menu -->
      </div><!-- End Header Container -->
    </div>
  </header><!-- End Header -->

