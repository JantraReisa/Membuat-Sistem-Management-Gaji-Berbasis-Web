<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: karyawan.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM karyawan WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

// Ambil data rating
$rating_query = mysqli_query($conn, "SELECT * FROM rating WHERE karyawan_id = '$id'");
$rating_data = mysqli_fetch_assoc($rating_query);
$nilai_rating = $rating_data ? $rating_data['nilai_rating'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jabatan_id = $_POST['jabatan_id'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $tanggal_bergabung = $_POST['tanggal_bergabung'];
    $nilai_rating = $_POST['nilai_rating'];

    // Cek apakah ada file foto baru yang diupload
    $foto_baru = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $upload_dir = 'uploads/';

    if ($foto_baru != "") {
        move_uploaded_file($tmp, $upload_dir . $foto_baru);
        $foto = $foto_baru;
    } else {
        $foto = $data['foto']; // pakai foto lama
    }

    // Update data karyawan
    $update = mysqli_query($conn, "UPDATE karyawan SET 
        nama='$nama',
        jenis_kelamin='$jenis_kelamin',
        jabatan_id='$jabatan_id',
        alamat='$alamat',
        no_hp='$no_hp',
        foto='$foto',
        tanggal_bergabung='$tanggal_bergabung'
        WHERE id='$id'");

    if ($update) {
        // cek apakah sudah ada rating
        $cek_rating = mysqli_query($conn, "SELECT * FROM rating WHERE karyawan_id = '$id'");
        if (mysqli_num_rows($cek_rating) > 0) {
            // update rating
            $update_rating = mysqli_query($conn, "UPDATE rating SET nilai_rating = '$nilai_rating' WHERE karyawan_id = '$id'");
        } else {
            // insert rating baru
            $insert_rating = mysqli_query($conn, "INSERT INTO rating (karyawan_id, nilai_rating) VALUES ('$id', '$nilai_rating')");
        }

        header("Location: karyawan.php");
        exit;
    } else {
        echo "Gagal mengupdate data karyawan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include 'includes/sidebar.php'; ?>
    <div class="p-4 w-100">
        <h3>Edit Data Karyawan</h3>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="Laki-laki" <?= $data['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $data['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Jabatan</label>
                <select name="jabatan_id" class="form-select" required>
                    <?php
                    $jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
                    while ($row = mysqli_fetch_assoc($jabatan)) {
                        $selected = $data['jabatan_id'] == $row['id'] ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['nama_jabatan']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required><?= $data['alamat'] ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= $data['no_hp'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Bergabung</label>
                <input type="date" name="tanggal_bergabung" class="form-control" value="<?= $data['tanggal_bergabung'] ?>" max="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto (kosongkan jika tidak ingin mengganti)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <div class="mt-2">
                    <img src="uploads/<?= $data['foto'] ?>" width="100" alt="Foto Karyawan">
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Rating (1-5)</label>
                <select name="nilai_rating" class="form-select" required>
                    <option value="1" <?= $nilai_rating == '1' ? 'selected' : '' ?>>1 - Sangat Buruk</option>
                    <option value="2" <?= $nilai_rating == '2' ? 'selected' : '' ?>>2 - Buruk</option>
                    <option value="3" <?= $nilai_rating == '3' ? 'selected' : '' ?>>3 - Cukup</option>
                    <option value="4" <?= $nilai_rating == '4' ? 'selected' : '' ?>>4 - Baik</option>
                    <option value="5" <?= $nilai_rating == '5' ? 'selected' : '' ?>>5 - Sangat Baik</option>
                </select>
                <div class="invalid-feedback">Rating wajib dipilih.</div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="karyawan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
</body>
</html>
