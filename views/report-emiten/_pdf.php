<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN EMITEN</title>
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
        <h2>LAPORAN EMITEN</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Jml Lot</th>
                <th>Jml Saham</th>
                <th>Range Beli</th>
                <th>Range</th>
                <th>Saldo</th>
                <th>Harga</th>
                <th>Tgl Akhir</th>
                <th>Saldo **)</th>
                <th>(+) %</th>
                <th>Laba(+) / Rugi(-)</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->EMITEN_KODE ?></td>
                <td class="right"><?= number_format($row->JMLLOT,2) ?></td>
                <td class="right"><?= number_format($row->JMLSAHAM,2) ?></td>

                <?php
                $range_beli = (float) @($row->SALDOB / $row->JMLSAHAMB);
                $range = (float) @($row->SALDO / $row->JMLSAHAM);

                ?>
                <td class="right"><?= number_format($range_beli,2) ?></td>
                <td class="right"><?= number_format($range,2) ?></td>

                <td class="right"><?= number_format($row->SALDO,2) ?></td>
                <td class="right"><?= number_format($row->HARGA,2) ?></td>
                <td class="right"><?= number_format($row->TGLAKHIR,2) ?></td>
                <?php
                $saldo2 =  $row->HARGA * $row->JMLSAHAM;
                $persen = (float) @(($row->JMLSAHAM * $row->HARGA * 100) / $total_saldo) ;
                $laba_rugi = ($row->JMLSAHAM * $row->HARGA) - $row->SALDO;
                ?>
                <td class="right"><?= number_format($saldo2,2) ?></td>
                <td class="right"><?= number_format($persen,2) ?></td>
                <td class="right"><?= number_format($laba_rugi,2) ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan=2>Total Laba/Rugi</th>
                <th><?= $total_laba_rugi ?></th>
        </tr>
        </table>
    </div>
</body>
</html>
