<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $karyawan_id = $_POST['karyawan_id'];
    $bulan = $_POST['bulan'];
    $nilai_rating = $_POST['nilai_rating'];

    if (empty($karyawan_id) || empty($bulan) || empty($nilai_rating)) {
        echo "<script>alert('Semua kolom wajib diisi.');</script>";
    } else {
        $query = mysqli_query($conn, "INSERT INTO rating (karyawan_id, bulan, nilai_rating) 
                                      VALUES ('$karyawan_id', '$bulan', '$nilai_rating')");
        if ($query) {
            echo "<script>
                alert('Data rating berhasil ditambahkan.');
                window.location.href = 'rating.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Gagal menambahkan data. Silakan coba lagi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .judul-halaman {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #198754;
            margin-bottom: 25px;
        }
        .card {
            max-width: 1350px;
            margin: auto;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <h2 class="judul-halaman">
            <i class="bi bi-plus-circle me-2"></i>Tambah Rating
        </h2>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Nama Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php
                            $data = mysqli_query($conn, "SELECT * FROM karyawan");
                            while ($row = mysqli_fetch_assoc($data)) {
                                echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input type="month" name="bulan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nilai_rating" class="form-label">Nilai Rating</label>
                        <input type="number" name="nilai_rating" class="form-control" min="1" max="5" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="rating.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" name="simpan" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</body>
</html>
