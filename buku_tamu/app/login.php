<?php
session_start();

include_once __DIR__ . "/../libs/php/auth.php";

$flash = $_SESSION['FLASH'] ?? null;
unset($_SESSION['FLASH']);

if (isset($_SESSION['user_session']) || isset($_SESSION['admin_session'])) {
    header("Location: index.php");
    exit();
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Buku Tamu - <?= $appConfig['nama_program'] ?></title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header d-flex justify-content-center align-items-center my-4 ">
                                    <img class="image-login px-3" src="../assets/img/gegesik.jpg" alt="Logo" class="img-fluid">
                                    <h3 class="fw-bold mb-0 d-inline">Login Buku Tamu</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Login form-->
                                    <form action="../action/login_user.php" method="post">
                                        <!-- Form PIN User-->
                                        <div class="mb-3">
                                            <label class="small mb-1" for="inputEmailAddress">PIN</label>
                                            <input class="form-control" name="pin_user" id="inputEmailAddress" type="number" placeholder="Masukan PIN Anda" />
                                        </div>
                                        <!-- Form Group (remember password checkbox)-->
                                        <?php if ($flash): ?>
                                            <?php if ($flash['type'] === "success"): ?>
                                                <div class="mb-3">
                                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                                        <i class="me-2" data-feather="alert-triangle"></i>
                                                        <div>
                                                            An example danger alert with an icon
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="mb-3">
                                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                                        <i class="me-2" data-feather="alert-triangle"></i>
                                                        <div>
                                                            <?= $flash['text'] ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="rememberPasswordCheck" name="rememberMe" type="checkbox" value="" />
                                                    <label class="form-check-label" for="rememberPasswordCheck">Remember Me</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="auth-register-basic.html">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
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
</body>

</html>