<?php
include 'koneksi.php';

// ambil id rating dari URL
$id = $_GET['id'];

// ambil data rating beserta nama karyawannya
$query = mysqli_query($conn, "SELECT rating.*, karyawan.nama FROM rating 
    JOIN karyawan ON rating.karyawan_id = karyawan.id 
    WHERE rating.id = $id");
$data = mysqli_fetch_assoc($query);

// kalau tombol update ditekan
if (isset($_POST['update'])) {
    $nama_karyawan = $_POST['nama_karyawan'];
    $bulan = $_POST['bulan'];
    $nilai_rating = $_POST['nilai_rating'];

    // cari karyawan_id berdasarkan nama
    $karyawan_query = mysqli_query($conn, "SELECT id FROM karyawan WHERE nama = '$nama_karyawan'");
    $karyawan = mysqli_fetch_assoc($karyawan_query);

    if ($karyawan) {
        // kalau ketemu
        $karyawan_id = $karyawan['id'];
    } else {
        // kalau belum ada, insert baru
        $insert_karyawan = mysqli_query($conn, "INSERT INTO karyawan (nama) VALUES ('$nama_karyawan')");
        if ($insert_karyawan) {
            $karyawan_id = mysqli_insert_id($conn);
        } else {
            echo "<script>alert('Gagal menambahkan karyawan baru');</script>";
            exit;
        }
    }

    // update data rating
    $update = mysqli_query($conn, "UPDATE rating SET 
        karyawan_id = '$karyawan_id',
        bulan = '$bulan',
        nilai_rating = '$nilai_rating'
        WHERE id = $id");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate'); window.location='rating.php';</script>";
    } else {
        echo "<script>alert('Gagal update data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Rating - Sistem Manajemen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <h2 class="text-primary mb-4">
            <i class="bi bi-pencil-square me-2"></i>Edit Rating
        </h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" name="nama_karyawan" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Bulan</label>
                <input type="month" name="bulan" class="form-control" value="<?= htmlspecialchars($data['bulan']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nilai Rating</label>
                <input type="number" name="nilai_rating" class="form-control" value="<?= htmlspecialchars($data['nilai_rating']) ?>" min="1" max="5" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Update
            </button>
            <a href="rating.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i>Kembali
            </a>
        </form>
    </div>
</div>
</body>
</html>
