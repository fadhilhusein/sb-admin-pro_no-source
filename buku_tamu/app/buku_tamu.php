<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

include_once __DIR__ . "/../libs/php/auth.php";
loginState();

$masaAktif = hitungSisaMasaAktif($appConfig['expire_date']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Buku Tamu</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/form_buku_tamu.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="nav-fixed">
    <?php include_once("../components/topbar.php"); ?>
    <div id="layoutSidenav">
        <?php include_once("../components/sidebar.php"); ?>
        <div id="layoutSidenav_content">
            <main class="h-100">

                <!-- Main page content-->
                <div class="container-xl px-4 mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header">Photo Tamu</div>
                                <div class="card-body row">
                                    <div class="col-12 d-flex align-items-center flex-column">
                                        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center rounded-2 border-2 border-primary border-dashed mb-2">
                                            <div id="place-holder">
                                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                                    <i data-feather="camera"></i>
                                                    <p>Masukan gambar baru</p>
                                                </div>
                                            </div>
                                            <img id="preview-image" alt="preview" class="w-100 h-100">
                                        </div>
                                        <label style="cursor: pointer;" for="photo-tamu" class="rounded-2 text-white px-4 py-2 bg-primary">Add Photo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Form Tamu</div>
                                <div class="card-body">
                                    <form action="#" id="form_buku" class="needs-validation">
                                        <div class="mb-3">
                                            <label for="nama_pengunjung" class="small form-label">Nama Pengunjung <span style="color: red;">*</span></label>
                                            <input id="nama_pengunjung" name="nama_pengunjung" type="text" class="form-control form-control-sm" required>
                                            <input class="d-none" name="photo_pengunjung" id="photo-tamu" type="file" accept="image/*" capture="environment">
                                            <input class="d-none" type="text" name="kode_program" value="<?= $appConfig['kode_program'] ?>">
                                            <input class="d-none" type="text" name="status_tamu" value="in">
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nomor_pengunjung" class="small form-label">Nomor Handphone <span style="color: red;">*</span></label>
                                                <input id="nomor_pengunjung" name="nomor_pengunjung" type="number" inputmode="numeric" class="form-control form-control-sm no_arrows" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="instansi_pengunjung" class="small form-label">Asal Instansi</label>
                                                <input id="instansi_pengunjung" name="instansi_pengunjung" type="text" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nama_tujuan" class="small form-label">Bertemu Dengan <span style="color: red;">*</span></label>
                                                <input id="nama_tujuan" name="nama_tujuan" type="text" class="form-control form-control-sm" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="departemen_tujuan" class="small form-label">Bagian Departemen</label>
                                                <input id="departemen_tujuan" name="departemen_tujuan" type="text" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_janji" class="small form-label">Ada janji temu? <span style="color: red;">*</span></label>
                                            <select class="form-select" id="status_janji" name="status_janji" aria-label="Default select example" required>
                                                <option value="" selected>Pilih status janji</option>
                                                <option value="Y">Ada</option>
                                                <option value="N">Tidak</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-primary" id="simpan_buku" type="submit">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include_once('../components/footer.php'); ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../libs/js/scripts.js"></script>
    <script src="../libs/js/bukutamu.js"></script>
    <?php if ($masaAktif['alert'] == 'danger') { ?>
        <script>
            Swal.fire({
                title: "Masa langganan sudah habis!",
                text: "Perpanjang langganan untuk terus menggunakan aplikasi ini",
                icon: "error",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ya, saya mengerti"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php";
                }
            });
        </script>
    <?php } ?>
</body>

</html>