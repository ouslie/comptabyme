<?php ob_start();?>

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">

  <div class="card-body">
<form>
<div class="form-group">
<label for="input-select">Example Select</label>
<select class="form-control" id="input-select">
<option>Choose Example</option>
</select>
</div>
</form>
</div>



    </div>

  </div>
<?php
$content = ob_get_clean();
require_once('controller/view/frontend/template.php');?>