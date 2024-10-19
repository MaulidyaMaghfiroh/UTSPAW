<?php
include 'db.php';

// Mendapatkan ID dari URL
$id = $_GET['id'];
$sql = "SELECT * FROM items WHERE id=$id";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

// Memeriksa apakah item ditemukan
if (!$item) {
    echo "<h2>Item tidak ditemukan!</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #e91e63; /* Warna Pink */
        }

        p {
            font-size: 18px;
            color: #ad1457; /* Warna Pink yang lebih gelap */
        }

        img {
            border-radius: 10px;
            margin-top: 20px;
        }

        a {
            display: inline-block;
            background-color: #f06292; /* Warna Pink untuk tombol */
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #ec407a; /* Warna pink lebih gelap saat di-hover */
        }
    </style>
</head>
<body>
    <h1><?= htmlspecialchars($item['name']); ?></h1>
    <p>Harga: <?= htmlspecialchars(number_format($item['price'], 3,'.')); ?></p>
    <img src="img/<?= htmlspecialchars($item['image']); ?>" width="200">
    <br>
    <a href="list_barang.php">Kembali ke Daftar Barang</a>
</body>
</html>
