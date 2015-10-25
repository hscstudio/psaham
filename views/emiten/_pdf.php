<!DOCTYPE html>
<html>
<head>
    <title>DATA EMITEN</title>
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
        <h2>DATA EMITEN</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jml Lot</th>
                <th>Jml Saham</th>
                <th>Saldo</th>
                <th>Harga</th>
                <th>Saldo R1</th>
                <th>Jml Lot B</th>
                <th>Saldo B</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->KODE ?></td>
                <td><?= $row->NAMA ?></td>
                <td class="right"><?= number_format($row->JMLLOT,2) ?></td>
                <td class="right"><?= number_format($row->JMLSAHAM,2) ?></td>
                <td class="right"><?= number_format($row->SALDO,2) ?></td>
                <td class="right"><?= number_format($row->HARGA,2) ?></td>
                <td class="right"><?= number_format($row->SALDOR1,2) ?></td>
                <td class="right"><?= number_format($row->JMLLOTB,2) ?></td>
                <td class="right"><?= number_format($row->SALDOB,2) ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
