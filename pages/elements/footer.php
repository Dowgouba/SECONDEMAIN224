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



<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="../assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="../assets/vendor/counterup/counterup.min.js"></script>
<script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="../assets/vendor/venobox/venobox.min.js"></script>
<script src="../assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="../assets/vendor/aos/aos.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script src="form-vente/vend12.js"></script>


</html>

