<!DOCTYPE html>
<html>
<head>
    <title>HISTORY EMITEN</title>
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
        <h2>History Emiten</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Jml Lot</th>
                <th>Jml Saham</th>
                <th>Range Beli</th>
                <th>Range</th>
                <th>Saldo</th>
                <th>Harga *)</th>
                <th>Tgl Akhir</th>
                <th>Saldo **)</th>
                <th>Laba(+)/Rugi(-)</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
            $detemiten = \app\models\Detemiten::find()->where(['EMITEN_KODE'=>$row->KODE])->orderBy('TGL DESC')->one();
            if(substr($detemiten->TGLAKHIR,0,4)=='0000'){
              $tgl = '-';
            }
            else
              $tgl = date('d-m-Y',strtotime($detemiten->TGLAKHIR));
            ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->KODE ?></td>
                <td class="right"><?= number_format($row->JMLLOT,2) ?></td>
                <td class="right"><?= number_format($row->JMLSAHAM,2) ?></td>
                <td class="right"><?= number_format(0,2) ?></td>
                <td class="right"><?= number_format(0,2) ?></td>
                <td class="right"><?= number_format($row->SALDO,2) ?></td>
                <td class="right"><?= number_format($row->HARGA,2) ?></td>
                <td class="right"><?= $tgl ?></td>
                <td class="right"><?= number_format($row->SALDOR1,2) ?></td>
                <td class="right"><?= number_format(0,2) ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
