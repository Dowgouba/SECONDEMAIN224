<?php
session_start();
require_once '../assets/connexion/database.php';

if (!isset($_SESSION['code_vendeur'])) {
    die('NO_SESSION');
}

if (!isset($_POST['id'])) {
    die('NO_ID');
}

$db = Database::connect();

$id = (int) $_POST['id'];
$vendeur = $_SESSION['code_vendeur'];

$sql = "UPDATE s_article SET date_fin = NOW() 
        WHERE code_article = ? AND vendeur = ?";

$stmt = $db->prepare($sql);
$stmt->execute([$id, $vendeur]);

echo 'OK';
