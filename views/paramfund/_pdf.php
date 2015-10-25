<!DOCTYPE html>
<html>
<head>
    <title>DATA PARAMETER FUNDAMENTAL</title>
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
        <h2>DATA PARAMETER FUNDAMENTAL</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Emiten</th>
                <th>Tahun</th>
                <th>Triwulan</th>
                <th>Cash Equivalent</th>
                <th>Current Asset</th>
                <th>Total Asset</th>
                <th>Total Equity</th>
                <th>Current Liabilities</th>
                <th>Total Liabilities</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->EMITEN_KODE ?></td>
                <td><?= $row->TAHUN ?></td>
                <td><?= $row->TRIWULAN ?></td>
                <td class="right"><?= number_format($row->CE,2) ?></td>
                <td class="right"><?= number_format($row->CA,2) ?></td>
                <td class="right"><?= number_format($row->TA,2) ?></td>
                <td class="right"><?= number_format($row->TE,2) ?></td>
                <td class="right"><?= number_format($row->CL,2) ?></td>
                <td class="right"><?= number_format($row->TL,2) ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
