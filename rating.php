<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Rating - Sistem Manajemen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .judul-halaman {
            text-align: center;
            font-weight: bold;
            font-size: 28px;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .table thead {
            background-color: #343a40;
            color: white;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn-sm i {
            margin-right: 4px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <h2 class="judul-halaman">
            <i class="bi bi-star-fill me-2"></i>Daftar Rating
        </h2>
        <div class="mb-3 text-end">
            <a href="rating_tambah.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Tambah Rating
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="table-dark">
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Bulan</th>
                            <th>Nilai Rating</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($conn, "SELECT rating.*, karyawan.nama FROM rating 
                            JOIN karyawan ON rating.karyawan_id = karyawan.id 
                            ORDER BY rating.id DESC");

                        while ($row = mysqli_fetch_assoc($query)) {
                            echo '
                            <tr>
                                <td>' . $no++ . '</td>
                                <td>' . htmlspecialchars($row['nama']) . '</td>
                                <td>' . htmlspecialchars($row['bulan']) . '</td>
                                <td>' . htmlspecialchars($row['nilai_rating']) . '</td>
                                <td>
                                    <a href="rating_edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>Edit
                                    </a>
                                    <a href="rating_detail.php?id=' . $row['id'] . '" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye-fill"></i>Detail
                                    </a>
                                    <a href="rating_hapus.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus data ini?\')">
                                        <i class="bi bi-trash"></i>Hapus
                                    </a>
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
