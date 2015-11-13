<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Pembelian</title>
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
        <h2>TRANSAKSI PEMBELIAN</h2>
        <ul>
          <li>Tanggal Transaksi Terakhir : <?= $latestDate[1] ?></li>
          <li>Tanggal : <?= $dates[1] ?></li>
        </ul>
        <table>
        <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Emiten</th>
                <th>Securitas</th>
                <th>Jml Lot</th>
                <th>Jml Saham</th>
                <th>Harga</th>
                <th>Komisi</th>
                <th>Total Beli</th>
        </tr>
        <?php
        $no = 1;
        $jmllot = 0;
        $jmlsaham = 0;
        $harga = 0;
        $kom_beli = 0;
        $total_beli = 0;
        foreach($dataProvider->getModels() as $row){
          $jmllot += $row->JMLLOT;
          $jmlsaham += $row->JMLSAHAM;
          $harga += $row->HARGA;
          $kom_beli += $row->KOM_BELI;
          $total_beli += $row->TOTAL_BELI;
          ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->TGL ?></td>
                <td><?= $row->NOMOR ?></td>
                <td><?= $row->EMITEN_KODE ?></td>
                <td><?= $row->SECURITAS_KODE ?></td>
                <td class="right"><?= number_format($row->JMLLOT,2) ?></td>
                <td class="right"><?= number_format($row->JMLSAHAM,2) ?></td>
                <td class="right"><?= number_format($row->HARGA,2) ?></td>
                <td class="right"><?= number_format($row->KOM_BELI,2) ?></td>
                <td class="right"><?= number_format($row->TOTAL_BELI,2) ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
                <td colspan="5" class="text-center">Total</td>
                <td class="right"><?= number_format($jmllot,2) ?></td>
                <td class="right"><?= number_format($jmlsaham,2) ?></td>
                <td class="right"><?= number_format($harga,2) ?></td>
                <td class="right"><?= number_format($kom_beli,2) ?></td>
                <td class="right"><?= number_format($total_beli,2) ?></td>
        </tr>
        </table>
    </div>
</body>
</html>
