<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Hapus Cookie
    setcookie('user_session', '', time() - (86400 * 7), "/");
    $_COOKIE = [];

    // Hapus Session
    session_destroy();

    header("Location: ../app/login.php");
}
