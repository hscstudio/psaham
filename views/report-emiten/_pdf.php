<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN EMITEN</title>
    <link rel="stylesheet" type="text/css" href="<?= Yii::getAlias('@web') ?>/css/bootstrap.css">
    <style>
        .page
        {
            padding:0cm;
        }

        .table-striped tbody tr:nth-child(odd) td {
          background-color: #f9f9f9 !important;
        }

    </style>
</head>
<body>
    <div class="page">
        <h2>LAPORAN EMITEN</h2>
        <div class="text-right"><strong>Tgl <?= $reportDates[1] ?></strong></div>
        <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
        <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Jml Lot</th>
                <th>Jml Saham</th>
                <th>RangeBeli</th>
                <th>Range</th>
                <th>Saldo</th>
                <th>Harga</th>
                <th>TglAkhir</th>
                <th>Saldo **)</th>
                <th>(+) %</th>
                <th>Laba(+) / Rugi(-)</th>
        </tr>
        </thead>
        <?php
        $no = 1;
        $jmlsaham = 0;
        $saldo = 0;
        $saldo_bintang = 0;
        $laba_rugi = 0;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tbody>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->EMITEN_KODE ?></td>
                <td class="text-right"><?= number_format($row->JMLLOT,2) ?></td>
                <td class="text-right"><?= number_format($row->JMLSAHAM,2) ?></td>

                <?php
                $range_beli = (float) @($row->SALDOB / $row->JMLSAHAMB);
                $range = (float) @($row->SALDO / $row->JMLSAHAM);

                ?>
                <td class="text-right"><?= number_format($range_beli,2) ?></td>
                <td class="text-right"><?= number_format($range,2) ?></td>

                <td class="text-right"><?= number_format($row->SALDO,2) ?></td>
                <td class="text-right"><?= number_format($row->HARGA,2) ?></td>
                <td class="text-right"><?= number_format($row->TGLAKHIR,2) ?></td>
                <?php
                $saldo2 =  $row->HARGA * $row->JMLSAHAM;
                $persen = (float) @(($row->JMLSAHAM * $row->HARGA * 100) / $total_saldo) ;
                $laba_rugi = ($row->JMLSAHAM * $row->HARGA) - $row->SALDO;
                ?>
                <td class="text-right"><?= number_format($saldo2,2) ?></td>
                <td class="text-right"><?= number_format($persen,2) ?></td>
                <td class="text-right"><?= number_format($laba_rugi,2) ?></td>
        </tr>
        <?php
            $jmlsaham += $row->JMLSAHAM;
            $saldo += $row->SALDO;
            $saldo_bintang += $saldo2;
            $laba_rugis += $laba_rugi;
        }
        ?>
        <tr>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-right"><?= number_format($jmlsaham,2) ?></th>
                <th></th>
                <th></th>
                <th class="text-right"><?= number_format($saldo,2) ?></th>
                <th></th>
                <th></th>
                <th class="text-right"><?= number_format($saldo_bintang,2) ?></th>
                <th></th>
                <th class="text-right"><?= number_format($laba_rugis,2) ?></th>
        </tr>
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
                <th class="text-right"><?= number_format($total_laba_rugi,2) ?></th>
        </tr>
        </tbody>
        </table>

        <table style="width:100%">
        <thead>
        <tr>
          <th style="width:50%">
            <?php
            $tipe = (($simulates['tipe']=='true')?'Pembelian':'Penjualan') . ' Emiten '.$simulates['emitenCode'];
            ?>
            Simulasi <?= $tipe ?>
          </th>
          <th style="width:25%"></th>
          <th>
            Tanggal
          </th>
        </tr>
        <tr>
          <td>
            <table class="table table-condensed">
              <tbody>
                <tr>
                  <td>Jml Lot</td>
                  <td class="text-right"><?= number_format($simulates['jml_lot'],2) ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Jml Saham</td>
                  <td class="text-right"><?= number_format($simulates['jml_saham'],2) ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td class="text-right"><?= number_format($simulates['harga'],2) ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Komisi</td>
                  <td class="text-right"><?= number_format($simulates['komisi'],2) ?></td>
                  <td class="text-right"><?= number_format($simulates['total_komisi'],2) ?></td>
                </tr>
                <tr>
                  <td>Range</td>
                  <td class="text-right"><?= @number_format($simulates['range'],2) ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Total Harga</td>
                  <td class="text-right"><?= number_format($simulates['total_harga'],2) ?></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </td>
          <td></td>
          <td style="vertical-align:top">
            <?php
            foreach($detemitenDates as $detemitenDate){
                echo date('d-M-Y',strtotime($detemitenDate)).'<br>';
            }
            ?>
          </td>
        </tr>

        </table>
    </div>
</body>
</html>
