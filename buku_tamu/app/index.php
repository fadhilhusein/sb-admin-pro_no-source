<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../libs/php/auth.php";

// Untuk pengecekan apakah sudah login atau belum? jika belum maka user akan diarahkan ke halaman login
loginState();

// Informasi langganan
$informasiWaktuLangganan = hitungSisaMasaAktif($appConfig['expired_date']);
$tanggalHariIni = formatTanggalIndo();
$listTamuSedangBerkunjung = todayList($_SESSION['app_config']['id']);
$kuotaTerpakai = queryTamu("SELECT kuota_tamu FROM master_program WHERE kode_program ='" . kode_program . "'");
$listTamuHariIni = queryTamu("SELECT COUNT(id) AS total_tamu FROM master_tamu WHERE id_program = '" . $_SESSION['app_config']['id'] . "' AND DATE(tanggal_kunjungan) = '" . date('Y-m-d') . "'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <?php include_once("../components/topbar.php") ?>
    <div id="layoutSidenav">
        <?php include_once("../components/sidebar.php") ?>
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-12 d-flex flex-column justify-content-center align-items-center mt-4">
                                    <h1 class="page-header-title mb-2 text-center">
                                        DIGITAL GUESTBOOK
                                    </h1>
                                    <div class="text-white opacity-75"><?= $appConfig['nama_program'] ?></div>
                                    <div class="text-white opacity-75"><?= $tanggalHariIni ?> - <span id="time-view"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-n10">
                    <div class="row">
                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 2-->
                            <div class="card border-start-lg border-start-primary h-100">
                                <div class="card-body">
                                    <div class="h-100 d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small fw-bold text-primary mb-1">Tamu Sedang Berkunjung</div>
                                            <div class="h5"><?= count($listTamuSedangBerkunjung) ?> Orang</div>
                                            <!-- <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                                    12%
                                                </div> -->
                                        </div>
                                        <div class="ms-2"><i class="fas fa-person-walking-arrow-right fa-2x text-gray-700"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 2-->
                            <div class="card border-start-lg border-start-success h-100">
                                <div class="card-body">
                                    <div class="h-100 d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small fw-bold text-success mb-1">Total tamu hari ini</div>
                                            <div class="h5"><?= $listTamuHariIni['total_tamu'] ?> Orang</div>
                                            <!-- <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                                    12%
                                                </div> -->
                                        </div>
                                        <div class="ms-2"><i class="fas fa-chart-column fa-2x text-gray-700"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 mb-4">
                            <!-- Dashboard example card 2-->
                            <div class="card border-start-lg border-start-secondary h-100">
                                <div class="card-body">
                                    <div class="h-100 d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="small fw-bold text-secondary mb-1">Sisa kuota tamu</div>
                                            <div class="h5"><?= $kuotaTerpakai['kuota_tamu'] ?></div>
                                            <!-- <div class="text-xs fw-bold text-success d-inline-flex align-items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up me-1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                                    12%
                                                </div> -->
                                        </div>
                                        <div class="ms-2"><i class="fas fa-people-group fa-2x text-gray-700"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-<?= $informasiWaktuLangganan["alert"] ?> d-flex align-items-center justify-content-between" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-bell me-2"></i>
                            <div>
                                Sisa hari langganan: <?= $informasiWaktuLangganan['pesan'] ?>
                            </div>
                        </div>
                        <?php if ($informasiWaktuLangganan['alert'] === "warning" || $informasiWaktuLangganan['alert'] === "danger"): ?>
                            <a href="#" class="btn btn-sm btn-<?= $informasiWaktuLangganan["alert"] ?>">Perpanjang Langganan</a>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <!-- Body Content -->
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row row-cols-md-3">
                                        <!-- Menu Item -->
                                        <div class="col mb-3">
                                            <a class="card lift h-100" href="buku_tamu.php">
                                                <div class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="me-4">
                                                        <i class="fas fa-address-book fa-2x" style="color: #B197FC;"></i>
                                                    </div>
                                                    <h1 class="mb-0 text-end">Buku tamu</h1>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col mb-3">
                                            <a class="card lift h-100" href="#">
                                                <div class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="me-4">
                                                        <i class="fas fa-circle-question fa-2x" style="color: #B197FC;"></i>
                                                    </div>
                                                    <h1 class="mb-0 text-end">Coming Soon</h1>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col mb-3">
                                            <a class="card lift h-100" href="#">
                                                <div class="card-body d-flex align-items-center justify-content-between">
                                                    <div class="me-4">
                                                        <i class="fas fa-circle-question fa-2x" style="color: #B197FC;"></i>
                                                    </div>
                                                    <h1 class="mb-0 text-end">Coming Soon</h1>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Tamu hari ini (Sedang berkunjung)</div>
                                <div class="card-body">
                                    <table id="datatablesSimple" class="tabel_tamu">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Asal Instansi</th>
                                                <th>Tujuan</th>
                                                <th>Jam Masuk</th>
                                                <th>Photo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($listTamuSedangBerkunjung):
                                                foreach ($listTamuSedangBerkunjung as $tamu): ?>
                                                    <tr id="<?= $tamu['id'] ?>">
                                                        <td><?= $tamu['nama'] ?></td>
                                                        <td><?= $tamu['asal_instansi'] ?></td>
                                                        <td>Bertemu dengan <?= $tamu['nama_tujuan'] ?> di <?= $tamu['departemen_tujuan'] ?></td>
                                                        <td><?= $tamu['waktu_kunjungan'] ?></td>
                                                        <td><a target="_blank" href="../uploads/<?= $tamu['photo_tamu'] ?>">Photo tamu</a></td>
                                                        <td>
                                                            <button id="<?= $tamu['id'] ?>" class="btn btn-sm btn-danger btn_checkout">Check out</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; <?= copy_right ?></div>
                        <div class="col-md-6 text-md-end small">
                            <a href="#!">Privacy Policy</a>
                            &middot;
                            <a href="#!">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../libs/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-pie-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../libs/js/datatables/datatables-simple-demo.js"></script>
    <script src="../libs/js/dashboard.js"></script>
    <?php if ($informasiWaktuLangganan['alert'] == 'danger') { ?>
        <script>
            if (!sessionStorage.getItem('user_has_read')) {
                Swal.fire({
                    title: "Masa langganan sudah habis!",
                    text: "Perpanjang langganan untuk terus menggunakan aplikasi ini",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ya, saya mengerti"
                }).then((result) => {
                    if (result.isConfirmed) {
                        sessionStorage.setItem("user_has_read", "true");
                    }
                });
            }
        </script>
    <?php } ?>
</body>

</html>