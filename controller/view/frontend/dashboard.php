<?php ob_start();?>

      <!-- Icon Cards-->
         <!-- Area Chart Example-->
         <div class="card mb-3">
            <div class="card-header">
              <i class="fas fa-chart-area"></i>
             Mois en cours</div>
            <div class="card-body">
              <canvas id="myAreaChart" width="100%" height="30"></canvas>
            
      <div class="row">
            
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>

                  </div>
                  <div class="mr-5"><?= $RecetteMonth['amount']?>€ de recette</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                  </div>
                  <div class="mr-5"><?= $DepenseMonth['amount']?>€ de despenses</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
        
          <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                  </div>
                  <div class="mr-5">Balance : <?=  $RecetteMonth['amount'] - $DepenseMonth['amount']?>€</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="#">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
          </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
       

        
              </div>
            </div>
          </div>

        </div>

<?php
$content = ob_get_clean();
require 'template.php';?>
