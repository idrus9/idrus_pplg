<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pembeli</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .tambah { background: green; color: white; }
        .edit { background: orange; color: white; }
        .hapus { background: red; color: white; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Daftar Pembeli</h2>
    <div style="width: 80%; margin: auto;">
        <a href="tambah.php" class="btn tambah">+ Tambah Pembeli Baru</a>
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM pembeli ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telepon']}</td>
                <td>{$row['alamat']}</td>
                <td>
                    <a href='edit.php?id={$row['id']}' class='btn edit'>Edit</a>
                    <a href='hapus.php?id={$row['id']}' class='btn hapus' onclick='return confirm(\"Hapus data?\")'>Hapus</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>