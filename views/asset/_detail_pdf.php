<!DOCTYPE html>
<html>
<head>
    <title>DATA DETAIL ASSET</title>
    <style>
        body{
          font-size:8pt;
        }

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
          border-spacing:1px;
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
        <h2 style="text-align:center;">DETAIL ASSET</h2>
        <hr>
        <table>
        <tr>
                <th style="width:24%"></th>
                <th style="width:13%"><?= $dates[3] ?></th>
                <th style="width:13%"><?= $dates[1] ?></th>
                <th style="width:13%"><?= $dates[1] ?></th>
                <th style="width:13%"><?= $dates[3] ?></th>
                <th style="width:24%;"></th>
        </tr>
        <tr>
                <td>Kas Bank *)</td>
                <td class="right"><?= number_format($assetat->KAS_BANK,2) ?></td>
                <td class="right"><?= number_format($asset->KAS_BANK,2) ?></td>
                <td class="right"><?= number_format($asset->HUTANG,2) ?></td>
                <td class="right"><?= number_format($assetat->HUTANG,2) ?></td>
                <td class="right">Hutang *)</td>
        </tr>
        <tr>
                <td>Transaksi Berjalan *)</td>
                <td class="right"><?= number_format($assetat->TRAN_JALAN,2) ?></td>
                <td class="right"><?= number_format($asset->TRAN_JALAN,2) ?></td>
                <td class="right"><?= number_format($asset->HUT_LANCAR,2) ?></td>
                <td class="right"><?= number_format($assetat->HUT_LAIN,2) ?></td>
                <td class="right">Hutang Lancar *)</td>
        </tr>
        <tr>
                <td>Investasi Lain *)</td>
                <td class="right"><?= number_format($assetat->INV_LAIN,2) ?></td>
                <td class="right"><?= number_format($asset->INV_LAIN,2) ?></td>
                <td class="right"><?= number_format($asset->MODAL,2) ?></td>
                <td class="right"><?= number_format($assetat->MODAL,2) ?></td>
                <td class="right">Modal *)</td>
        </tr>
        <tr>
                <td>Stok Saham *)</td>
                <td class="right"><?= number_format($assetat->STOK_SAHAM,2) ?></td>
                <td class="right"><?= number_format($asset->STOK_SAHAM,2) ?></td>
                <td class="right"><?= number_format($asset->CAD_LABA,2) ?></td>
                <td class="right"><?= number_format($assetat->CAD_LABA,2) ?></td>
                <td class="right">Cadangan Laba *)</td>
        </tr>
        <tr>
                <td></td>
                <td class="right"></td>
                <td class="right"></td>
                <td class="right"><?= number_format($asset->LABA_JALAN,2) ?></td>
                <td class="right"><?= number_format($assetat->LABA_JALAN,2) ?></td>
                <td class="right">Laba Berjalan *)</td>
        </tr>
        <?php
        $aktiva = $asset->KAS_BANK + $asset->TRAN_JALAN + $asset->INV_LAIN + $asset->STOK_SAHAM;
        $aktivaat = $assetat->KAS_BANK + $assetat->TRAN_JALAN + $assetat->INV_LAIN + $assetat->STOK_SAHAM;
        $passiva = $asset->HUTANG + $asset->HUT_LANCAR + $asset->MODAL + $asset->CAD_LABA + $asset->LABA_JALAN;
        $passivaat = $assetat->HUTANG + $assetat->HUT_LAIN + $assetat->MODAL + $assetat->CAD_LABA + $asset->LABA_JALAN;
        ?>
        <tr>
                <td>Aktiva *)</td>
                <td class="right"><?= number_format($aktivaat,2) ?></td>
                <td class="right"><?= number_format($aktiva,2) ?></td>
                <td class="right"><?= number_format($passiva,2) ?></td>
                <td class="right"><?= number_format($passivaat,2) ?></td>
                <td class="right">Passiva *)</td>
        </tr>
        </table>
        <br>
        <table style="width:50%;">
        <tr>
                <th></th>
                <th>Unit</th>
                <th>Nav</th>
        </tr>
        <tr>
                <td><?= $dates[3] ?></td>
                <td class="right"><?= number_format($assetat->UNITAT,2) ?></td>
                <td class="right"><?= number_format($assetat->NAVAT,2) ?></td>
        </tr>
        <tr>
                <td><?= $dates[1] ?></th>
                <td class="right"><?= number_format($asset->UNIT,2) ?></td>
                <td class="right"><?= number_format($asset->NAV,2) ?></td>
        </tr>
        <tr>
                <td>Pertumbuhan (%)</td>
                <td class="right"></td>
                <td class="right"><?= number_format($asset->TUMBUH,2) ?></td>
        </tr>
        </table>
        <br>
        <table>
        <tr>
                <th>Indikator</th>
                <th>Nav Awal</th>
                <th>Nav</th>
                <th>Tumbuh (%)</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $row->NAMA ?></td>
                <td style="width:13%" class="right"><?= number_format($row->NAVAT,2) ?></td>
                <td style="width:13%" class="right"><?= number_format($row->NAV,2) ?></td>
                <td style="width:13%" class="right"><?= number_format($row->TUMBUH,2) ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
