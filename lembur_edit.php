<?php
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM lembur WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $jabatan_id = $_POST['jabatan_id'];
    $tarif_per_jam = $_POST['tarif_per_jam'];
    $jumlah_jam = $_POST['jumlah_jam'];

    mysqli_query($conn, "UPDATE lembur SET 
        jabatan_id = '$jabatan_id', 
        tarif_per_jam = '$tarif_per_jam', 
        jumlah_jam = '$jumlah_jam' 
        WHERE id = $id");

    header("Location: lembur.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tarif Lembur</title>
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
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Tarif Lembur</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="jabatan_id" class="form-label">Jabatan</label>
                                <select name="jabatan_id" class="form-select" required>
                                    <?php
                                    $jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
                                    while ($j = mysqli_fetch_assoc($jabatan)) {
                                        $selected = $data['jabatan_id'] == $j['id'] ? 'selected' : '';
                                        echo '<option value="' . $j['id'] . '" ' . $selected . '>' . $j['nama_jabatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tarif Per Jam (Rp)</label>
                                <input type="number" name="tarif_per_jam" value="<?= $data['tarif_per_jam']; ?>" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Jam</label>
                                <input type="number" name="jumlah_jam" value="<?= $data['jumlah_jam']; ?>" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="lembur.php" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                </a>
                                <button type="submit" name="update" class="btn btn-success">
                                    <i class="bi bi-save-fill"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
