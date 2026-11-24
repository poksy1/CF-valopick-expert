<?php
include 'config/koneksi.php';

$riwayat      = mysqli_query($conn, "SELECT * FROM tb_riwayat ORDER BY tanggal DESC LIMIT 6");
$jml_agent    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_agent"))['total'];
$jml_map      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_kriteria WHERE kategori = 'Map'"))['total'];
$jml_aturan   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_aturan"))['total'];
$jml_riwayat  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_riwayat"))['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VALO-EXPERT | Sistem Pakar Pemilihan Agent Valorant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-valo py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand navbar-brand-hud" href="index.php">
            <span style="color: #ff4655;">//</span> VALO-EXPERT
        </a>
        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto ms-lg-4 gap-1">
                <li class="nav-item">
                    <a class="nav-link nav-link-hud active" href="index.php">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-hud" href="konsultasi.php">Mulai Analisis</a>
                </li>
            </ul>
            <div class="d-flex mt-2 mt-lg-0">
                <a href="admin/login.php" class="btn-admin-hud">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                    </svg>
                    Panel Admin
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <!-- HERO SECTION -->
    <div class="row align-items-center g-5 py-3">
        <div class="col-lg-7">
            <div class="d-inline-flex align-items-center gap-2 mb-3">
                <span class="badge badge-role px-3 py-2">FORWARD CHAINING + CERTAINTY FACTOR</span>
                <span class="badge bg-dark border border-secondary text-secondary px-2 py-2">v2.0 TACTICAL HUD</span>
            </div>

            <h1 class="display-4 fw-bold text-uppercase mb-3 lh-sm">
                Tentukan <span style="color: #ff4655;">Agent Terbaik</span> Sesuai Kondisi Lobby &amp; Party
            </h1>
            <p class="lead text-secondary mb-4">
                Sistem pakar berbasis aturan untuk menganalisis kecocokan Map, kekosongan Role tim, gaya bermain individu, hingga kompensasi rekan <em>One-Trick Pony (OTP)</em> dalam pertandingan kompetitif Valorant.
            </p>

            <div class="d-flex flex-wrap gap-3 mb-5">
                <a href="konsultasi.php" class="btn btn-valo">Mulai Konsultasi Sekarang &rarr;</a>
                <a href="#riwayat-section" class="btn-valo-outline text-decoration-none">Lihat Riwayat</a>
            </div>

            <!-- Live Knowledge Base Stats -->
            <div class="row g-3">
                <div class="col-6 col-sm-3">
                    <div class="stat-hud-box">
                        <div class="font-display fs-3 fw-bold text-danger lh-1"><?= $jml_agent ?></div>
                        <small class="text-secondary text-uppercase" style="font-size: 0.75rem;">Total Agent</small>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="stat-hud-box">
                        <div class="font-display fs-3 fw-bold text-light lh-1"><?= $jml_map ?></div>
                        <small class="text-secondary text-uppercase" style="font-size: 0.75rem;">Map Kompetitif</small>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="stat-hud-box">
                        <div class="font-display fs-3 fw-bold text-info lh-1"><?= $jml_aturan ?></div>
                        <small class="text-secondary text-uppercase" style="font-size: 0.75rem;">Basis Aturan</small>
                    </div>
                </div>
                <div class="col-6 col-sm-3">
                    <div class="stat-hud-box">
                        <div class="font-display fs-3 fw-bold text-success lh-1"><?= $jml_riwayat ?></div>
                        <small class="text-secondary text-uppercase" style="font-size: 0.75rem;">Konsultasi</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parameter Analisis Sistem -->
        <div class="col-lg-5">
            <div class="card card-valo p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                    <h4 class="fw-bold text-uppercase mb-0">Parameter Analisis Sistem</h4>
                    <span class="badge bg-danger">4 MODUL</span>
                </div>

                <div class="param-item">
                    <span class="param-num">01</span>
                    <div>
                        <strong class="d-block text-light">Karakteristik <?= $jml_map ?> Map Kompetitif</strong>
                        <small class="text-secondary">Mencocokkan struktur site, lorong, dan jarak tembak map.</small>
                    </div>
                </div>
                <div class="param-item">
                    <span class="param-num">02</span>
                    <div>
                        <strong class="d-block text-light">Evaluasi Kekosongan 4 Role Tim</strong>
                        <small class="text-secondary">Menutup celah Duelist, Initiator, Controller, atau Sentinel.</small>
                    </div>
                </div>
                <div class="param-item">
                    <span class="param-num">03</span>
                    <div>
                        <strong class="d-block text-light">Penyesuaian Gaya Bermain</strong>
                        <small class="text-secondary">Adaptasi preferensi Agresif, Support Utility, atau Lurker.</small>
                    </div>
                </div>
                <div class="param-item">
                    <span class="param-num">04</span>
                    <div>
                        <strong class="d-block text-light">Kompensasi Party OTP &amp; Tactical Board</strong>
                        <small class="text-secondary">Sinergi dengan rekan satu party plus pemetaan posisi minimap.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIWAYAT KONSULTASI TERAKHIR -->
    <div id="riwayat-section" class="card card-valo p-4 mt-5">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div>
                <h4 class="fw-bold text-uppercase mb-0">Riwayat Konsultasi Terakhir</h4>
                <small class="text-secondary">Menampilkan 6 hasil analisis terbaru dari pemain</small>
            </div>
            <a href="konsultasi.php" class="btn btn-sm btn-outline-danger text-uppercase font-display px-3">+ Analisis Baru</a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr class="text-secondary text-uppercase small">
                        <th>Nama Pemain</th>
                        <th>Rekomendasi Utama</th>
                        <th>Tingkat Kecocokan</th>
                        <th>Waktu Analisis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($riwayat) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($riwayat)): ?>
                            <tr>
                                <td class="fw-semibold"><?= htmlspecialchars($row['nama_pemain']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="history-agent-icon js-history-icon"
                                             data-agent-name="<?= htmlspecialchars($row['agent_terpilih']) ?>"
                                             alt="" style="display: none;">
                                        <span class="fw-bold text-danger font-display fs-5 text-uppercase">
                                            <?= htmlspecialchars($row['agent_terpilih']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-danger px-2 py-1 font-display fs-6"><?= $row['nilai_cf'] ?>%</span>
                                </td>
                                <td class="text-secondary small"><?= $row['tanggal'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">Belum ada riwayat konsultasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/valo-assets.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    await ValoAssets.init();
    document.querySelectorAll('.js-history-icon').forEach(img => {
        const agentName = img.getAttribute('data-agent-name');
        img.onload  = () => { img.style.display = 'inline-block'; };
        img.onerror = () => { img.style.display = 'none'; };
        img.src     = ValoAssets.getAgentIcon(agentName);
    });
});
</script>
</body>
</html>