<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
} 
include_once '../../assets/connexion/database.php'; 

$article = $_POST['article'];
$img = basename($_POST['img']);


$code = $_SESSION['code_vendeur'];
$requette_article = "'" . $article . ",'" . $code . "','". $img . "','" . date('d/m/Y') ."',''" ;
$db = Database::connect();
$statement = $db->query("INSERT INTO `s_article` (`code_article`, `libelle`, `description`, `categorie`, `prix`, `vendeur`, `photo`, `date_debut`, `date_fin`) VALUES (NULL, ". $requette_article .") ");
if($statement){
  echo 'insert_session';
}else{
  echo 'not_insert';
}


?>