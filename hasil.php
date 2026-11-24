<?php
session_start();
include 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemain  = htmlspecialchars(trim($_POST['nama_pemain'] ?? 'Player'));
    $map_terpilih =$_POST['map_terpilih'] ?? '';
    $input_user   =$_POST['kriteria'] ?? [];

    if (!empty($map_terpilih)) {
        $input_user[$map_terpilih] = 1.0;
    }

    $kriteria_aktif = array_filter($input_user, function($val) {
        return floatval($val) > 0;
    });

    $nama_map = "-";
    if (!empty($map_terpilih)) {
        $q_map = mysqli_query($conn, "SELECT pertanyaan FROM tb_kriteria WHERE kode_kriteria = '" . mysqli_real_escape_string($conn,$map_terpilih) . "'");
        if ($r_map = mysqli_fetch_assoc($q_map)) {
            $nama_map =$r_map['pertanyaan'];
        }
    }

    $query_agent = mysqli_query($conn, "SELECT * FROM tb_agent");
    $hasil_rekomendasi = [];

    while ($agent = mysqli_fetch_assoc($query_agent)) {$kode_agent = $agent['kode_agent'];$cf_combine = 0.0;
        $is_first = true;
        $aturan_terpenuhi = [];

        $query_aturan = mysqli_query($conn, "
            SELECT a.kode_kriteria, a.cf_pakar, k.kategori, k.pertanyaan 
            FROM tb_aturan a
            JOIN tb_kriteria k ON a.kode_kriteria = k.kode_kriteria
            WHERE a.kode_agent = '$kode_agent'
        ");

        while ($aturan = mysqli_fetch_assoc($query_aturan)) {
            $kode_k =$aturan['kode_kriteria'];

            if (isset($kriteria_aktif[$kode_k])) {
                $cf_user  = floatval($kriteria_aktif[$kode_k]);$cf_pakar = floatval($aturan['cf_pakar']);$cf_tunggal = $cf_pakar * $cf_user;

                if ($is_first) {
                    $cf_combine =$cf_tunggal;
                    $is_first = false;
                } else {
                    $cf_combine =$cf_combine + ($cf_tunggal * (1 -$cf_combine));
                }

                $aturan_terpenuhi[] = [
                    'kode'          => $kode_k,
                    'kategori'      => $aturan['kategori'],
                    'pertanyaan'    => $aturan['pertanyaan'],
                    'cf_pakar'      => $cf_pakar,
                    'cf_user'       => $cf_user,
                    'cf_kontribusi' => round($cf_tunggal * 100, 1)
                ];
            }
        }

        if ($cf_combine > 0) {$hasil_rekomendasi[] = [
                'kode_agent'       => $kode_agent,
                'nama_agent'       => $agent['nama_agent'],
                'role_agent'       => $agent['role_agent'],
                'deskripsi'        => $agent['deskripsi_singkat'],
                'strategi_attack'  => $agent['strategi_attack'],
                'strategi_defense' => $agent['strategi_defense'],
                'persentase'       => round($cf_combine * 100, 2), 'jejak_aturan'     =>$aturan_terpenuhi
            ];
        }
    }

    usort($hasil_rekomendasi, function($a,$b) {
        return $b['persentase'] <=>$a['persentase'];
    });

    // Simpan 1x ke tb_riwayat
    if (!empty($hasil_rekomendasi)) {$top = $hasil_rekomendasi[0];$nama_safe  = mysqli_real_escape_string($conn,$nama_pemain);
        $agent_safe = mysqli_real_escape_string($conn, $top['nama_agent']);$json_input = mysqli_real_escape_string($conn, json_encode($kriteria_aktif));

        mysqli_query($conn, "
            INSERT INTO tb_riwayat (nama_pemain, agent_terpilih, nilai_cf, detail_input)
            VALUES ('$nama_safe', '$agent_safe', '{$top['persentase']}', '$json_input')
        ");
    }

    // Simpan ke Session lalu Redirect (mencegah insert dobel saat refresh)
    $_SESSION['hasil_terakhir'] = [
        'nama_pemain'       => $nama_pemain,
        'nama_map'          => $nama_map,
        'hasil_rekomendasi' => $hasil_rekomendasi
    ];

    header("Location: hasil.php");
    exit;
}

// Ambil hasil dari Session (mode GET)
if (!isset($_SESSION['hasil_terakhir'])) {
    header("Location: konsultasi.php");
    exit;
}

$nama_pemain       =$_SESSION['hasil_terakhir']['nama_pemain'];
$nama_map          =$_SESSION['hasil_terakhir']['nama_map'];
$hasil_rekomendasi =$_SESSION['hasil_terakhir']['hasil_rekomendasi'];
$top3              = array_slice($hasil_rekomendasi, 0, 3);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Rekomendasi | VALO-EXPERT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-valo py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold font-display fs-4" href="index.php">
            <span style="color: #ff4655;"></span> VALO-EXPERT
        </a>
        <div class="d-flex gap-2">
            <a href="konsultasi.php" class="btn btn-outline-light btn-sm px-3">Konsultasi Ulang</a>
            <a href="index.php" class="btn btn-outline-secondary btn-sm px-3">Beranda</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <!-- HERO MAP BANNER -->
    <!-- HERO MAP BANNER -->
    <div id="heroMapBanner" class="map-hero-banner mb-5" data-map-name="<?= htmlspecialchars($nama_map) ?>">
        <div class="map-hero-overlay py-3 px-4 py-md-4 px-md-5 d-flex flex-wrap justify-content-between align-items-center gap-4">
            <!-- Sisi Kiri: Judul, Info, dan 2 Tombol Sejajar -->
            <div>
                <span class="badge bg-danger mb-2 px-3 py-1">CERTAINTY FACTOR ANALYSIS COMPLETE</span>
                <h1 class="display-5 fw-bold text-uppercase mb-1">HASIL REKOMENDASI AGENT</h1>
                <p class="mb-4 fs-5">
                    Pemain: <strong class="text-white"><?= $nama_pemain ?></strong>
                    <span class="mx-2 text-danger"></span>
                    Map: <strong class="text-danger text-uppercase"><?= htmlspecialchars($nama_map) ?></strong>
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button type="button" class="btn-valo-outline" data-bs-toggle="modal" data-bs-target="#tacticalBoardModal">
                        🔍 Buka Tactical Board
                    </button>
                    <button type="button" onclick="window.print()" class="btn-valo">
                        Cetak Laporan (PDF)
                    </button>
                </div>
            </div>

            <!-- Sisi Kanan: Minimap Diperbesar -->
            <div class="text-center ms-md-auto">
                <img id="heroMinimapImg" alt="Tactical Minimap"
                     data-bs-toggle="modal" data-bs-target="#tacticalBoardModal"
                     title="Klik untuk memperbesar & memetakan Agent"
                     style="height: 240px; width: auto; max-width: 100%; display: none; cursor: pointer; filter: drop-shadow(0 0 16px rgba(0, 229, 255, 0.55)); transition: transform 0.25s ease;"
                     onmouseover="this.style.transform='scale(1.06)'"
                     onmouseout="this.style.transform='scale(1)'">
            </div>
        </div>
    </div>

    <?php if (empty($top3)): ?>
        <div class="alert alert-warning">Tidak ada kriteria yang cocok. Silakan ulangi konsultasi.</div>
    <?php else: ?>
        <!-- TOP 3 AGENT PORTRAIT CARDS -->
        <div class="row g-4 mb-5">
            <?php foreach ($top3 as $index => $item): ?>
                <div class="col-lg-4">
                    <div class="card card-valo agent-card h-100 <?= $index === 0 ? 'card-top-1' : '' ?>">
                        <!-- Visual Portrait Agent -->
                        <div class="agent-visual-box">
                            <span class="agent-watermark"><?= htmlspecialchars($item['nama_agent']) ?></span>
                            <div class="position-absolute top-0 start-0 p-3 z-3 d-flex justify-content-between w-100">
                                <span class="badge <?= $index === 0 ? 'bg-danger' : 'bg-dark border border-secondary' ?> px-3 py-2 font-display">
                                    <?= $index === 0 ? '★ REKOMENDASI #1' : 'PERINGKAT #' . ($index + 1) ?>
                                </span>
                                <span class="badge badge-role px-2 py-2"><?= $item['role_agent'] ?></span>
                            </div>
                            <img alt="<?= htmlspecialchars($item['nama_agent']) ?>"
                                class="agent-portrait js-agent-img"
                                style="display: none;"
                                data-agent-name="<?= htmlspecialchars($item['nama_agent']) ?>">
                        </div>

                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-baseline mb-1">
                                <h2 class="fw-bold text-uppercase mb-0"><?= htmlspecialchars($item['nama_agent']) ?></h2>
                                <span class="fs-4 fw-bold text-danger font-display"><?= $item['persentase'] ?>%</span>
                            </div>
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-valo" style="width: <?= $item['persentase'] ?>%"></div>
                            </div>
                            <p class="small text-secondary mb-3"><?= htmlspecialchars($item['deskripsi']) ?></p>

                            <!-- Strategi Attack & Defense -->
                            <div class="bg-dark bg-opacity-75 border border-secondary border-opacity-25 p-3 mb-3 small">
                                <div class="mb-2">
                                    <strong class="text-danger text-uppercase font-display d-block">⚔ Strategi Attack</strong>
                                    <?= htmlspecialchars($item['strategi_attack']) ?>
                                </div>
                                <hr class="border-secondary opacity-25 my-2">
                                <div>
                                    <strong class="text-info text-uppercase font-display d-block">🛡 Strategi Defense</strong>
                                    <?= htmlspecialchars($item['strategi_defense']) ?>
                                </div>
                            </div>

                            <!-- Accordion Jejak Aturan (Agar Kartu Rapi & Tidak Kepanjangan) -->
                            <div class="accordion accordion-valo mt-auto" id="accRule<?= $index ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>">
                                            Jejak Aturan Terpenuhi (<?= count($item['jejak_aturan']) ?> Kriteria)
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#accRule<?= $index ?>">
                                        <div class="accordion-body p-2">
                                            <ul class="list-unstyled small mb-0">
                                                <?php foreach ($item['jejak_aturan'] as $rule): ?>
                                                    <li class="mb-2 border-start border-danger ps-2">
                                                        <span class="text-light d-block"><?= htmlspecialchars($rule['pertanyaan']) ?></span>
                                                        <span class="text-secondary" style="font-size: 0.78rem;">
                                                            CF Pakar: <?= $rule['cf_pakar'] ?> &times; CF User: <?= $rule['cf_user'] ?> = <strong class="text-danger"><?= $rule['cf_kontribusi'] ?>%</strong>
                                                        </span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- TABEL PERINGKAT SELURUH AGENT -->
        <div class="card card-valo p-4">
            <h4 class="fw-bold text-uppercase mb-3">Peringkat Lengkap Semua Kandidat Agent</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-secondary text-uppercase small">
                            <th>Rank</th>
                            <th>Agent</th>
                            <th>Role</th>
                            <th>Kriteria Cocok</th>
                            <th>Skor CF Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hasil_rekomendasi as $idx => $ag): ?>
                            <tr>
                                <td class="font-display fw-bold">#<?= $idx + 1 ?></td>
                                <td class="fw-bold fs-5 font-display"><?= htmlspecialchars($ag['nama_agent']) ?></td>
                                <td><span class="badge badge-role"><?= $ag['role_agent'] ?></span></td>
                                <td><?= count($ag['jejak_aturan']) ?> aturan terpenuhi</td>
                                <td class="fw-bold text-danger font-display fs-5"><?= $ag['persentase'] ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- MODAL TACTICAL BOARD (PERBESAR MINIMAP & PEMETAAN AGENT) -->
<div class="modal fade modal-valo" id="tacticalBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom border-secondary border-opacity-25">
                <div>
                    <h4 class="modal-title fw-bold text-uppercase mb-0">
                        <span class="text-danger"></span> TACTICAL BOARD — <?= htmlspecialchars($nama_map) ?>
                    </h4>
                    <small class="text-secondary">Pilih Agent di kanan &rarr; Klik pada Minimap untuk menaruh posisi. Geser pin untuk memindahkan, klik kanan untuk hapus.</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 align-items-start">
                    <!-- Area Minimap Diperbesar -->
                    <div class="col-lg-8 text-center">
                        <div id="tacticalCanvas" class="tactical-canvas">
                            <img id="boardMapImg" alt="Enlarged Minimap" class="board-map-img" style="display: none;">
                            <div id="boardMapFallback" class="p-5 text-secondary" style="display: none;">
                                <h5 class="text-danger text-uppercase mb-1">Minimap Belum Tersedia</h5>
                                <small>Tambahkan file lokal di <code>assets/img/maps/</code> atau pilih map standar (Ascent, Sunset, Bind, dll).</small>
                            </div>
                        </div>
                    </div>

                    <!-- Panel Pilih Agent -->
                    <div class="col-lg-4">
                        <h6 class="text-danger fw-bold text-uppercase mb-2">1. Pilih Agent untuk Dipetakan</h6>
                        <div class="d-flex flex-column gap-2 mb-3">
                            <?php foreach ($top3 as $idx => $item): ?>
                                <button type="button" class="agent-picker-btn <?= $idx === 0 ? 'active' : '' ?>"
                                        data-agent-name="<?= htmlspecialchars($item['nama_agent']) ?>">
                                    <img src="" class="js-picker-icon" data-agent-name="<?= htmlspecialchars($item['nama_agent']) ?>" alt="">
                                    <div>
                                        <div class="fw-bold font-display lh-1"><?= htmlspecialchars($item['nama_agent']) ?></div>
                                        <small class="text-secondary" style="font-size: 0.75rem;">
                                            Rank #<?= $idx + 1 ?> &bull; <?= $item['role_agent'] ?> (<?= $item['persentase'] ?>%)
                                        </small>
                                    </div>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <h6 class="text-info fw-bold text-uppercase mb-2">2. Tambah Rekan Tim Lain (Opsional)</h6>
                        <select id="extraAgentSelect" class="form-select form-select-valo form-select-sm mb-3">
                            <option value="">-- Pilih Agent Lain dari Roster --</option>
                            <?php foreach ($hasil_rekomendasi as $ag): ?>
                                <option value="<?= htmlspecialchars($ag['nama_agent']) ?>">
                                    <?= htmlspecialchars($ag['nama_agent']) ?> (<?= $ag['role_agent'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <h6 class="text-warning fw-bold text-uppercase mb-2">3. Mode Pin (Agent / Ability)</h6>
                            <div id="abilityPickerBox" class="ability-picker-grid mb-3">
                                <!-- Diisi otomatis via JavaScript sesuai Agent yang dipilih -->
                            </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="button" id="btnClearBoard" class="btn btn-outline-danger btn-sm">
                                Bersihkan Semua Pin di Map
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/valo-assets.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    await ValoAssets.init();

    const heroBanner       = document.getElementById('heroMapBanner');
    const heroMinimap      = document.getElementById('heroMinimapImg');
    const boardMapImg      = document.getElementById('boardMapImg');
    const boardMapFallback = document.getElementById('boardMapFallback');
    const tacticalCanvas   = document.getElementById('tacticalCanvas');
    const pickerButtons    = document.querySelectorAll('.agent-picker-btn');
    const extraAgentSelect = document.getElementById('extraAgentSelect');
    const btnClearBoard    = document.getElementById('btnClearBoard');

    // 1. Load Banner & Minimap
    if (heroBanner) {
        const mapName = heroBanner.getAttribute('data-map-name');
        heroBanner.style.backgroundImage = `url('${ValoAssets.getMapImage(mapName)}')`;

        const minimapUrl = ValoAssets.getMapMinimap(mapName);

        if (heroMinimap) {
            heroMinimap.onload  = () => { heroMinimap.style.display = 'block'; };
            heroMinimap.onerror = () => { heroMinimap.style.display = 'none'; };
            heroMinimap.src     = minimapUrl;
        }

        if (boardMapImg) {
            boardMapImg.onload = () => {
                boardMapImg.style.display = 'block';
                if (boardMapFallback) boardMapFallback.style.display = 'none';
            };
            boardMapImg.onerror = () => {
                boardMapImg.style.display = 'none';
                if (boardMapFallback) boardMapFallback.style.display = 'block';
            };
            boardMapImg.src = minimapUrl;
        }
    }

    // 2. Load Portrait Agent Top 3
    document.querySelectorAll('.js-agent-img').forEach(img => {
        const agentName = img.getAttribute('data-agent-name');
        img.onload  = () => { img.style.display = 'block'; };
        img.onerror = () => { img.style.display = 'none'; };
        img.src     = ValoAssets.getAgentImage(agentName);
    });

    // 3. Load Ikon Agent di Sidebar Tactical Board
    document.querySelectorAll('.js-picker-icon').forEach(img => {
        const agentName = img.getAttribute('data-agent-name');
        img.onerror = () => { img.style.visibility = 'hidden'; };
        img.src     = ValoAssets.getAgentIcon(agentName);
    });

    // 4. Logika Tactical Board (Posisi Agent + 4 Ability Pin, Drag & Drop)
    const abilityPickerBox = document.getElementById('abilityPickerBox');

    let selectedAgent   = pickerButtons.length ? pickerButtons[0].getAttribute('data-agent-name') : '';
    let selectedPinMode = 'agent'; // 'agent' atau 'ability'
    let selectedAbility = null;    // { name, icon }

    function renderAbilityPicker(agentName) {
        if (!abilityPickerBox || !agentName) return;

        selectedPinMode = 'agent';
        selectedAbility = null;

        const abilities = ValoAssets.getAgentAbilities(agentName);
        const agentIcon = ValoAssets.getAgentIcon(agentName);

        // Tombol default: Posisi Agent
        let html = `
            <button type="button" class="ability-btn active" style="grid-column: span 2;" data-mode="agent">
                <img src="${agentIcon}" alt="${agentName}" style="border-radius: 50%;">
                <span><strong>Posisi Agent:</strong> ${agentName}</span>
            </button>
        `;

        if (abilities.length > 0) {
            abilities.forEach((ab, idx) => {
                html += `
                    <button type="button" class="ability-btn" data-mode="ability" data-ab-idx="${idx}" title="${ab.name}">
                        <img src="${ab.icon}" alt="${ab.name}">
                        <span>${ab.name}</span>
                    </button>
                `;
            });
        } else {
            html += `<small class="text-secondary" style="grid-column: span 2; font-size: 0.75rem;">Ikon ability tidak tersedia untuk agent ini.</small>`;
        }

        abilityPickerBox.innerHTML = html;

        // Event klik tombol mode pin
        abilityPickerBox.querySelectorAll('.ability-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                abilityPickerBox.querySelectorAll('.ability-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const mode = btn.getAttribute('data-mode');
                if (mode === 'agent') {
                    selectedPinMode = 'agent';
                    selectedAbility = null;
                } else {
                    const idx = parseInt(btn.getAttribute('data-ab-idx'), 10);
                    selectedPinMode = 'ability';
                    selectedAbility = abilities[idx];
                }
            });
        });
    }

    // Inisialisasi ability untuk Agent #1 saat halaman dibuka
    if (selectedAgent) {
        renderAbilityPicker(selectedAgent);
    }

    pickerButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            pickerButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            if (extraAgentSelect) extraAgentSelect.value = '';
            selectedAgent = btn.getAttribute('data-agent-name');
            renderAbilityPicker(selectedAgent);
        });
    });

    if (extraAgentSelect) {
        extraAgentSelect.addEventListener('change', function() {
            if (this.value) {
                pickerButtons.forEach(b => b.classList.remove('active'));
                selectedAgent = this.value;
                renderAbilityPicker(selectedAgent);
            }
        });
    }

    if (tacticalCanvas) {
        tacticalCanvas.addEventListener('click', (e) => {
            if (!selectedAgent || e.target.closest('.agent-map-pin') || e.target.closest('.ability-map-pin')) return;

            const rect = tacticalCanvas.getBoundingClientRect();
            const xPct = ((e.clientX - rect.left) / rect.width) * 100;
            const yPct = ((e.clientY - rect.top) / rect.height) * 100;

            if (selectedPinMode === 'ability' && selectedAbility) {
                createPin('ability', selectedAbility.name, selectedAbility.icon, xPct, yPct);
            } else {
                createPin('agent', selectedAgent, ValoAssets.getAgentIcon(selectedAgent), xPct, yPct);
            }
        });
    }

    function createPin(type, label, iconUrl, xPct, yPct) {
        const pin = document.createElement('div');
        pin.className = type === 'ability' ? 'ability-map-pin' : 'agent-map-pin';
        pin.style.left = xPct + '%';
        pin.style.top  = yPct + '%';
        pin.title = `${label} (Geser untuk pindah, klik kanan untuk hapus)`;
        pin.innerHTML = `
            <img src="${iconUrl}" alt="${label}">
            <span class="pin-label">${label}</span>
        `;

        pin.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            pin.remove();
        });

        let isDragging = false;
        pin.addEventListener('pointerdown', (e) => {
            if (e.button !== 0) return;
            isDragging = true;
            pin.setPointerCapture(e.pointerId);
            e.stopPropagation();
        });

        pin.addEventListener('pointermove', (e) => {
            if (!isDragging) return;
            const rect = tacticalCanvas.getBoundingClientRect();
            const nx = Math.max(2, Math.min(98, ((e.clientX - rect.left) / rect.width) * 100));
            const ny = Math.max(2, Math.min(98, ((e.clientY - rect.top) / rect.height) * 100));
            pin.style.left = nx + '%';
            pin.style.top  = ny + '%';
        });

        pin.addEventListener('pointerup', (e) => {
            isDragging = false;
            pin.releasePointerCapture(e.pointerId);
        });

        tacticalCanvas.appendChild(pin);
    }

    if (btnClearBoard) {
        btnClearBoard.addEventListener('click', () => {
            tacticalCanvas.querySelectorAll('.agent-map-pin, .ability-map-pin').forEach(p => p.remove());
        });
    }
});
</script>
</body>
</html>