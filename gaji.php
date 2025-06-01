<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tarif Gaji - Sistem Manajemen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.4rem;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        <div class="container py-5">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">
                        <i class="bi bi-cash-stack text-success me-2"></i>Daftar Tarif Gaji
                    </h4>
                    <a href="gaji_tambah.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Tambah Gaji
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Bulan</th>
                                <th>Total Gaji</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($conn, "
                                SELECT gaji.id, karyawan.nama, gaji.bulan, gaji.total_gaji 
                                FROM gaji 
                                JOIN karyawan ON gaji.karyawan_id = karyawan.id 
                                ORDER BY gaji.bulan DESC
                            ");
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="text-start"><?= $data['nama'] ?></td>
                                    <td><?= $data['bulan'] ?></td>
                                    <td class="text-end">Rp <?= number_format($data['total_gaji'], 0, ',', '.') ?></td>
                                    <td class="action-buttons">
                                        <a href="gaji_edit.php?id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a>
                                        <a href="gaji_detail.php?id=<?= $data['id'] ?>" class="btn btn-info btn-sm text-white">
                                            <i class="bi bi-eye-fill"></i> Detail
                                        </a>
                                        <a href="gaji_hapus.php?id=<?= $data['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
