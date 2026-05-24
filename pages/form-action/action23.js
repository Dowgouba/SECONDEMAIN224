$(document).ready(function(){
  vendu()
  oui_vendu()

  action_modif();
  valider_modif();
});
   
  //function 

function vendu(){
  $(document).on('click', '#vendu', function(){
    $.ajax({
      url: 'form-action/vendu.php',
      method: 'POST',
      success:function(data)
      {
        $('#action_card').html(data)
      }
    });
  })
}

function oui_vendu(){
  $(document).on('click', '#oui_vendu', function(){
    var id = $('#article').val()
    $.ajax({
      url: 'form-action/oui_vendu.php',
      method: 'POST',
      data: {id:id},
      success:function(data)
      {
        if(data == 'good'){
          $('#action_card').html('<div class="alert alert-success">Féliciations pour avoir vendu cet article !</div>')
        }
      }
    });
  })
}


function recup_info(){
  var id = $('#article').val()
  $.ajax({
    url: 'form-action/recup_info.php',
    method: 'POST',
    data: {id:id},
    success:function(data)
    {
      data = $.parseJSON(data);
      $('#libelle').val(data[0]);
      $('#prix').val(data[1]);
      $('#categorie').val(data[2]);
      $('#id').val(data[3])
      
    }
  });
}
function action_modif(){ // Clic sur le bouton modifier
 
  $(document).on('click','#modifier',function(){

    var id = $('#article').val()
    $.ajax({
      url: 'form-action/modifier.php',
      method: 'POST',
      data: {id:id},
      success:function(data)
      {
        $('#action_card').html(data)
        recup_info()
      }
    });
  })

}
  
function valider_modif(){
  $(document).on('click', '#btn_valider', function(){
    var form = $('#form_modif_article')[0];
    formdata = new FormData(form);
    var libelle     = $('#libelle').val()
    var prix        = $('#prix').val()
    var categorie   = $('#categorie').val()
    var description = $('#description').val()
    if(libelle == '' || prix == '' || categorie == '' || description == ''){
        $('#erreur_msg').html('<div class="alert alert-danger">Les champs avec * sont obligatoires</div>')
      }else{
        $('#erreur_msg').html('')
        $.ajax({
          
          type: 'POST',
          url : 'form-action/valider_modif.php',
          data: formdata,
          contentType: false,
          processData: false,

        success: function(data) { 
          $('#action_card').html(data)
        }
      });
    }
  })
}

    