<?php
include 'auth.php';
include '../config/koneksi.php';

$jml_agent    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_agent"))['total'];
$jml_kriteria = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_kriteria"))['total'];
$jml_aturan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_aturan"))['total'];
$jml_riwayat  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_riwayat"))['total'];

if (isset($_GET['hapus_riwayat'])) {
    $id = intval($_GET['hapus_riwayat']);
    mysqli_query($conn, "DELETE FROM tb_riwayat WHERE id_riwayat = $id");
    header("Location: dashboard.php");
    exit;
}

$riwayat = mysqli_query($conn, "SELECT * FROM tb_riwayat ORDER BY tanggal DESC LIMIT 15");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <h3 class="fw-bold mb-4">Ringkasan Sistem Pakar</h3>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card card-valo p-3 text-center">
                <span class="text-secondary small">TOTAL AGENT</span>
                <h2 class="fw-bold text-danger mb-0"><?= $jml_agent ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-valo p-3 text-center">
                <span class="text-secondary small">TOTAL KRITERIA & MAP</span>
                <h2 class="fw-bold text-light mb-0"><?= $jml_kriteria ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-valo p-3 text-center">
                <span class="text-secondary small">BASIS ATURAN (RULES)</span>
                <h2 class="fw-bold text-info mb-0"><?= $jml_aturan ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-valo p-3 text-center">
                <span class="text-secondary small">TOTAL KONSULTASI</span>
                <h2 class="fw-bold text-success mb-0"><?= $jml_riwayat ?></h2>
            </div>
        </div>
    </div>

    <div class="card card-valo p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Log Riwayat Konsultasi User</h5>
            <a href="../index.php" target="_blank" class="btn btn-outline-light btn-sm">Lihat Halaman User &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary">
                        <th>No</th>
                        <th>Nama Pemain</th>
                        <th>Agent Rekomendasi #1</th>
                        <th>Nilai CF</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($r = mysqli_fetch_assoc($riwayat)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($r['nama_pemain']) ?></td>
                            <td class="fw-bold text-danger"><?= htmlspecialchars($r['agent_terpilih']) ?></td>
                            <td><span class="badge bg-danger"><?= $r['nilai_cf'] ?>%</span></td>
                            <td class="small text-secondary"><?= $r['tanggal'] ?></td>
                            <td>
                                <a href="?hapus_riwayat=<?= $r['id_riwayat'] ?>" onclick="return confirm('Hapus log ini?')" class="btn btn-outline-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>