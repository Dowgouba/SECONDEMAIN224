<?php

include_once '../../assets/connexion/database.php';
$db = Database::connect();
$statement = $db->query('UPDATE `s_article` SET `date_fin` = "'. date('d/m/Y') .'" WHERE `s_article`.`code_article` = "'. $_POST['id']. '"');

if($statement){
    echo 'good';
}

?>