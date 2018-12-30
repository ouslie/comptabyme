<?php ob_start();?>
<!-- DataTables Example -->
<link rel="stylesheet" href="public/css/style.css" type="text/css" media="screen">
<link rel="stylesheet" href="public/css/responsive.css" type="text/css" media="screen">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="public/css/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" media="screen">

<div class="card mb-3">
  <div class="card-header">

         <button type="button" name="age" id="age" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-warning">Add</button>

    <div id="add_data_Modal" class="modal fade">
     <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter une base</h4>
       </div>
       <div class="modal-body">
        <form method="post" id="insert_form">
         <label>Nom de la base</label>
         <input type="text" name="name" id="name" class="form-control" />
         <br />
         <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success" />
        </form>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
       </div>
      </div>
     </div>
    </div>


    <script>
    $(document).ready(function(){
     $('#insert_form').on("submit", function(event){
      event.preventDefault();
      if($('#name').val() == "")
      {
       alert("Le nom de la base est obligatoire");
      }
      else
    {
     $.ajax({
      url:"index.php?action=addbase",
      method:"POST",
      data:$('#insert_form').serialize(),
      beforeSend:function(){
       $('#insert').val("Inserting");
      },
      success:function(data){
       $('#insert_form')[0].reset();
       $('#add_data_Modal').modal('hide');
       $('#employee_table').html(data);
      }
     });
    }
   });
  });
   </script>
  </div>
</div>
<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
<?php
$content = ob_get_clean();
require 'template.php';
?>
