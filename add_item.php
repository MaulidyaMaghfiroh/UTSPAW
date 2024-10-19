<?php
include 'db.php';

// Memproses form jika ada pengiriman
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Folder tujuan untuk menyimpan gambar
    $target_dir = "img/";
    $target_file = $target_dir . basename($image);

    // Pindahkan gambar ke folder img
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Jika gambar berhasil di-upload, simpan informasi barang ke database
        $sql = "INSERT INTO items (name, price, image) VALUES ('$name', '$price', '$image')";
        if ($conn->query($sql) === TRUE) {
            header('Location: list_barang.php');  // Redirect ke halaman daftar barang
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Barang</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Nama Produk" required />
            <input type="number" name="price" placeholder="Harga" required />
            <input type="file" name="image" required />
            <button type="submit">Add Item</button>
        </form>
    </div>
</body>
</html>
