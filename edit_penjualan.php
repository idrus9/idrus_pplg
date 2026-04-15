<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM mod_sales WHERE id=$id");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $game = mysqli_real_escape_string($conn, $_POST['nama_game']);
    $mod  = mysqli_real_escape_string($conn, $_POST['jenis_mod']);
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE mod_sales SET nama_pembeli='$nama', nama_game='$game', jenis_mod='$mod', harga='$harga' WHERE id=$id");
    header("Location: penjualan.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Penjualan - GameMod</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #6c5ce7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .edit-card { background: white; padding: 40px; border-radius: 20px; width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        h2 { margin-bottom: 25px; color: #2d3436; text-align: center; }
        label { display: block; margin-bottom: 5px; color: #636e72; font-size: 14px; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 10px; box-sizing: border-box; }
        .btn-save { width: 100%; padding: 12px; background: #6c5ce7; color: white; border: none; border-radius: 10px; font-weight: bold; cursor: pointer; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #b2bec3; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="edit-card">
        <h2>Edit Transaksi</h2>
        <form method="POST">
            <label>Nama Pembeli</label>
            <input type="text" name="nama_pembeli" value="<?php echo $row['nama_pembeli']; ?>" required>
            
            <label>Nama Game</label>
            <input type="text" name="nama_game" value="<?php echo $row['nama_game']; ?>" required>
            
            <label>Jenis Mod</label>
            <input type="text" name="jenis_mod" value="<?php echo $row['jenis_mod']; ?>" required>
            
            <label>Harga (Rp)</label>
            <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
            
            <button type="submit" name="update" class="btn-save">Update Data</button>
            <a href="penjualan.php" class="btn-cancel">Batal dan Kembali</a>
        </form>
    </div>
</body>
</html>