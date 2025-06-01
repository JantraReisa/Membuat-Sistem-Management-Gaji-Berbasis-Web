<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Jabatan - Sistem Manajemen Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .judul-dashboard {
            font-size: 26px;
            font-weight: bold;
            color: #0d6efd;
        }

        .subjudul-dashboard {
            font-size: 16px;
            color: #6c757d;
        }

        .btn-tambah {
            background: linear-gradient(90deg, #0d6efd, #3b82f6);
            color: white;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
        }

        .table th {
            background-color: #343a40;
            color: white;
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
        <div class="text-center mb-4">
            <h3 class="judul-dashboard mb-2">
                <i class="bi bi-briefcase-fill me-2"></i> Daftar Jabatan
            </h3>
            <p class="subjudul-dashboard">Berikut adalah daftar jabatan dan gaji pokok masing-masing</p>
            <a href="jabatan_tambah.php" class="btn btn-tambah mt-2">
                <i class="bi bi-plus-circle me-1"></i> Tambah Jabatan
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($conn, "SELECT * FROM jabatan");

                            if ($query && mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>{$row['nama_jabatan']}</td>
                                        <td>Rp " . number_format($row['gaji_pokok'], 0, ',', '.') . "</td>
                                        <td class='text-center'>
                                            <a href='jabatan_edit.php?id={$row['id']}' class='btn btn-warning btn-sm me-1'>
                                                <i class='bi bi-pencil-square'></i> Edit
                                            </a>
                                            <a href='jabatan_detail.php?id={$row['id']}' class='btn btn-info btn-sm text-white me-1'>
                                                <i class='bi bi-info-circle'></i> Detail
                                            </a>
                                            <a href='jabatan_hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                                                <i class='bi bi-trash'></i> Hapus
                                            </a>
                                        </td>
                                    </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
