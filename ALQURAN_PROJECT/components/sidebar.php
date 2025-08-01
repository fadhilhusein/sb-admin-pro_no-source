<?php include __DIR__ . '/../API/get_all_surat.php' ?>

<div class="nav accordion" id="accordionSidenav">
    <!-- Sidenav Menu Heading (Account)-->
    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
    <div class="sidenav-menu-heading d-sm-none">Account</div>
    <!-- Sidenav Link (Alerts)-->
    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
    <a class="nav-link d-sm-none" href="#!">
        <div class="nav-link-icon"><i data-feather="bell"></i></div>
        Alerts
        <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
    </a>
    <!-- Sidenav Link (Messages)-->
    <!-- * * Note: * * Visible only on and above the sm breakpoint-->
    <a class="nav-link d-sm-none" href="#!">
        <div class="nav-link-icon"><i data-feather="mail"></i></div>
        Messages
        <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
    </a>
    <!-- Sidenav Menu Heading (Core)-->
    <div class="sidenav-menu-heading">AL-QUR'AN ONLINE</div>
    <!-- Sidenav Accordion (Dashboard)-->
    <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
        <div class="nav-link-icon"><i data-feather="book-open"></i></div>
        Al-Qur'an
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav accordion gap-2" id="accordionSidenavPages">
            <?php 
            foreach ($data_objek['data'] as $surat):
            ?>
            <a class="nav-link flex-column align-items-start gap-3 border border-1 mx-2 bg-success bg-opacity-10" href="surat.php?nomor=<?= $surat['nomor'] ?>">
                (<?= $surat['nomor'] ?>) <?= $surat['namaLatin'] ?>
                <span class="badge bg-primary-soft text-primary"><?= $surat['tempatTurun'] ?></span>
            </a>
            <?php 
            endforeach;
            ?>
        </nav>
    </div>
</div>