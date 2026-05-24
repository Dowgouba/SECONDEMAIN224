<?php

include_once '../../assets/connexion/database.php';
$db = Database::connect();
$statement = $db->query('SELECT * FROM s_article WHERE code_article = "'. $_POST['id']. '"');

$item = $statement->fetch();

$article[0] = $item['libelle'];
$article[1] = $item['prix'];
$article[2] = $item['categorie'];
$article[3] = $_POST['id'];

echo json_encode($article);
?>