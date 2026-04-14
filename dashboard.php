<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM cafes";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekomendasi Cafe Cianjur</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #6F4E37; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .logout { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Halo, <?php echo $_SESSION['user']; ?>!</h1>
    <h3>Rekomendasi Tempat Ngopi Hits di Cianjur</h3>
    <a href="logout.php" class="logout">Logout</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Cafe</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $no = 1;
        while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['nama_cafe']; ?></td>
            <td><?php echo $row['lokasi']; ?></td>
            <td><a href="<?php echo $row['link_maps']; ?>" target="_blank">Lihat di Maps</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>