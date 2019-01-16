<?php ob_start();?>

<div class="card mb-3">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Contrats</th>
                    <th>Début contrat</th>
                    <th>Fin contrat</th>
                    <th>Nom</th>
                    <th>Salaire</th>
                    <th>Date paiement</th>
                    <th>Paiement ok</th>
                    <th>Montant</th>

                </tr>
            </thead>
            <tbody>
                <?php
       
        foreach ($contrats as $row)
        {
          
          echo '<tr rowspan="2"><td>' . $row['id'] . '</td>';
          echo '<td>' . $row['debcontrat'] . '</td>';
          echo '<td>' . $row['endcontrat'] . '</td>';
          echo '<td>' . $row['name'] . '</td>';
          echo '<td>' . $row['salaire'] . '</td>';
          echo '<td>' . $row['paymentdate'] . '</td>';
          echo '<td>' . $row['paymentisok'] . '</td>';
          echo '<td>' . $row['amount'] . '€</td>';

    

          echo '<tr>';
        }

        ?>


            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require 'template.php';?>