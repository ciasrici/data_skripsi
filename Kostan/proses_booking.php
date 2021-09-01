<?php
session_start();
require 'config/get_connection.php';

if (!isset($_SESSION['user'])) {
    $_SESSION['failed'] = 'Anda harus login dulu!';
    header('Location: login.php');
    exit;
}

$kamar_id = $_GET['kamar_id'];
$user_id = $_SESSION['user']['id_user'];
$tanggal_pesan = date('Y-m-d H:i:s');
$status = 0;
$query = "INSERT INTO `pemesanan` (`user_id`,`kamar_id`,`tanggal_pesan`,`tanggal_transaksi`,`status`) VALUES ('$user_id','$kamar_id','$tanggal_pesan','$tanggal_transaksi','$status')";
if (mysqli_query(connect(), $query)) {
	$status_kamar = mysqli_query(connect(), "UPDATE kamar SET status = 1 WHERE id_kamar = '$kamar_id'");
    $_SESSION['success'] = 'Pemesanan kamar berhasil, silahkan konfirmasi pembayaran!';
    header('Location: booking.php');
}
