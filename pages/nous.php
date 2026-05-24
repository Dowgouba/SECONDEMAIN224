<?php
$titre = "Qui sommes-nous";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title><?= $titre ?> | Seconde Main 224</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Icons -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

<!-- AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:'Inter',sans-serif}
body{background:#f8f9fa;color:#212529;line-height:1.6}

/* HERO */
#hero{
  min-height:75vh;
  background:linear-gradient(rgba(0,0,0,.55),rgba(0,0,0,.55)),
  url('https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f') center/cover;
  display:flex;
  align-items:center;
  text-align:center;
  color:#fff;
}
#hero h1{
  font-size:44px;
  font-weight:800;
  margin-bottom:10px;
}
#hero p{
  font-size:18px;
  opacity:.95;
}
.btn-get-started{
  display:inline-block;
  margin-top:30px;
  padding:14px 32px;
  background:#ff6b35;
  color:#fff;
  border-radius:30px;
  text-decoration:none;
  font-weight:600;
  transition:.3s;
}
.btn-get-started:hover{
  background:#e85a28;
}

/* SECTIONS */
section{padding:80px 0}
.section-bg{background:#fff}
.container{width:90%;max-width:1100px;margin:auto}

/* ABOUT */
.about h3{
  font-size:26px;
  font-weight:700;
  margin-bottom:15px;
}
.about p{
  color:#555;
}
.about-list{
  margin-top:10px;
}
.about-list li{
  list-style:none;
  margin-bottom:14px;
  font-size:15px;
  display:flex;
  align-items:flex-start;
}
.about-list i{
  color:#ff6b35;
  font-size:18px;
  margin-right:8px;
}

/* ICON BOX */
.features{
  margin-top:50px;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:25px;
}
.icon-box{
  background:#fff;
  padding:35px 25px;
  border-radius:18px;
  box-shadow:0 15px 40px rgba(0,0,0,0.07);
  transition:.3s;
}
.icon-box:hover{
  transform:translateY(-6px);
}
.icon-box .icon{
  font-size:42px;
  color:#ff6b35;
  margin-bottom:12px;
}
.icon-box h4{
  font-size:18px;
  margin-bottom:8px;
}
.icon-box p{
  font-size:14px;
  color:#6c757d;
}

/* CTA */
.cta{
  background:linear-gradient(135deg,#ff6b35,#ff8c5a);
  color:#fff;
  text-align:center;
}
.cta h3{
  font-size:30px;
  font-weight:800;
}
.cta p{
  margin-top:10px;
  font-size:16px;
  opacity:.95;
}
</style>
</head>

<body>

<?php include_once 'elements/header.php'; ?>

<!-- HERO -->
<section id="hero">
  <div class="container" data-aos="fade-up">
    <h1>Acheter malin. Vendre utile.</h1>
    <p>La plateforme qui donne une seconde vie à vos biens</p>
    <a href="#about" class="btn-get-started">Découvrir notre vision</a>
  </div>
</section>

<!-- ABOUT -->
<section id="about" class="about section-bg">
  <div class="container">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:40px;">
      <div data-aos="fade-right">
        <h3>Pourquoi choisir la seconde main ?</h3>
        <p>
          Acheter ou vendre d’occasion est aujourd’hui un choix intelligent,
          économique et responsable pour vous et pour l’environnement.
        </p>
      </div>
      <div data-aos="fade-left">
        <ul class="about-list">
          <li><i class="ri-check-double-line"></i> Dépenser moins pour des produits de qualité</li>
          <li><i class="ri-check-double-line"></i> Générer des revenus avec ses anciens biens</li>
          <li><i class="ri-check-double-line"></i> Réduire le gaspillage et préserver la planète</li>
        </ul>
      </div>
    </div>

    <div class="features">
      <div class="icon-box" data-aos="zoom-in">
        <div class="icon"><i class="bx bx-wallet"></i></div>
        <h4>Économiser</h4>
        <p>Accédez à des produits fiables à prix réduits</p>
      </div>
      <div class="icon-box" data-aos="zoom-in" data-aos-delay="150">
        <div class="icon"><i class="bx bx-line-chart"></i></div>
        <h4>Gagner</h4>
        <p>Transformez vos anciens biens en argent</p>
      </div>
      <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
        <div class="icon"><i class="bx bx-leaf"></i></div>
        <h4>Préserver</h4>
        <p>Agissez pour une consommation responsable</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="container" data-aos="fade-up">
    <h3>Consommer autrement, c’est possible</h3>
    <p>Seconde Main 224 – La plateforme des plus malins</p>
  </div>
</section>

<!-- ======= Footer ======= -->
<footer class="mt-5 pt-4 pb-5" style="background:#1b1b1b; color:#fff;">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-4">
        <h6>Seconde Main 224</h6>
        <p class="small-muted">Siège Social: Carrière Cité, Matam, Conakry</p>
      </div>
      <div class="col-md-4">
        <h6>Contact</h6>
        <p class="small-muted mb-1"><strong>Téléphone :</strong> +224 623 02 75 39</p>
        <p class="small-muted mb-1"><strong>Email:</strong> <a href="mailto:secondemain880@gmail.com" style="color:#fff; text-decoration:none;">secondemain880@gmail.com</a></p>
      </div>
      <div class="col-md-4">
        <h6>Newsletter</h6>
        <form method="post" class="d-flex gap-2">
          <input name="newsletter" class="form-control form-control-sm" placeholder="Votre email" required>
          <button class="btn btn-sm" style="background:#ff6b35; color:#fff;">OK</button>
        </form>
      </div>
    </div>
    <div class="text-center mt-4 border-top pt-3" style="border-color:rgba(255,255,255,0.1) !important;">
      <small class="small-muted">&copy; <?= date('Y') ?> Seconde Main 224</small>
    </div>
  </div>
</footer>
<!-- Bottom nav -->
<nav class="bottom-nav">
  <a href="../index.php"><i class="bx bx-home"></i><span>Accueil</span></a>
  <a href="revendre.php"><i class="bx bx-plus-circle"></i><span>Vendre</span></a>
  <a href="profile.php" class="active"><i class="bx bx-user"></i><span>Profil</span></a>
</nav>

<style>
.bottom-nav {
  position: fixed;
  bottom: 12px;
  left: 50%;
  transform: translateX(-50%);
  width: calc(100% - 32px);
  max-width: 720px;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
  z-index: 1200;
  display: flex;
  justify-content: space-around;
  padding: 0.45rem 8px;
}
.bottom-nav a {
  color: #6c757d;
  font-size: 0.85rem;
  text-align: center;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
  padding: 6px 10px;
  transition: color 0.3s;
}
.bottom-nav a.active,
.bottom-nav a:hover {
  color: #ff6b35;
}
</style>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({duration:900, once:true});
</script>

</body>
</html>
