<?php
include 'config.php';
session_start();

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM customers WHERE id=$id");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_pelanggan'];
    $email = $_POST['email'];
    $hp = $_POST['nomor_hp'];

    mysqli_query($conn, "UPDATE customers SET nama_pelanggan='$nama', email='$email', nomor_hp='$hp' WHERE id=$id");
    header("Location: pelanggan.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background: #6c5ce7; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .box { background: white; padding: 30px; border-radius: 15px; width: 350px; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #6c5ce7; color: white; border: none; border-radius: 8px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h3>Edit Pelanggan</h3>
        <form method="POST">
            <input type="text" name="nama_pelanggan" value="<?php echo $row['nama_pelanggan']; ?>">
            <input type="email" name="email" value="<?php echo $row['email']; ?>">
            <input type="text" name="nomor_hp" value="<?php echo $row['nomor_hp']; ?>">
            <button type="submit" name="update">Update Data</button>
            <a href="pelanggan.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none; font-size:14px;">Batal</a>
        </form>
    </div>
</body>
</html>