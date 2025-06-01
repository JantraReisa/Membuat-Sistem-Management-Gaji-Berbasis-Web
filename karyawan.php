<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Karyawan - Sistem Manajemen Gaji</title>
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
            color: #fff;
        }

        .foto-karyawan {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .kartu-karyawan {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .kartu-karyawan:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .badge-role {
            font-size: 13px;
        }

        .btn-detail, .btn-hapus {
            font-size: 14px;
            padding: 4px 12px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <div class="text-center mb-4">
            <h3 class="judul-dashboard mb-2 text-primary fw-bold">
                <i class="bi bi-person-badge-fill me-2"></i> Daftar Karyawan
            </h3>
            <p class="subjudul-dashboard">Lihat informasi karyawan terbaru dengan mudah dan cepat</p>
            <a href="karyawan_tambah.php" class="btn btn-tambah mt-2">
                <i class="bi bi-plus-circle me-1"></i> Tambah Karyawan
            </a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            $query = mysqli_query($conn, "SELECT karyawan.*, jabatan.nama_jabatan 
                                          FROM karyawan 
                                          JOIN jabatan ON karyawan.jabatan_id = jabatan.id 
                                          ORDER BY karyawan.id DESC");
            $bulan_ini = date('Y-m');
            while ($row = mysqli_fetch_assoc($query)) {
                $id_karyawan = $row['id'];
                $rating_q = mysqli_query($conn, "SELECT nilai_rating FROM rating WHERE karyawan_id = $id_karyawan AND bulan = '$bulan_ini'");
                $data_rating = mysqli_fetch_assoc($rating_q);
                $nilai_rating = $data_rating['nilai_rating'] ?? '-';
                $bintang = is_numeric($nilai_rating) ? str_repeat('⭐', $nilai_rating) : '-';

                $jabatan = strtolower($row['nama_jabatan']);
                $badge_class = match ($jabatan) {
                    'manager' => 'primary',
                    'supervisor' => 'secondary',
                    'staff' => 'success',
                    'admin' => 'danger',
                    default => 'dark'
                };

                echo '
                <div class="col">
                    <div class="card kartu-karyawan shadow-sm h-100">
                        <img src="uploads/' . $row['foto'] . '" class="foto-karyawan card-img-top" alt="Foto">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">' . $row['nama'] . '</h5>
                            <div class="text-warning mb-1">Rating: ' . $bintang . '</div>
                            <span class="badge bg-' . $badge_class . ' badge-role mb-2">' . $row['nama_jabatan'] . '</span><br>
                            <a href="karyawan_detail.php?id=' . $id_karyawan . '" class="btn btn-outline-primary btn-sm btn-detail"><i class="bi bi-info-circle"></i> Detail</a>
                            <a href="karyawan_edit.php?id=' . $id_karyawan . '" class="btn btn-outline-success btn-sm btn-detail"><i class="bi bi-pencil-square"></i> Edit</a>
                            <a href="karyawan_hapus.php?id=' . $id_karyawan . '" class="btn btn-outline-danger btn-sm btn-hapus" onclick="return confirm(\'Yakin ingin menghapus?\')"><i class="bi bi-trash"></i> Hapus</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
