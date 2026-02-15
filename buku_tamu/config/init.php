<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

use Dotenv\Dotenv;

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config/settings.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$username = $_ENV['DB_USER'];   // sesuaikan dengan user MySQL kamu
$password = $_ENV['DB_PASS'];   // isi kalau ada password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Atur mode error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi berhasil!";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Fungsi load config
function loadAppConfig($pdo, $kode_program_input)
{
    // Cek apakah ada session
    if (isset($_SESSION['app_config']) && $_SESSION['app_config']['kode_program'] === $kode_program_input) {
        return $_SESSION['app_config'];
    }

    // Kalau tidak ada session maka ambil dari DB
    $stmt = $pdo->prepare("SELECT * FROM master_program WHERE kode_program = ? LIMIT 1");
    $stmt->execute([$kode_program_input]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['app_config'] = $result;
        return $result;
    } else {
        die("Konfigurasi Error: Kode Program '" . htmlspecialchars($kode_program_input) . "' tidak ditemukan di database master.");
    }
};

function hitungSisaMasaAktif($expireDateString)
{
    try {
        // 1. Ambil tanggal hari ini (set jam ke 00:00:00 agar akurat hitungan harinya)
        $hariIni = new DateTime('today');

        // 2. Ambil tanggal expire dari database
        $tglExpire = new DateTime($expireDateString);

        // 3. Hitung selisih
        $selisih = $hariIni->diff($tglExpire);

        // Ambil jumlah hari (integer)
        $jumlahHari = $selisih->days;

        // 4. Cek logika status
        // Property 'invert' bernilai 1 jika tanggal tujuan sudah lewat (masa lalu)
        if ($selisih->invert == 1) {
            return [
                'sisa_hari' => 0,
                'status' => 'expired',
                'pesan' => 'Paket Telah Berakhir',
                'alert' => 'danger', // Contoh class utility (Tailwind/Bootstrap)
            ];
        } elseif ($jumlahHari == 0) {
            return [
                'sisa_hari' => 0,
                'status' => 'warning',
                'pesan' => 'Berakhir HARI INI',
                'alert' => 'danger',
            ];
        } elseif ($jumlahHari <= 7) {
            return [
                'sisa_hari' => $jumlahHari,
                'status' => 'warning',
                'pesan' => $jumlahHari . ' Hari Lagi (Segera Perpanjang)',
                'alert' => 'warning',
            ];
        } else {
            return [
                'sisa_hari' => $jumlahHari,
                'status' => 'aman',
                'pesan' => $jumlahHari . ' Hari Lagi',
                'alert' => 'success', // Sesuaikan dengan tema biru aplikasimu
            ];
        }
    } catch (Exception $e) {
        return [
            'sisa_hari' => 0,
            'status' => 'error',
            'pesan' => 'Format Tanggal Salah',
            'alert' => 'primary',
        ];
    }
}

function todayList($id_program = null)
{
    global $pdo;

    $currentDate = date("Y-m-d");

    $query = "SELECT *, DATE_FORMAT(tanggal_kunjungan, '%H:%i') AS waktu_kunjungan FROM master_tamu WHERE id_program='{$id_program}' AND DATE(tanggal_kunjungan) = '{$currentDate}' AND status_kedatangan = 'Check In'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = [];

    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($results, $result);
    }

    if ($results) {
        $_SESSION['todayList'] = $results;
        return $results;
    } else {
        // Kembalikan array kosong agar tidak terjadi error saat di index.php
        return [];
    }
};

function formatTanggalIndo($tanggal = null)
{
    // Jika tidak ada tanggal yang dikirim, gunakan waktu sekarang
    if ($tanggal == null) {
        $tanggal = new DateTime();
    } else {
        // Jika inputnya string (misal dari database '2026-01-14'), ubah ke DateTime
        $tanggal = new DateTime($tanggal);
    }

    // Array Hari (0 = Minggu, 6 = Sabtu)
    $nama_hari = [
        'MINGGU',
        'SENIN',
        'SELASA',
        'RABU',
        'KAMIS',
        'JUMAT',
        'SABTU'
    ];

    // Array Bulan (1 = Januari)
    $nama_bulan = [
        1 => 'JANUARI',
        'FEBRUARI',
        'MARET',
        'APRIL',
        'MEI',
        'JUNI',
        'JULI',
        'AGUSTUS',
        'SEPTEMBER',
        'OKTOBER',
        'NOVEMBER',
        'DESEMBER'
    ];

    // Ambil urutan hari (0-6)
    $urutan_hari = $tanggal->format('w');

    // Ambil urutan bulan (1-12)
    $urutan_bulan = $tanggal->format('n');

    // Ambil tanggal (1-31)
    $tgl = $tanggal->format('d');

    // Ambil tahun (2026)
    $thn = $tanggal->format('Y');

    // Rakit string akhirnya
    // Format: HARI, TANGGAL BULAN TAHUN
    $hasil = $nama_hari[$urutan_hari] . ', ' . $tgl . ' ' . $nama_bulan[$urutan_bulan] . ' ' . $thn;

    return $hasil;
}

function queryTamu($query, $data = null, $multipleRow = false)
{
    global $pdo;

    try {

        $stmt = $pdo->prepare($query);

        if ($data) {
            $stmt->execute($data);

            if ($multipleRow) {
                $result = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($result, $row);
                }
                return $result;
            }

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $stmt->execute();

        if ($multipleRow) {
            $result = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($result, $row);
            }
            return $result;
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Error terjadi: $e");
    }
}

// Configurasi Aplikasi
$appConfig = loadAppConfig($pdo, kode_program);

// ---- Mengambil current URL Path
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

$host = $_SERVER['HTTP_HOST'];
$uri = $_SERVER['REQUEST_URI'];

$full_url = $protocol . $host . $uri;

$urlLength = count(explode('/', $full_url));
$lastURL = explode('/', $full_url)[$urlLength - 1];
