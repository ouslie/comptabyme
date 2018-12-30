<?php ob_start();?>
<!-- DataTables Example -->
<div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-table"></i>
             Data Table Example</div>


            <div class="card-body">
              <div class="table-responsive">


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="public/js/JSON-to-Table.min.1.0.0.js"></script>

<div id="json-table-2" class="margin-bottom"></div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#json-table-2').createTable(<?php echo $toto ?>, {});
    });
</script>
<?php print_r($toto);?>
</body>


              </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
<?php

$content = ob_get_clean();
require 'template.php';?>
