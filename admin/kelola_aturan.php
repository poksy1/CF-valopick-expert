<?php
include 'auth.php';
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $agent    = mysqli_real_escape_string($conn, $_POST['kode_agent']);
    $kriteria = mysqli_real_escape_string($conn, $_POST['kode_kriteria']);
    $cf_pakar = floatval($_POST['cf_pakar']);

    mysqli_query($conn, "INSERT INTO tb_aturan (kode_agent, kode_kriteria, cf_pakar) VALUES ('$agent', '$kriteria', '$cf_pakar')");
    header("Location: kelola_aturan.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM tb_aturan WHERE id_aturan = $id");
    header("Location: kelola_aturan.php");
    exit;
}

$list_agent    = mysqli_query($conn, "SELECT kode_agent, nama_agent, role_agent FROM tb_agent ORDER BY kode_agent ASC");
$list_kriteria = mysqli_query($conn, "SELECT kode_kriteria, kategori, pertanyaan FROM tb_kriteria ORDER BY kode_kriteria ASC");

$aturan = mysqli_query($conn, "
    SELECT r.id_aturan, r.cf_pakar, a.kode_agent, a.nama_agent, k.kode_kriteria, k.kategori, k.pertanyaan
    FROM tb_aturan r
    JOIN tb_agent a ON r.kode_agent = a.kode_agent
    JOIN tb_kriteria k ON r.kode_kriteria = k.kode_kriteria
    ORDER BY a.kode_agent ASC, k.kode_kriteria ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Aturan CF | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-valo p-4">
                <h5 class="fw-bold text-danger mb-3">Tambah Aturan Pakar</h5>
                <form method="POST">
                    <div class="mb-2">
                        <label class="form-label small">Pilih Agent (Hipotesis / THEN)</label>
                        <select name="kode_agent" class="form-select form-select-valo form-select-sm" required>
                            <?php while ($a = mysqli_fetch_assoc($list_agent)): ?>
                                <option value="<?= $a['kode_agent'] ?>">[<?= $a['kode_agent'] ?>] <?= $a['nama_agent'] ?> (<?= $a['role_agent'] ?>)</option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Pilih Kriteria (Evidence / IF)</label>
                        <select name="kode_kriteria" class="form-select form-select-valo form-select-sm" required>
                            <?php while ($k = mysqli_fetch_assoc($list_kriteria)): ?>
                                <option value="<?= $k['kode_kriteria'] ?>">[<?= $k['kode_kriteria'] ?> - <?= $k['kategori'] ?>] <?= htmlspecialchars($k['pertanyaan']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Bobot CF Pakar (0.10 - 1.00)</label>
                        <input type="number" step="0.05" min="0.1" max="1.0" value="0.85" name="cf_pakar" class="form-control form-control-valo form-control-sm" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="tambah" class="btn btn-valo btn-sm">Simpan Aturan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-valo p-4">
                <h5 class="fw-bold mb-3">Basis Pengetahuan (IF-THEN & Bobot CF)</h5>
                <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="text-secondary">
                                <th>Agent</th>
                                <th>Kriteria (Evidence)</th>
                                <th>CF Pakar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($r = mysqli_fetch_assoc($aturan)): ?>
                                <tr>
                                    <td class="fw-bold text-danger">[<?= $r['kode_agent'] ?>] <?= htmlspecialchars($r['nama_agent']) ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $r['kode_kriteria'] ?></span>
                                        <?= htmlspecialchars($r['pertanyaan']) ?>
                                    </td>
                                    <td><span class="badge bg-info text-dark fw-bold"><?= $r['cf_pakar'] ?></span></td>
                                    <td>
                                        <a href="?hapus=<?= $r['id_aturan'] ?>" onclick="return confirm('Hapus aturan ini?')" class="btn btn-outline-danger btn-sm">Hapus</a>
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