<?php
include 'koneksi.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT k.*, j.nama_jabatan FROM karyawan k LEFT JOIN jabatan j ON k.jabatan_id = j.id WHERE k.id = $id");
$data = mysqli_fetch_array($query);

// Ambil rating (jika ada)
$rating_query = mysqli_query($conn, "SELECT nilai_rating FROM rating WHERE karyawan_id = $id ORDER BY bulan DESC LIMIT 1");
$rating_data = mysqli_fetch_array($rating_query);
$rating = isset($rating_data['nilai_rating']) ? $rating_data['nilai_rating'] : 0;

// Badge warna untuk jabatan
$jabatan = strtolower($data['nama_jabatan']);
$badgeClass = 'secondary';
if ($jabatan === 'manager') $badgeClass = 'primary';
elseif ($jabatan === 'staff') $badgeClass = 'success';
elseif ($jabatan === 'supervisor') $badgeClass = 'dark';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid mt-5">
    <h2 class="text-center fw-bold mb-4 text-uppercase text-primary">Detail Karyawan</h2>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="row g-0 p-4">
            <div class="col-md-4 text-center border-end">
                <img src="uploads/<?= $data['foto'] ?>" class="img-fluid rounded-3 shadow-sm mb-3" style="max-width: 230px; height: 300px; object-fit: cover;" alt="Foto Karyawan">
                <div class="mt-2">
                    <strong class="d-block mb-1">Rating:</strong>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span style="font-size: 20px;" class="<?= $i <= $rating ? 'text-warning' : 'text-muted' ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-borderless ms-md-4">
                    <tr><th class="w-50">Nama</th><td>: <?= $data['nama'] ?></td></tr>
                    <tr><th>Jenis Kelamin</th><td>: <?= $data['jenis_kelamin'] ?></td></tr>
                    <tr><th>Alamat</th><td>: <?= $data['alamat'] ?></td></tr>
                    <tr><th>No. Telp</th><td>: <?= $data['no_hp'] ?></td></tr>
                    <tr><th>Jabatan</th><td>: <span class="badge bg-<?= $badgeClass ?> px-3 py-1"><?= $data['nama_jabatan'] ?></span></td></tr>
                    <tr><th>Tanggal Bergabung</th><td>: <?= date('d F Y', strtotime($data['tanggal_bergabung'])) ?></td></tr>
                </table>

                <div class="mt-4 ms-md-4">
                    <a href="karyawan/karyawan_edit.php?id=<?= $data['id'] ?>" class="btn btn-primary me-2 shadow-sm px-4">Edit</a>
                    <a href="dashboard.php" class="btn btn-outline-secondary px-4">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

