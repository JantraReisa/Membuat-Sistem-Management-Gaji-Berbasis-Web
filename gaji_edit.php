<?php
include 'koneksi.php';
include 'includes/sidebar.php';

// Ensure ID is set in URL and is valid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID parameter is missing or invalid!";
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM gaji WHERE id = $id");

if (mysqli_num_rows($query) == 0) {
    echo "Data not found!";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <?php include 'includes/sidebar.php'; ?>
        <div class="container py-5">
            <div class="form-container">
                <div class="card p-4">
                    <h4 class="mb-4">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Edit Data Gaji
                    </h4>
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Bulan</label>
                            <input type="text" name="bulan" class="form-control" value="<?= $data['bulan'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Gaji</label>
                            <input type="number" name="total_gaji" class="form-control" value="<?= $data['total_gaji'] ?>" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="gaji.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" name="update" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['update'])) {
                        $bulan = $_POST['bulan'];
                        $gaji = $_POST['total_gaji'];
                        $update_query = "UPDATE gaji SET bulan = '$bulan', total_gaji = '$gaji' WHERE id = $id";
                        if (mysqli_query($conn, $update_query)) {
                            echo "<script>location.href='gaji.php';</script>";
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
