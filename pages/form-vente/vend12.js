$(document).ready(function(){
  article();
  mot_de_passe_oublie();
});

//function 
function article(){
  
  var success = true;
  
  $(document).on('click','#btn_article',function(){
    var libelle = $('#article_libelle').val()
    var prix = $('#prix').val()
    var currency = $('#currency').val()
    var categorie = $('#categorie').val()
    var img =  $('#image').val()
    var description = $('#description').val()

    var nom = ""
    var prenom = "" 
    var email = ""
    var tel_1 = ""
    var tel_2 = ""
    var residence = ""

    var article = ""
    var vendeur = ""
    var mpasse = ""

    if(libelle == '' || prix == '' || categorie == ''){
      $('#erreur_msg').html('<div class="alert alert-danger">Tous les champs avec * sont obligatoires</div>')
      success = false;
    }else if(img == '' ){
       $('#erreur_msg').html('<div class="alert alert-danger">S\'il vous plaît veillez choisir une image pour votre article.</div>')
      success = false;
    }else{
      $('#erreur_msg').html('');
      success = true
    }
    if(success){
      $("#cadre_btn_article").html('<button class="btn" id="btn_article" style="background: rgb(225,102,0); color: #FFFFFF" disabled>Patientez...</button>');
      $("#cadre_btn_article").prop("disabled", true);
      article = libelle + "','" + description + "','" + categorie + "','" + prix +  "','" + currency + "'"

      var form = $('#formulaire_article')[0];
      formdata = new FormData(form);
      $.ajax({
        type: 'POST',
        url: 'form-vente/form-login.php', // En cas de SESSION ouverte ou non
        data: formdata,
        contentType: false,
        processData: false,
        
        success:function(data)
        {
          $('#publication-form').html(data)
        }
      });
    }

     // fonction du click sur le bouton suivant du formulaire info
     $(document).on('click', '#btn_info_next', function(){

        nom = $('#nom').val()
        prenom = $('#prenom').val()
        email = $('#email').val()
        tel_1 = $('#tel_1').val()
        tel_2 = $('#tel_2').val()
        residence = $('#residence').val()

      var info = true
      if(nom == '' || prenom == '' || tel_1 == '' || residence == ''){
        info = false
        $('#erreur_msg').html('<div class="alert alert-danger">Les champs avec * sont obligatoires</div>')
      }else{
        $('#erreur_msg').html('');
        info = true
      }
      if(info){
        $(this).removeClass('btn') 
        $(this).html('<button class="btn" style="color: #FFFFFF" disabled>Patientez...</button>');
        $(this).prop("disabled", true);
        vendeur = nom + "','" + prenom + "','" + email + "','" + tel_1 + "','" + tel_2 + "','" + residence + "',''"
        $.ajax({
          url: 'form-vente/form-secure.php',
          method: 'POST',
          success:function(data)
          {
            $('#contact').html(data)
          }
        });
      }
    })
    // fin fonction du click sur le bouton next du formulaire info
  
    // fonction du click sur le bouton retour du formulaire secure
    $(document).on('click', '#btn_secure_back', function(){
      $.ajax({
        url: 'form-vente/form-info.php',
        method: 'POST',
        success:function(data)
        {
            $('#contact').html(data)
            $('#nom').val(nom)
            $('#prenom').val(prenom)
            $('#email').val(email)
            $('#tel_1').val(tel_1)
            $('#tel_2').val(tel_2)
            $('#residence').val(residence)
        }
      });
    })
    // fin fonction du click sur le bouton retour du formulaire sercure

    // fonction du click sur le bouton retour du formulaire secure
    $(document).on('click', '#btn_login_back', function(){
      $.ajax({
        url: 'form-vente/form-article.php',
        method: 'POST',
        success:function(data)
        {
            $('#contact').html(data)
            $('#article_libelle').val(libelle)
            $('#prix').val(prix)
            $('#currency').val(currency)
            $('#currency').val(money)
            $('#categorie').val(categorie)
            $('#image').val(img)
            $('#description').html(description)
        }
      });
    })
    // fin fonction du click sur le bouton retour du formulaire sercure
    
    // le bouton je n'ai pas de compte sur le formulaire d'identificaiton
    $(document).on('click', '#pas_de_compte', function(){
      img = $('#nom_image').val();
      $.ajax({
        url: 'form-vente/form-info.php',
        method: 'POST',
        success:function(data)
        {
          $('#contact').html(data)
        }
      });
    })
    // Fin je n'ai pas de compte

    // click sur le bouton Terminer sur le formulaire secure
    $(document).on('click', '#btn_secure_termine', function(){
      mpasse = $('#password').val()
      var confirm_mpasse = $('#confirm_mpasse').val()
      var valide = true
      if(mpasse.length < 8){
        valide = false
        $('#erreur_msg').html('<div class="alert alert-danger">Mot de passe trop court, entrez 8 caractèrs au moins</div>')
      }else if(mpasse !== confirm_mpasse){
        valide = false
        $('#erreur_msg').html('<div class="alert alert-danger">Le mot de passe saisi ne correspond pas.</div>')
        $('#mpasse').val('')
        $('#confirm_mpasse').val('')
      }
      if(valide){
        $(this).removeClass('btn') 
        $(this).html('<button class="btn" style="color: #FFFFFF" disabled>Patientez...</button>');
        $(this).prop("disabled", true);
        $.ajax({
          url: 'form-vente/ajout_article_vendeur.php',
          method: 'POST',
          data:{article:article, img:img, vendeur:vendeur, mpasse:mpasse},
          success:function(data)
          {
            if(data=='insert_2'){
              $('#publication-form').html('<div class="alert alert-success">Publication effectuée avec succès</div><p class="text-right"><a class="btn" href="revendre.php">◄ retour</a> <a href="profile.php">Mes articles</a></p>')
            }
          }
        });
      }
    })
    // fin Terminer

    // click sur le bouton Connexion sur le formulaire login
    $(document).on('click', '#btn_login_termine', function(){
      img = $('#nom_image').val()
      var login = $('#login').val()
      mpasse = $('#password').val()
      var valide = true
      if(login == '' || mpasse.length < 8){
        valide = false
        $('#erreur_msg').html('<div class="alert alert-danger">Identifiants incorrectes</div>')
      }else{
        valide = true
        $('#erreur_msg').html()
      }
      if(valide){
        $(this).removeClass('btn') 
        $(this).html('<span style="color: #000000; background : #FFFFFF" disabled>Patientez...</span>');
        $(this).prop("disabled", true);
        $.ajax({
          url: 'form-vente/ajout_article_vendeur.php',
          method: 'POST',
          data:{article:article, img:img, login:login, mpasse:mpasse},
          success:function(data)
          {
            if(data=='insert'){
              $('#publication-form').html('<div class="alert alert-success">Publication effectuée avec succès</div><p class="text-right"><a class="btn" href="revendre.php">◄ retour</a> <a href="profile.php">Mes articles</a></p>')
            }
            if(data == 'non_trouve'){

              $('#btn_login_termine').html('<a id="btn_login_termine" class="btn" style="background: rgb(225,102,0); color: #FFFFFF">Connexion ˯</a>')
              $('#erreur_msg').html('<div class="alert alert-danger">Identifiants incorrectes</div>')
            }else{
              $('#erreur_msg').html()
            }
          }
        });
      }
    })
    // fin connexion

  })

} // FIN Fonction article

function mot_de_passe_oublie(){
  
  $(document).on('click','#pw_forgot',function(){
    $('#pw_forgot_content').html("Désolé que vous ayez oublié votre mot de passe, veuillez contacter <a href='tel:00224629309476'>l'admin</a>")
  })
}
