<?php
include 'koneksi.php';
include 'includes/sidebar.php';

// Validasi dan casting ID ke integer
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>
            alert('ID tidak valid.');
            window.location.href = 'gaji.php';
          </script>";
    exit;
}
$id = (int) $_GET['id'];

// Susun query:
// – ambil gaji_pokok dan nama_jabatan dari tabel jabatan (alias j)
// – ambil jumlah_jam dan tarif_per_jam dari tabel lembur (alias l)
// – ambil nilai_rating dari tabel rating (alias r)
// – gabungkan berdasarkan bulan dan karyawan_id
$query = "
    SELECT
        g.*,
        k.nama,
        j.nama_jabatan,
        j.gaji_pokok,
        l.tarif_per_jam,
        r.nilai_rating,
        l.jumlah_jam
    FROM gaji AS g
    JOIN karyawan AS k 
        ON g.karyawan_id = k.id
    JOIN jabatan AS j 
        ON k.jabatan_id = j.id
    LEFT JOIN rating AS r
        ON r.karyawan_id = k.id
        AND r.bulan = g.bulan
    LEFT JOIN lembur AS l
        ON l.karyawan_id = k.id
        AND l.bulan = g.bulan
    WHERE g.id = $id
    LIMIT 1
";

// Eksekusi query
$result = mysqli_query($conn, $query);

// Cek jika query gagal
if ($result === false) {
    $err = mysqli_error($conn);
    echo "<script>
            alert('Query gagal: " . htmlspecialchars($err, ENT_QUOTES) . "');
            window.location.href = 'gaji.php';
          </script>";
    exit;
}

// Ambil data
$data = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan (hasil fetch_assoc = null), redirect
if (!$data) {
    echo "<script>
            alert('Data gaji tidak ditemukan.');
            window.location.href = 'gaji.php';
          </script>";
    exit;
}

// Karena tarif_per_jam & jumlah_jam berada di tabel lembur,
// gunakan null-coalescing untuk menghindari error bila tidak ada record lembur.
$jumlah_jam    = $data['jumlah_jam']    ?? 0;
$tarif_per_jam = $data['tarif_per_jam'] ?? 0;
$total_lembur  = $jumlah_jam * $tarif_per_jam;

$gaji_pokok = $data['gaji_pokok'] ?? 0;
$total_gaji = $gaji_pokok + $total_lembur;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar sudah di-include di atas -->
        <div class="col-md-10 ms-sm-auto col-lg-10 px-4 mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Detail Gaji Karyawan</h4>
            </div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td><?= htmlspecialchars($data['nama'], ENT_QUOTES) ?></td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td><?= htmlspecialchars($data['nama_jabatan'], ENT_QUOTES) ?></td>
                    </tr>
                    <tr>
                        <th>Bulan</th>
                        <td><?= htmlspecialchars($data['bulan'], ENT_QUOTES) ?></td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp <?= number_format($gaji_pokok, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Jam Lembur</th>
                        <td><?= $jumlah_jam ?> jam</td>
                    </tr>
                    <tr>
                        <th>Tarif Lembur / Jam</th>
                        <td>Rp <?= number_format($tarif_per_jam, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Total Lembur</th>
                        <td>Rp <?= number_format($total_lembur, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Rating</th>
                        <td>
                            <?= isset($data['nilai_rating']) 
                                ? htmlspecialchars($data['nilai_rating'], ENT_QUOTES) 
                                : '-' 
                            ?>
                        </td>
                    </tr>
                    <tr class="table-success">
                        <th>Total Gaji</th>
                        <td><strong>Rp <?= number_format($total_gaji, 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <a href="gaji.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
</body>
</html>
