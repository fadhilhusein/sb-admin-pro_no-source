<?php
$url = "https://equran.id/api/v2/surat";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
}

curl_close($ch);

$data_objek = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../dist/css/styles.css">
    <title>Document</title>
</head>

<body>
    <?php
    foreach ($data_objek['data'] as $surat):
    ?>
        <div class="my-2 mx-2">
            <button class="btn btn-primary"><?= $surat['namaLatin'] . " : " . $surat['jumlahAyat'] . " Ayat" ?></button>
        </div>
    <?php
    endforeach;
    ?>

    <script src="../dist/js/main.js">
        alert('helo')
    </script>
</body>

</html>