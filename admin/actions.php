<?php
session_start();
include_once '../assets/connexion/database.php';

// if (!isset($_SESSION['admin'])) {
//     exit('Accès refusé');
// }

$db = Database::connect();

$type   = $_GET['type']   ?? null;
$id     = $_GET['id']     ?? null;
$action = $_GET['action'] ?? null;

if ($type === 'article' && $action === 'delete') {

    $stmt = $db->prepare("SELECT photo FROM s_article WHERE code_article = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if ($article && !empty($article['photo'])) {
        $imagePath = realpath(__DIR__ . '/../assets/img/article/' . $article['photo']);
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $delete = $db->prepare("DELETE FROM s_article WHERE code_article = ?");
    $delete->execute([$id]);

    header('Location: articles.php?success=1');
    exit;
}
