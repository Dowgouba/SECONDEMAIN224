<?php

session_start();
unset($_SESSION['code_vendeur']);
header('Location: ../index.php');
?>