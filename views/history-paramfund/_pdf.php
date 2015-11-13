<!DOCTYPE html>
<html>
<head>
    <title>DATA HISTORY PARAMETER FUNDAMENTAL</title>
    <style>
        .page
        {
            padding:0cm;
        }
        table
        {
            border-spacing:1px;
            /*border-collapse: collapse;*/
            width:100%;
            background-color:#ddd;
        }

        table td, table th
        {

        }

		    table th
        {
            background-color:#ddd;
        }

        table tr:nth-child(even){
            background-color:#fff;
        }

        table tr:nth-child(odd){
            background-color:#efefef;
        }

        .right{
          text-align:right;
        }
    </style>
</head>
<body>
    <div class="page">
      <h2>DATA HISTORY PARAMETER FUNDAMENTAL</h2>
      <?php
      $no = 1;
      foreach ($dataProviders as $emitenCode => $dataProvider) {
      ?>
        <h3>Emiten Kode : <?= $emitenCode ?></h3>
        <table>
        <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Triwulan</th>
                <th>Share</th>
                <th>BV</th>
                <th>% BV</th>
                <th>EPS</th>
                <th>% EPS</th>
                <th>PBV</th>
                <th>PER</th>
                <th>DER</th>
                <th>Harga</th>
        </tr>
        <?php
        $no = 1;
        $p_bv = 0;
        $p_eps= 0;
        foreach($dataProvider->getModels() as $row){
          ?>
          <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->TAHUN ?></td>
                  <td><?= $row->TRIWULAN ?></td>
                  <td class="right"><?= number_format($row->SHARE,2) ?></td>
                  <td class="right"><?= number_format($row->BV,2) ?></td>
                  <td class="right"><?= number_format($row->P_BV,2) ?></td>
                  <td class="right"><?= number_format($row->EPS,2) ?></td>
                  <td class="right"><?= number_format($row->P_EPS,2) ?></td>
                  <td class="right"><?= number_format($row->PBV,2) ?></td>
                  <td class="right"><?= number_format($row->PER,2) ?></td>
                  <td class="right"><?= number_format($row->DER,2) ?></td>
                  <td class="right"><?= number_format($row->HARGA,2) ?></td>
          </tr>
          <?php
          $p_bv += $row->P_BV;
          $p_eps+= $row->P_EPS;
        }
        $average_p_bv = @($p_bv / ($no - 1));
        $average_p_eps = @($p_eps / ($no - 1));
        ?>
        <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="right"></td>
                <td class="right">Rata-rata</td>
                <td class="right"><?= $average_p_bv ?></td>
                <td class="right"></td>
                <td class="right"><?= $average_p_eps ?></td>
                <td class="right"></td>
                <td class="right"></td>
                <td class="right"></td>
                <td class="right"></td>
        </tr>
        <?php
        ?>
        </table>
      <?php
      }
      ?>
    </div>
</body>
</html>
