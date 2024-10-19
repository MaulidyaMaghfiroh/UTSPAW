<?php
include 'db.php';
session_start();

// Memastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

// Mendapatkan ID item dari URL
$id = $_GET['id'];
$sql = "SELECT * FROM items WHERE id='$id'";
$result = $conn->query($sql);
$item = $result->fetch_assoc();

// Memproses form jika ada pengiriman
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Jika ada gambar baru di-upload, update gambar
    if (!empty($image)) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($image);
        
        // Memindahkan file gambar ke direktori yang diinginkan
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

        // Update database dengan gambar baru
        $sql = "UPDATE items SET name='$name', price='$price', image='$image' WHERE id='$id'";
    } else {
        // Jika tidak ada gambar baru, update nama dan harga saja
        $sql = "UPDATE items SET name='$name', price='$price' WHERE id='$id'";
    }

    // Menjalankan query untuk update
    if ($conn->query($sql) === TRUE) {
        header('Location: list_barang.php');  // Redirect ke halaman daftar barang
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
            text-align: center;
        }

        .form-container {
            background-color: #ffe6f2; /* Warna latar belakang pink muda */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        h2 {
            margin-bottom: 20px;
            color: #d5006d; /* Warna teks judul pink gelap */
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #d5006d; /* Warna tombol pink gelap */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c4005a; /* Warna tombol saat hover */
        }

        img {
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Barang</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk</label>
            <input type="text" name="name" value="<?= htmlspecialchars($item['name']); ?>" required />
            
            <label>Harga</label>
            <input type="number" name="price" value="<?= htmlspecialchars($item['price']); ?>" required />
            
            <label>Gambar Sekarang</label>
            <img src="img/<?= htmlspecialchars($item['image']); ?>" width="100" alt="<?= htmlspecialchars($item['name']); ?>">
            
            <label>Ganti Gambar (jika diperlukan)</label>
            <input type="file" name="image" />

            <button type="submit">Update Item</button>
        </form>
    </div>
</body>
</html>
