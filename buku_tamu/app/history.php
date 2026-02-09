<?php

include_once __DIR__ . '/../libs/php/auth.php';
loginState();

$history_tamu = queryTamu("SELECT *, DATE_FORMAT(tanggal_kunjungan, '%H:%i:%s') AS jam_kunjungan FROM master_tamu WHERE kode_program = ?", [kode_program], true);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/coreui.css">
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <?php include_once __DIR__ . '/../components/topbar.php'; ?>
    <div id="layoutSidenav">
        <?php include_once __DIR__ . '/../components/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mt-4">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon"><i data-feather="filter"></i></div>
                                        History Tamu
                                    </h1>
                                    <div class="page-header-subtitle">History tamu yang sudah berkunjung</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <div data-coreui-locale="en-US" data-coreui-toggle="date-range-picker"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div
                                            data-coreui-start-date="2022/08/03"
                                            data-coreui-end-date="2022/08/17"
                                            data-coreui-locale="en-US"
                                            data-coreui-toggle="date-range-picker">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- Main page content-->
                <div class="container-xl px-4 mt-n10">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            History Tamu
                            <a href="../export_excel/export_history.php" class="btn btn-outline-primary">Export</a>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
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
                                    <?php foreach ($history_tamu as $tamu) : ?>
                                        <tr>
                                            <td><?= $tamu['nama'] ?></td>
                                            <td><?= $tamu['asal_instansi'] ?></td>
                                            <td><?= $tamu['nama_tujuan'] ?></td>
                                            <td><?= $tamu['jam_kunjungan'] ?></td>
                                            <td><a href="../uploads/<?= $tamu['link_photo'] ?>" target="_blank">Lihat</a></td>
                                            <td>
                                                <button class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                                <button class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fa-regular fa-trash-can"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; Your Website 2021</div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../libs/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../libs/js/datatables/datatables-simple-demo.js"></script>
    <script src="../libs/js/coreui.bundle.js"></script>
</body>

</html>