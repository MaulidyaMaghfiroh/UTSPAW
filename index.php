<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #ff66b2;
            margin-bottom: 20px;
        }
        .btn, .logout-btn {
            display: inline-block;
            background-color: #ff66b2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }
        .logout-btn {
            float: right;
        }
        .btn:hover, .logout-btn:hover {
            background-color: #ff3385;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        .table th {
            background-color: #ff99cc;
            color: white;
        }
        .table td img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .table a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .table a:hover {
            background-color: #45a049;
        }
        .table a.delete {
            background-color: #f44336;
        }
        .table a.delete:hover {
            background-color: #e60000;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 14px;
            }
            .table td img {
                width: 80px;
            }
        }
        @media (max-width: 480px) {
            .table th, .table td {
                font-size: 12px;
            }
            .table td img {
                width: 60px;
            }
        }
    </style>
</head>
<body>
    <h2>Daftar Barang</h2>
    <a href="add_item.php" class="btn">Add Item</a>
    <a href="logout.php" class="logout-btn">Logout</a>
    <table class="table">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td>Rp <?= number_format($row['price'], 3, '.'); ?></td>
            <td>
                <img src="img/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
            </td>
            <td>
                <a href="detail_item.php?id=<?= $row['id']; ?>">Detail</a>
                <a href="edit_item.php?id=<?= $row['id']; ?>">Edit</a>
                <a href="delete_item.php?id=<?= $row['id']; ?>" class="delete">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
