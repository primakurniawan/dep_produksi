<?php
include_once("config.php");

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"));

$cust_id = $data->cust_id;
$barangs = $data->barangs;
$diskon = $data->diskon;
$ongkir = $data->ongkir;
$subtotal = $data->subtotal;
$tgl = $data->tgl;
$total_biaya = $data->total_biaya;
$kode = "sales-" . uniqid();
// Insert user data into table
if (mysqli_query($mysqli, "INSERT INTO t_sales(kode, tgl, cust_id, subtotal, diskon, ongkir, total_bayar) VALUES('$kode', '$tgl', $cust_id, $subtotal, $diskon, $ongkir, $total_biaya)")) {

    $last_id = mysqli_insert_id($mysqli);
    $data->id = $last_id;
    $values = "";

    foreach ($barangs as $barang) {
        $values .= "($last_id, $barang->id, $barang->harga, $barang->qty, $barang->diskon_pct, $barang->diskon_nilai, $barang->harga_diskon, $barang->total),";
    }

    $values = substr($values, 0, -1);
    $sql = "INSERT INTO t_sales_det(sales_id, barang_id, harga_bandrol, qty, diskon_pct, diskon_nilai, harga_diskon, total) VALUES " . $values . ";";

    if (mysqli_query($mysqli, $sql)) {
        echo json_encode($last_id);
    }
}
