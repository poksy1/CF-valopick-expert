<?php
include 'auth.php';
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $kode  = mysqli_real_escape_string($conn, strtoupper(trim($_POST['kode_agent'])));
    $nama  = mysqli_real_escape_string($conn, trim($_POST['nama_agent']));
    $role  = mysqli_real_escape_string($conn, $_POST['role_agent']);
    $desk  = mysqli_real_escape_string($conn, trim($_POST['deskripsi_singkat']));
    $atk   = mysqli_real_escape_string($conn, trim($_POST['strategi_attack']));
    $def   = mysqli_real_escape_string($conn, trim($_POST['strategi_defense']));

    mysqli_query($conn, "INSERT INTO tb_agent (kode_agent, nama_agent, role_agent, deskripsi_singkat, strategi_attack, strategi_defense) 
                         VALUES ('$kode', '$nama', '$role', '$desk', '$atk', '$def')");
    header("Location: kelola_agent.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $kode = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM tb_agent WHERE kode_agent = '$kode'");
    header("Location: kelola_agent.php");
    exit;
}

$agents = mysqli_query($conn, "SELECT * FROM tb_agent ORDER BY kode_agent ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Agent | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-valo p-4">
                <h5 class="fw-bold text-danger mb-3">Tambah Agent Baru</h5>
                <form method="POST">
                    <div class="mb-2">
                        <label class="form-label small">Kode Agent (Misal: A28)</label>
                        <input type="text" name="kode_agent" class="form-control form-control-valo form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Nama Agent</label>
                        <input type="text" name="nama_agent" class="form-control form-control-valo form-control-sm" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Role</label>
                        <select name="role_agent" class="form-select form-select-valo form-select-sm" required>
                            <option value="Duelist">Duelist</option>
                            <option value="Initiator">Initiator</option>
                            <option value="Controller">Controller</option>
                            <option value="Sentinel">Sentinel</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Deskripsi Singkat</label>
                        <textarea name="deskripsi_singkat" rows="2" class="form-control form-control-valo form-control-sm" required></textarea>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Strategi Attack</label>
                        <textarea name="strategi_attack" rows="2" class="form-control form-control-valo form-control-sm" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Strategi Defense</label>
                        <textarea name="strategi_defense" rows="2" class="form-control form-control-valo form-control-sm" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="tambah" class="btn btn-valo btn-sm">Simpan Agent</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-valo p-4">
                <h5 class="fw-bold mb-3">Daftar Agent Terdaftar</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 small">
                        <thead>
                            <tr class="text-secondary">
                                <th>Kode</th>
                                <th>Nama Agent</th>
                                <th>Role</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($a = mysqli_fetch_assoc($agents)): ?>
                                <tr>
                                    <td><span class="badge bg-secondary"><?= $a['kode_agent'] ?></span></td>
                                    <td class="fw-bold"><?= htmlspecialchars($a['nama_agent']) ?></td>
                                    <td><span class="badge badge-role"><?= $a['role_agent'] ?></span></td>
                                    <td><?= htmlspecialchars($a['deskripsi_singkat']) ?></td>
                                    <td>
                                        <a href="?hapus=<?= $a['kode_agent'] ?>" onclick="return confirm('Hapus agent beserta aturannya?')" class="btn btn-outline-danger btn-sm">Hapus</a>
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