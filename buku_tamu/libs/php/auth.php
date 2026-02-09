<?php
require __DIR__ . "/../../config/init.php";

function loginState($Main = false)
{
    // 1. Jika Session belum ada, coba cek Cookie
    if (!isset($_SESSION['user_session']) && !isset($_SESSION['admin_session'])) {
        if (isset($_COOKIE['user_session'])) {
            $cookie_hash = $_COOKIE['user_session'];

            // Cek apakah hash tersebut ada di kolom pin_user ATAU pin_admin
            $query = "SELECT * FROM master_program WHERE pin_user = ?";
            $result = queryTamu($query, [$cookie_hash]);

            // Jika ketemu, restore session
            if ($result) {
                // Tentukan dia login sebagai admin atau user berdasarkan kecocokan hash
                $_SESSION['user_session'] = $cookie_hash;
            }
        } elseif (isset($_COOKIE['admin_session'])) {
            $cookie_hash = $_COOKIE['admin_session'];

            // Cek apakah hash tersebut ada di kolom pin_user ATAU pin_admin
            $query = "SELECT * FROM master_program WHERE pin_admin = ?";
            $result = queryTamu($query, [$cookie_hash]);

            // Jika ketemu, restore session
            if ($result) {
                // Tentukan dia login sebagai admin atau user berdasarkan kecocokan hash
                $_SESSION['admin_session'] = $cookie_hash;
            }
        }
    }

    // 2. Cek ulang, jika setelah cek cookie session masih kosong, tendang ke login
    if (!isset($_SESSION['user_session']) && !isset($_SESSION['admin_session'])) {
        header("Location: ../app/login.php");
        exit();
    }
};
