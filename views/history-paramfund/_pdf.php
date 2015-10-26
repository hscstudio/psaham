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
        }
        ?>
        </table>
      <?php
      }
      ?>
    </div>
</body>
</html>
