<?php
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Query ambil data rating dan join ke karyawan
$query = mysqli_query($conn, "SELECT rating.*, karyawan.nama FROM rating 
                              JOIN karyawan ON rating.karyawan_id = karyawan.id 
                              WHERE rating.id = $id");
$row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Rating Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Konten Utama -->
        <div class="p-4 w-100">
            <div class="container">
                <h3 class="mb-4">Detail Rating Karyawan</h3>

                <?php if ($row): ?>
                    <div class="card shadow-lg border-0 rounded">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="bi bi-star-fill text-warning me-2"></i><?= htmlspecialchars($row['nama']) ?>
                            </h5>
                            <p class="mb-2">
                                <strong>Bulan:</strong> <?= htmlspecialchars($row['bulan']) ?>
                            </p>
                            <p class="mb-0">
                                <strong>Nilai Rating:</strong>
                                <span class="text-primary fs-5">
                                    <?= htmlspecialchars($row['nilai_rating']) ?>
                                    <?php for ($i = 0; $i < $row['nilai_rating']; $i++): ?>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    <?php endfor; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning mt-3">
                        Data rating tidak ditemukan.
                    </div>
                <?php endif; ?>

                <a href="rating.php" class="btn btn-secondary mt-4">← Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
