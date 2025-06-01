<?php 
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM jabatan WHERE id=$id");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jabatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container-edit {
            max-width: 1350px;
            margin: auto;
        }
        .judul-halaman {
            text-align: center;
            font-weight: bold;
            font-size: 26px;
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .btn-update {
            background: linear-gradient(90deg, #0d6efd, #3b82f6);
            color: white;
            border: none;
            transition: 0.3s ease;
        }
        .btn-update:hover {
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <div class="container-edit">
            <h2 class="judul-halaman">
                <i class="bi bi-pencil-square me-2"></i>Edit Jabatan
            </h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" class="form-control" value="<?= htmlspecialchars($row['nama_jabatan']) ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Gaji Pokok</label>
                            <input type="number" name="gaji_pokok" class="form-control" value="<?= htmlspecialchars($row['gaji_pokok']) ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="update" class="btn btn-update">
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                            <a href="jabatan.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>

                    <?php
                    if (isset($_POST['update'])) {
                        $nama = $_POST['nama_jabatan'];
                        $gaji = $_POST['gaji_pokok'];

                        $update = mysqli_query($conn, "UPDATE jabatan SET nama_jabatan='$nama', gaji_pokok='$gaji' WHERE id=$id");
                        if ($update) {
                            echo "<script>window.location='jabatan.php';</script>";
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Gagal mengupdate data.</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
