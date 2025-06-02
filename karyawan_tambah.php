<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama               = $_POST['nama'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $jabatan_id         = $_POST['jabatan_id'];
    $alamat             = $_POST['alamat'];
    $no_hp              = $_POST['no_hp'];
    $tanggal_bergabung  = $_POST['tanggal_bergabung'];
    $nilai_rating       = $_POST['nilai_rating'];

    // Proses upload foto
    $foto       = $_FILES['foto']['name'];
    $tmp        = $_FILES['foto']['tmp_name'];
    $upload_dir = 'uploads/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Buat folder jika belum ada
    }

    if ($foto != "") {
        if (!move_uploaded_file($tmp, $upload_dir . $foto)) {
            die("Upload foto gagal.");
        }
    }

    // Simpan data karyawan
    $query = mysqli_query($conn, "INSERT INTO karyawan (nama, jenis_kelamin, jabatan_id, alamat, no_hp, foto, tanggal_bergabung)
                                  VALUES ('$nama', '$jenis_kelamin', '$jabatan_id', '$alamat', '$no_hp', '$foto', '$tanggal_bergabung')");

    if (!$query) {
        die("Query Error (karyawan): " . mysqli_error($conn));
    }

    $karyawan_id = mysqli_insert_id($conn);
    $bulan = date('Y-m');

    // Simpan data rating 
    $insert_rating = mysqli_query($conn, "INSERT INTO rating (karyawan_id, bulan, nilai_rating)
                                          VALUES ('$karyawan_id', '$bulan', '$nilai_rating')");

    if (!$insert_rating) {
        die("Query Error (rating): " . mysqli_error($conn));
    }

    // Jika sukses semua
    header("Location: karyawan.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <h3>Tambah Data Karyawan</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select name="jabatan_id" class="form-select" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <?php
                    $jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
                    while ($row = mysqli_fetch_assoc($jabatan)) {
                        echo '<option value="' . $row['id'] . '">' . $row['nama_jabatan'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>

            <!-- Tanggal Bergabung -->
            <div class="mb-3">
                <label class="form-label">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" class="form-control" max="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating (1 - 5)</label>
                <select name="nilai_rating" class="form-select" required>
                    <option value="">-- Pilih Rating --</option>
                    <option value="1">1 - Sangat Buruk</option>
                    <option value="2">2 - Buruk</option>
                    <option value="3">3 - Cukup</option>
                    <option value="4">4 - Baik</option>
                    <option value="5">5 - Sangat Baik</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="karyawan.php" class="btn btn-secondary">← Kembali</a>
        </form>
    </div>
</div>
</body>
</html>