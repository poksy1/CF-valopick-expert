<?php $page = basename($_SERVER['PHP_SELF']); ?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-valo py-3 sticky-top">
    <div class="container">
        <a class="navbar-brand navbar-brand-hud" href="dashboard.php">
            <span style="color: #ff4655;"></span> ADMIN VALO-EXPERT
        </a>
        <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navAdmin">
            <div class="navbar-nav ms-auto align-items-lg-center gap-2 mt-3 mt-lg-0">
                <a class="nav-link nav-link-hud <?= $page === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
                <a class="nav-link nav-link-hud <?= $page === 'kelola_agent.php' ? 'active' : '' ?>" href="kelola_agent.php">Data Agent</a>
                <a class="nav-link nav-link-hud <?= $page === 'kelola_kriteria.php' ? 'active' : '' ?>" href="kelola_kriteria.php">Data Kriteria</a>
                <a class="nav-link nav-link-hud <?= $page === 'kelola_aturan.php' ? 'active' : '' ?>" href="kelola_aturan.php">Aturan (CF)</a>
                <a href="logout.php" class="btn-logout-hud ms-lg-3">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </div>
</nav>