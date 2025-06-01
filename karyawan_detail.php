<?php
include 'koneksi.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT k.*, j.nama_jabatan FROM karyawan k LEFT JOIN jabatan j ON k.jabatan_id = j.id WHERE k.id = $id");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Data Tidak Ditemukan',
            text: 'Karyawan dengan ID tersebut tidak tersedia!',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href = '../karyawan/karyawan.php';
        });
    </script>";
    exit;
}

$rating_query = mysqli_query($conn, "SELECT nilai_rating FROM rating WHERE karyawan_id = $id ORDER BY bulan DESC LIMIT 1");
$rating_data = mysqli_fetch_array($rating_query);
$rating = isset($rating_data['nilai_rating']) ? $rating_data['nilai_rating'] : 0;

$jabatan = strtolower($data['nama_jabatan']);
$badgeClass = 'secondary';
if ($jabatan === 'manager') $badgeClass = 'primary';
elseif ($jabatan === 'staff') $badgeClass = 'success';
elseif ($jabatan === 'supervisor') $badgeClass = 'dark';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Karyawan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .card {
            border-radius: 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            width: 40%;
        }

        .detail-value {
            color: #555;
        }

        .img-box {
            padding: 15px;
        }

        .back-btn {
            margin-top: 30px;
        }

        .wrapper {
            margin-left: 320px;
        }
    </style>
</head>
<body>
<div class="container my-5 wrapper"  data-aos="fade-up">
    <h2 class="text-center fw-bold mb-4 text-uppercase text-primary" data-aos="fade-down">Detail Karyawan</h2>

    <div class="card shadow-lg p-4" data-aos="zoom-in">
        <div class="row g-4">
            <!-- FOTO -->
            <div class="col-md-4 text-center border-end d-flex flex-column align-items-center justify-content-center img-box">
                <?php
                $foto_path = "uploads/" . $data['foto'];
                if (!empty($data['foto']) && file_exists($foto_path)): ?>
                    <img src="<?= $foto_path ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 300px; width: auto; object-fit: cover;" alt="Foto Karyawan">
                <?php else: ?>
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Foto Tidak Tersedia',
                            text: 'Foto karyawan ini tidak ditemukan!',
                            confirmButtonColor: '#f39c12'
                        });
                    </script>
                    <div class="bg-light text-muted py-5 px-3 rounded">Foto tidak tersedia</div>
                <?php endif; ?>

                <div class="mt-3">
                    <strong class="d-block mb-1">Rating:</strong>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span style="font-size: 20px;" class="<?= $i <= $rating ? 'text-warning' : 'text-muted' ?>">&#9733;</span>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- INFORMASI -->
            <div class="col-md-8 px-4">
                <table class="table table-borderless">
                    <tr><td class="detail-label">Nama</td><td class="detail-value">: <?= $data['nama'] ?></td></tr>
                    
                    <tr><td class="detail-label">Jenis Kelamin</td><td class="detail-value">: <?= $data['jenis_kelamin'] ?></td></tr>
                    <tr><td class="detail-label">Alamat</td><td class="detail-value">: <?= $data['alamat'] ?></td></tr>
                    <tr><td class="detail-label">No. Telp</td><td class="detail-value">: <?= $data['no_hp'] ?></td></tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        <td class="detail-label">Jabatan</td>
                        <td class="detail-value">: <span class="badge bg-<?= $badgeClass ?> px-3 py-1"><?= $data['nama_jabatan'] ?></span></td>
                    </tr>
                    <tr><td class="detail-label">Tanggal Bergabung</td><td class="detail-value">: <?= date('d F Y', strtotime($data['tanggal_bergabung'])) ?></td></tr>
                </table>

                <div class="d-flex gap-2 mt-4 back-btn">
                    <a href="karyawan_edit.php?id=<?= $data['id'] ?>" class="btn btn-primary shadow-sm px-4">Edit</a>
                    <a href="karyawan.php" class="btn btn-outline-secondary px-4">← Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>