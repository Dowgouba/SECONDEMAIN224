<?php
session_start();
include_once '../assets/connexion/database.php';

// if (!isset($_SESSION['admin'])) {
//     header('Location: login.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4">
  <span class="navbar-brand fw-bold">ADMIN • Marketplace</span>
  <a href="logout.php" class="btn btn-danger btn-sm">Déconnexion</a>
</nav>

<div class="container-fluid">
<div class="row">
