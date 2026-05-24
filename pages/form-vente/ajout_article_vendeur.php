<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
} 
include_once '../../assets/connexion/database.php'; 

$article = $_POST['article'];

$mpasse = $_POST['mpasse'];
$img = $_POST['img'];

// Si l'utilisateur n'a pas un compte
if(empty($_POST['login'])){
  
  $vendeur = $_POST['vendeur'];
  
  // Génération automatique du mot du code pour le nouveau vendeur
  $code = rand(0, 99) . date('ss') . rand(0, 99);

  $requette_article = "'" . $article . ",'" . $code . "','". $img . "','" . date('d/m/Y') ."',''" ;
  $requette_vendeur = "'" . $code ."', '". $vendeur .",'". $mpasse ."'";
  $db = Database::connect();
  $statement = $db->query("INSERT INTO `s_vendeur` (`code_vendeur`, `Nom`, `Prenom`, `email`, `telephone_1`, `telephone_2`, `lieu_residence`, `photo`, `mpasse`) VALUES (". $requette_vendeur.") ");
  
  $ab = Database::connect();
  $statement2 = $ab->query("INSERT INTO `s_article` (`code_article`, `libelle`, `description`, `categorie`, `prix`,  `currency`, `vendeur`, `photo`, `date_debut`, `date_fin`) VALUES (NULL, ". $requette_article .") ");

  if($statement && $statement2){
    $_SESSION['code_vendeur'] = $code;
    echo 'insert_2';
  }  
}else{ // Si l'utilisateur a un compte

  $login = $_POST['login'];
  $db = Database::connect();
  $statement = $db->query('SELECT code_vendeur, email, telephone_1, telephone_2, mpasse FROM s_vendeur WHERE mpasse = "'. $mpasse .'" AND (email = "'. $login .'" OR telephone_1 = "'. $login . '" OR telephone_2 = "'. $login . '")');
  $item = $statement->fetch();

  if($item){
    
    $code = $item['code_vendeur'];
    $requette_article = "'" . $article . ",'" . $code . "','". $img . "','" . date('d/m/Y') ."',''" ;
    $db = Database::connect();
    $statement = $db->query("INSERT INTO `s_article` (`code_article`, `libelle`, `description`, `categorie`, `prix`,  `currency`, `vendeur`, `photo`, `date_debut`, `date_fin`) VALUES (NULL, ". $requette_article .") ");
    if($statement){
      $_SESSION['code_vendeur'] = $code;
      echo 'insert';
    }
  }else{
    echo 'non_trouve';
  }

}

?>