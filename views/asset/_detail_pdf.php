<!DOCTYPE html>
<html>
<head>
    <title>DATA ASSET</title>
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
        <h2>DATA ASSET</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Tgl</th>
                <th>Kas Bank</th>
                <th>Transaksi Jalan</th>
                <th>Investasi Lain</th>
                <th>Stok Saham</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->TGL ?></td>
                <td class="right"><?= number_format($row->KAS_BANK,2) ?></td>
                <td class="right"><?= number_format($row->TRAN_JALAN,2) ?></td>
                <td class="right"><?= number_format($row->INV_LAIN,2) ?></td>
                <td class="right"><?= number_format($row->STOK_SAHAM,2) ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
