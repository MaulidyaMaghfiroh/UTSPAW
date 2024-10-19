<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$id = $_GET['id']; // Mendapatkan ID item dari URL

// Mengambil informasi item dari database (untuk menghapus file gambar jika diperlukan)
$sql = "SELECT * FROM items WHERE id='$id'";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

if ($item) {
    // Hapus gambar terkait jika ada
    $image_path = "img/" . $item['image'];
    if (file_exists($image_path)) {
        unlink($image_path);  // Menghapus file gambar
    }

    // Hapus item dari database
    $sql = "DELETE FROM items WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: list_barang.php');  // Redirect ke halaman daftar barang setelah berhasil dihapus
        exit();
    } else {
        echo "<div class='error'>Error deleting record: " . $conn->error . "</div>";
    }
} else {
    echo "<div class='error'>Item not found!</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
            text-align: center;
        }

        .error {
            color: red;
            margin: 20px;
            font-weight: bold;
        }

        a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Delete Item</h2>
    <p>Jika Anda melihat pesan kesalahan di atas, silakan kembali ke halaman daftar barang.</p>
    <a href="list_barang.php">Kembali ke Daftar Barang</a>
</body>
</html>
