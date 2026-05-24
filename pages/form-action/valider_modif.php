<?php


include_once '../../assets/connexion/database.php';
$db = Database::connect();

$statement = ''; 
if(empty($_FILES['img']['name'])){

    $statement = $db->query('UPDATE s_article SET libelle = "'. $_POST['libelle']. '", description = "'. $_POST['description'].'", categorie = "'. $_POST['categorie'].'", prix = "'.$_POST['prix'] .'" WHERE code_article = "'. $_POST['id']. '"');
}
else{
    $img = $_FILES['img'];
    $extention = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    $nom_image = date('dmyhis').'.'.$extention;

    if(file_exists("../../assets/img/article/".$nom_image)){
        echo '<div class="alert alert-danger">L\'image de votre article porte le même nom que celle d\'un autre déjà publiée. Veuillez renommer votre photo avant de continuer</div>
        <p class="text-right"><a class="btn" href="revendre.php">◄ retour</a> <a href="revendre.php">reprendre</a></p>';
    }else{
        if($img['size'] > 5000000){
            echo '<div class="alert alert-danger">La taille de l\'image ne doit pas dépasser 5 Mo</div>
                    <p class="text-right"><a href="revendre.php">reprendre</a></p>';
            die();
        }
        if($extention == 'png' || $extention == 'jpeg' || $extention == 'jpg' || $extention == 'gif'){
            move_uploaded_file($img['tmp_name'], "../../assets/img/article/".$nom_image);
            $statement = $db->query('UPDATE s_article SET libelle = "'. $_POST['libelle']. '", description = "'. $_POST['description'].'", categorie = "'. $_POST['categorie'].'", prix = "'.$_POST['prix'] .'", photo = "'. $nom_image . '" WHERE code_article = "'. $_POST['id']. '"');   
            
        }else{
            echo '<div class="alert alert-danger">Les extensions autorisées sont: .png, .jpeg, .jpg, .gif</div>
                <p class="text-right"><a href="revendre.php">reprendre</a></p>';
        }
    }
    
    
}
Database::disconnect();

if($statement){
    echo '<div class="alert alert-success">Félicitations ! Modifications effectuée avec success</div>';
}
?>