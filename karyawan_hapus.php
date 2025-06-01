<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // pastikan ID berupa integer

    // Cek apakah karyawan ada dulu
    $cek = mysqli_query($conn, "SELECT id FROM karyawan WHERE id = $id");
    if (mysqli_num_rows($cek) > 0) {

        // Hapus data rating yang terkait
        mysqli_query($conn, "DELETE FROM rating WHERE karyawan_id = $id");

        // Hapus data karyawan
        mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id");

        // Redirect balik ke halaman karyawan
        header("Location: karyawan.php");
        exit;

    } else {
        echo "Data karyawan tidak ditemukan.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
