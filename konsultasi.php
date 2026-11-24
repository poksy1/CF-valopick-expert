<?php
include 'config/koneksi.php';

$maps = mysqli_query($conn, "SELECT * FROM tb_kriteria WHERE kategori = 'Map' ORDER BY kode_kriteria ASC");
$tim  = mysqli_query($conn, "SELECT * FROM tb_kriteria WHERE kategori = 'Kebutuhan Tim' ORDER BY kode_kriteria ASC");
$gaya = mysqli_query($conn, "SELECT * FROM tb_kriteria WHERE kategori = 'Gaya Bermain' ORDER BY kode_kriteria ASC");
$otp  = mysqli_query($conn, "SELECT * FROM tb_kriteria WHERE kategori = 'Kondisi Party / OTP' ORDER BY kode_kriteria ASC");

$opsi_cf = [
    '0.0' => 'Tidak / Bukan Kondisi Ini (0.0)',
    '0.4' => 'Kurang Sesuai / Ragu-ragu (0.4)',
    '0.6' => 'Cukup Sesuai (0.6)',
    '0.8' => 'Sesuai / Yakin (0.8)',
    '1.0' => 'Sangat Sesuai / Mutlak (1.0)'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Agent | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-valo py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold font-display fs-4" href="index.php">
            <span style="color: #ff4655;"></span> VALO-EXPERT
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm px-3">Kembali ke Beranda</a>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <span class="badge badge-role mb-2 px-3 py-1">TACTICAL BRIEFING</span>
                <h1 class="fw-bold text-uppercase mb-1">Form Analisis Lobby</h1>
                <p class="text-secondary">Pilih Map dan tentukan tingkat keyakinanmu pada setiap kondisi tim agar sistem menghitung komposisi paling optimal.</p>
            </div>

            <form action="hasil.php" method="POST">
                <!-- 1. Identitas & Map (Background Fade + Minimap di Kanan) -->
                <div id="cardMapHero" class="card card-valo card-map-hero p-4 mb-4">
                    <h4 class="fw-bold text-danger text-uppercase mb-3">01. Identitas & Pemilihan Map</h4>
                    <div class="row g-4 align-items-center">
                        <!-- Form di Kiri -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nickname / Riot ID</label>
                                <input type="text" name="nama_pemain" class="form-control form-control-valo form-control-lg" placeholder="Contoh: ZeEtz#VAL" required>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Pilih Map Pertandingan</label>
                                <select name="map_terpilih" id="selectMap" class="form-select form-select-valo form-select-lg" required>
                                    <option value="" data-map-name="">-- Pilih Map --</option>
                                    <?php while ($m = mysqli_fetch_assoc($maps)): ?>
                                        <option value="<?= $m['kode_kriteria'] ?>" data-map-name="<?= htmlspecialchars($m['pertanyaan']) ?>">
                                            <?= htmlspecialchars($m['pertanyaan']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Minimap Bersih di Kanan -->
                        <div class="col-md-5">
                            <div class="minimap-stage">
                                <span id="mapBadge" class="badge bg-danger mb-2" style="font-size: 0.72rem; letter-spacing: 1px;">TACTICAL RADAR</span>
                                <img id="mapMinimapImg" src="" alt="Minimap" style="display: none;">
                                <div id="mapEmptyState" class="py-4">
                                    <h5 class="fw-bold text-uppercase text-light mb-1">Belum Memilih Map</h5>
                                    <small class="text-secondary">Radar minimap akan muncul di sini</small>
                                </div>
                                <div id="mapSelectedLabel" class="mt-2" style="display: none;">
                                    <span id="mapPreviewTitle" class="fw-bold text-uppercase font-display fs-5 text-light"></span>
                                    <small class="d-block text-secondary" style="font-size: 0.78rem;">Lokasi Terkonfirmasi (Bobot CF: 1.0)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Kebutuhan Tim -->
                <div class="card card-valo p-4 mb-4">
                    <h4 class="fw-bold text-danger text-uppercase mb-3">02. Kondisi Kekosongan Role Tim</h4>
                    <?php while ($t = mysqli_fetch_assoc($tim)): ?>
                        <div class="row align-items-center kriteria-row">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <span class="badge bg-danger bg-opacity-25 text-danger border border-danger me-2"><?= $t['kode_kriteria'] ?></span>
                                <?= htmlspecialchars($t['pertanyaan']) ?>
                            </div>
                            <div class="col-md-5">
                                <select name="kriteria[<?= $t['kode_kriteria'] ?>]" class="form-select form-select-valo">
                                    <?php foreach ($opsi_cf as $val => $label): ?>
                                        <option value="<?= $val ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- 3. Gaya Bermain -->
                <div class="card card-valo p-4 mb-4">
                    <h4 class="fw-bold text-danger text-uppercase mb-3">03. Gaya Bermain Individu</h4>
                    <?php while ($g = mysqli_fetch_assoc($gaya)): ?>
                        <div class="row align-items-center kriteria-row">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <span class="badge bg-info bg-opacity-25 text-info border border-info me-2"><?= $g['kode_kriteria'] ?></span>
                                <?= htmlspecialchars($g['pertanyaan']) ?>
                            </div>
                            <div class="col-md-5">
                                <select name="kriteria[<?= $g['kode_kriteria'] ?>]" class="form-select form-select-valo">
                                    <?php foreach ($opsi_cf as $val => $label): ?>
                                        <option value="<?= $val ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- 4. Kondisi Party / OTP -->
                <div class="card card-valo p-4 mb-4">
                    <h4 class="fw-bold text-danger text-uppercase mb-3">04. Kondisi Party / One-Trick Pony (OTP)</h4>
                    <?php while ($o = mysqli_fetch_assoc($otp)): ?>
                        <div class="row align-items-center kriteria-row">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <span class="badge bg-warning bg-opacity-25 text-warning border border-warning me-2"><?= $o['kode_kriteria'] ?></span>
                                <?= htmlspecialchars($o['pertanyaan']) ?>
                            </div>
                            <div class="col-md-5">
                                <select name="kriteria[<?= $o['kode_kriteria'] ?>]" class="form-select form-select-valo">
                                    <?php foreach ($opsi_cf as $val => $label): ?>
                                        <option value="<?= $val ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-valo btn-lg py-3">ANALISIS & CARI AGENT TERBAIK &rarr;</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/valo-assets.js"></script>
<script src="assets/js/valo-assets.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    await ValoAssets.init();

    const selectMap     = document.getElementById('selectMap');
    const cardMapHero   = document.getElementById('cardMapHero');
    const minimapImg    = document.getElementById('mapMinimapImg');
    const emptyState    = document.getElementById('mapEmptyState');
    const selectedLabel = document.getElementById('mapSelectedLabel');
    const previewTitle  = document.getElementById('mapPreviewTitle');

    selectMap.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const mapName = selectedOption.getAttribute('data-map-name');

        if (mapName) {
            // Pasang splash map sebagai background fade di kartu form
            cardMapHero.style.backgroundImage = `url('${ValoAssets.getMapImage(mapName)}')`;

            // Tampilkan minimap di sisi kanan
            minimapImg.src = ValoAssets.getMapMinimap(mapName);
            minimapImg.style.display = 'block';
            minimapImg.onerror = () => { minimapImg.style.display = 'none'; };

            previewTitle.textContent = mapName;
            emptyState.style.display = 'none';
            selectedLabel.style.display = 'block';
        } else {
            cardMapHero.style.backgroundImage = 'none';
            minimapImg.style.display = 'none';
            emptyState.style.display = 'block';
            selectedLabel.style.display = 'none';
        }
    });
});
</script>
</body>
</html>