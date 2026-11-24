<?php
include 'auth.php';
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $kode = mysqli_real_escape_string($conn, strtoupper(trim($_POST['kode_kriteria'])));
    $kat  = mysqli_real_escape_string($conn, $_POST['kategori']);
    $pert = mysqli_real_escape_string($conn, trim($_POST['pertanyaan']));

    mysqli_query($conn, "INSERT INTO tb_kriteria (kode_kriteria, kategori, pertanyaan) VALUES ('$kode', '$kat', '$pert')");
    header("Location: kelola_kriteria.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $kode = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM tb_kriteria WHERE kode_kriteria = '$kode'");
    header("Location: kelola_kriteria.php");
    exit;
}

$kriteria = mysqli_query($conn, "SELECT * FROM tb_kriteria ORDER BY kode_kriteria ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kriteria | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-valo p-4">
                <h5 class="fw-bold text-danger mb-3">Tambah Kriteria / Map</h5>
                <form method="POST">
                    <div class="mb-2">
                        <label class="form-label small">Kode Kriteria (Misal: K25)</label>
                        <input type="text" name="kode_kriteria" class="form-control form-control-valo form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Kategori</label>
                        <select name="kategori" class="form-select form-select-valo form-select-sm" required>
                            <option value="Map">Map</option>
                            <option value="Kebutuhan Tim">Kebutuhan Tim</option>
                            <option value="Gaya Bermain">Gaya Bermain</option>
                            <option value="Kondisi Party / OTP">Kondisi Party / OTP</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Nama Map / Pertanyaan Kriteria</label>
                        <textarea name="pertanyaan" rows="3" class="form-control form-control-valo form-control-sm" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="tambah" class="btn btn-valo btn-sm">Simpan Kriteria</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-valo p-4">
                <h5 class="fw-bold mb-3">Daftar Kriteria & Map</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="text-secondary">
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Pertanyaan / Nama Map</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($k = mysqli_fetch_assoc($kriteria)): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?= $k['kode_kriteria'] ?></span></td>
                                    <td><span class="badge badge-role"><?= $k['kategori'] ?></span></td>
                                    <td><?= htmlspecialchars($k['pertanyaan']) ?></td>
                                    <td>
                                        <a href="?hapus=<?= $k['kode_kriteria'] ?>" onclick="return confirm('Hapus kriteria ini?')" class="btn btn-outline-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>