<?php
include_once('./config.php');

$result_sales = mysqli_query($mysqli, "SELECT *, COUNT(t_sales_det.barang_id) AS jumlah_barang FROM `t_sales_det`
INNER JOIN t_sales ON t_sales_det.sales_id = t_sales.id");

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Depertamen Produksi</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Daftar Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./input.php">Form Input</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No Transaksi</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Ongkir</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($sales_data = mysqli_fetch_array($result_sales)) {
                    echo "<tr>";
                    echo '<td>' . $i . '</td>';
                    echo '<td>' . $sales_data['kode'] . '</td>';
                    echo '<td>' . $sales_data['jumlah_barang'] . '</td>';
                    echo '<td>' . $sales_data['subtotal'] . '</td>';
                    echo '<td>' . $sales_data['diskon'] . '</td>';
                    echo '<td>' . $sales_data['ongkir'] . '</td>';
                    echo '<td>' . $sales_data['total_bayar'] . '</td>';
                    echo "</tr>";
                    $i++;
                }

                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>