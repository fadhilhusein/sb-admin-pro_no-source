<?php
require __DIR__ . "/../config/init.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if ($_POST['type'] === "input_tamu") {
        // 1. Cek apakah ada file yang diupload dan tidak error
        if (isset($_FILES['photo_pengunjung']) && $_FILES['photo_pengunjung']['error'] === UPLOAD_ERR_OK) {

            // --- KONFIGURASI UPLOAD ---
            $uploadDir = __DIR__ . "/../uploads/"; // Gunakan Absolute Path agar aman

            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Ambil Ekstensi File Asli (agar png tetap png, jpg tetap jpg)
            $fileInfo = pathinfo($_FILES['photo_pengunjung']['name']);
            $ext = strtolower($fileInfo['extension']);

            // Validasi Ekstensi (Keamanan)
            $allowedExt = ['jpg', 'jpeg', 'png'];
            if (!in_array($ext, $allowedExt)) {
                echo json_encode(['type' => 'warning', 'message' => 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan!']);
                exit;
            }

            // Generate Nama File Unik (Tambahkan random number agar tidak bentrok)
            $cleanFileName = date("YmdHis") . "_" . rand(100, 999) . "." . $ext;

            $destination = $uploadDir . $cleanFileName; // Path untuk move_uploaded_file

            // --- PROSES UPLOAD ---
            if (move_uploaded_file($_FILES['photo_pengunjung']['tmp_name'], $destination)) {

                // --- PROSES DATABASE ---
                $sql = "INSERT INTO master_tamu (kode_program, nama, no_hp, asal_instansi, nama_tujuan, departemen_tujuan, status_janji, link_photo, status_tamu) VALUES (:kode_program, :nama, :no_hp, :asal_instansi, :nama_tujuan, :departemen_tujuan, :status_janji, :link_photo, :status_tamu)";

                $stmt = $pdo->prepare($sql);

                $data = [
                    'kode_program' => $_POST['kode_program'],
                    'nama' => $_POST['nama_pengunjung'],
                    'no_hp' => $_POST['nomor_pengunjung'],
                    'asal_instansi' => $_POST['instansi_pengunjung'],
                    'nama_tujuan' => $_POST['nama_tujuan'],
                    'departemen_tujuan' => $_POST['departemen_tujuan'],
                    'status_janji' => $_POST['status_janji'],
                    'link_photo' => $cleanFileName, // SIMPAN NAMA FILE SAJA (Lebih Fleksibel)
                    'status_tamu' => $_POST['status_tamu']
                ];

                if ($stmt->execute($data)) {
                    echo json_encode(['type' => 'success', 'title' => 'Check in berhasil', 'message' => 'Data tamu berhasil disimpan!']);
                } else {
                    // Jika insert DB gagal, hapus file yang sudah terlanjur diupload (Clean up)
                    unlink($destination);
                    echo json_encode(['type' => 'warning', 'title' => 'Check in gagal', 'message' => 'Gagal menyimpan ke database.']);
                }
            } else {
                echo json_encode(['type' => 'warning', 'title' => 'Terjadi kesalahan', 'message' => 'Gagal mengupload gambar. Periksa permission folder.']);
            }
        } else {
            echo json_encode(['type' => 'warning', 'title' => 'Gambar tidak ada', 'message' => 'Harap upload foto pengunjung!']);
        }
    } elseif ($_POST['type'] === "check_out") {
        $id_tamu = $_POST['id_tamu'];

        // Update status tamu menjadi out
        $query = "UPDATE master_tamu SET status_tamu = 'out' WHERE id_tamu = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id_tamu]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['type' => 'success', 'title' => 'Check out berhasil', 'message' => 'Data tamu berhasil diupdate!']);
        } else {
            echo json_encode(['type' => 'warning', 'title' => 'Check out gagal', 'message' => 'Gagal mengupdate data tamu.']);
        }
    }
}
