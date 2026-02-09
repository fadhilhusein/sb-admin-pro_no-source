<?php 
include_once __DIR__ .  "/../libs/php/auth.php";
loginState();

$history_tamu = queryTamu("SELECT *, DATE_FORMAT(tanggal_kunjungan, '%d-%m-%Y') as jam_kunjungan FROM master_tamu WHERE kode_program = ?", [kode_program], true);

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=History_Tamu_Export.xls");
?>

<table>
    <tr>
        <th>Nama</th>
        <th>Asal Instansi</th>
        <th>Tujuan</th>
        <th>Jam Masuk</th>
        <th>Photo</th>
    </tr>
    <?php foreach ($history_tamu as $tamu) : ?>
        <tr>
            <td><?= $tamu['nama'] ?></td>
            <td><?= $tamu['asal_instansi'] ?></td>
            <td><?= $tamu['nama_tujuan'] ?></td>
            <td><?= $tamu['jam_kunjungan'] ?></td>
            <td><a href="../uploads/<?= $tamu['link_photo'] ?>" target="_blank">Lihat</a></td>
        </tr>
    <?php endforeach; ?>
</table>