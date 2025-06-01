<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT lembur.*, jabatan.nama_jabatan 
    FROM lembur 
    JOIN jabatan ON lembur.jabatan_id = jabatan.id 
    WHERE lembur.id = $id
"));

$tarif = $data['tarif_per_jam'];
$jam = $data['jumlah_jam'];
$total = $tarif * $jam;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tarif Lembur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="d-flex align-items-center mb-3">
                    <a href="lembur.php" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <h4 class="mb-0">Detail Tarif Lembur</h4>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">
                            <i class="bi bi-person-badge-fill text-primary me-2"></i>Jabatan:
                            <strong><?= $data['nama_jabatan']; ?></strong>
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Tarif per Jam:</strong> Rp <?= number_format($tarif, 0, ',', '.'); ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Jumlah Jam:</strong> <?= $jam; ?> jam
                            </li>
                            <li class="list-group-item">
                                <strong>Total Lembur:</strong> <span class="text-success fw-bold">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
