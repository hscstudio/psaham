<!DOCTYPE html>
<html>
<head>
    <title>DATA SECURITAS</title>
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
    </style>
</head>
<body>
    <div class="page">
        <h2>DATA SECURITAS</h2>
        <table>
        <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Alamat / No.Telp</th>
                <th>Kontak</th>
        </tr>
        <?php
        $no = 1;
        foreach($dataProvider->getModels() as $row){
        ?>
        <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->KODE ?></td>
                <td><?= $row->NAMA ?></td>
                <td><?= $row->ALAMAT . ', ' . $row->TELP ?></td>
                <td><?= $row->CP ?></td>
        </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>
