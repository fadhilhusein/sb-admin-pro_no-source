<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config/init.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Ambil input PIN (Hanya ada satu input dari form login.php yaitu 'pin_user')
    // Kita namakan $input_pin agar lebih jelas maknanya
    $input_pin = isset($_POST['pin_user']) ? $_POST['pin_user'] : '';

    try {
        $rememberMe = isset($_POST['rememberMe']) ? true : false;

        // 2. Ambil data program (termasuk hash password user & admin)
        $query_program = "SELECT * FROM master_program WHERE kode_program = ?";
        $result_program = queryTamu($query_program, [kode_program]);

        if ($result_program) {
            // 3. Cek Input PIN terhadap Hash User DAN Hash Admin
            $is_user  = password_verify($input_pin, $result_program['pin_user']);
            $is_admin = password_verify($input_pin, $result_program['pin_admin']);

            if ($is_user || $is_admin) {
                // Ambil hash asli dari database untuk disimpan di session/cookie
                $hash_admin_db = $result_program['pin_admin'];
                $hash_user_db  = $result_program['pin_user'];

                if ($is_admin) {
                    // Login sebagai ADMIN
                    if ($rememberMe) {
                        setcookie('admin_session', $hash_admin_db, time() + (86400 * 7), "/");
                    }
                    $_SESSION['admin_session'] = $hash_admin_db;
                    header("Location: ../app/index.php");
                } else {
                    // Login sebagai USER BIASA
                    if ($rememberMe) {
                        setcookie('user_session', $hash_user_db, time() + (86400 * 7), "/");
                    }
                    $_SESSION['user_session'] = $hash_user_db;
                    header("Location: ../app/index.php");
                }
            } else {
                $_SESSION['FLASH'] = [
                    'type' => 'error',
                    'title' => 'Login Gagal',
                    'text'  => 'PIN Salah!'
                ];
                header("Location: ../app/login.php");
            }
        } else {
            $_SESSION['FLASH'] = [
                'type' => 'error',
                'title' => 'Login Gagal',
                'text'  => 'Kode Program Tidak Terdaftar!'
            ];
            header("Location: ../app/login.php");
        }
    } catch (Exception $error) {
        $_SESSION['FLASH'] = [
            'type' => 'error',
            'title' => 'Login Gagal',
            'text'  => 'Terjadi kesalahan teknis!'
        ];
        header("Location: ../app/login.php");
    }
}
