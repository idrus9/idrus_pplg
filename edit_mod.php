<?php
include 'config.php';
session_start();

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM mod_items WHERE id=$id");
$d = mysqli_fetch_assoc($res);

if (isset($_POST['update_mod'])) {
    $nama = $_POST['nama_mod'];
    $game = $_POST['game_target'];
    $versi = $_POST['versi'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE mod_items SET nama_mod='$nama', game_target='$game', versi='$versi', harga='$harga', status='$status' WHERE id=$id");
    header("Location: mod_list.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Mod</title>
    <style>
        body { font-family: sans-serif; background: #6c5ce7; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .edit-box { background: white; padding: 30px; border-radius: 15px; width: 350px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;}
        button { width: 100%; padding: 12px; background: #6c5ce7; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="edit-box">
        <h3>Edit Detail Mod</h3>
        <form method="POST">
            <input type="text" name="nama_mod" value="<?php echo $d['nama_mod']; ?>">
            <input type="text" name="game_target" value="<?php echo $d['game_target']; ?>">
            <input type="text" name="versi" value="<?php echo $d['versi']; ?>">
            <input type="number" name="harga" value="<?php echo $d['harga']; ?>">
            <select name="status">
                <option value="Tersedia" <?php if($d['status'] == 'Tersedia') echo 'selected'; ?>>Tersedia</option>
                <option value="Update" <?php if($d['status'] == 'Update') echo 'selected'; ?>>Butuh Update</option>
                <option value="Nonaktif" <?php if($d['status'] == 'Nonaktif') echo 'selected'; ?>>Nonaktif</option>
            </select>
            <button type="submit" name="update_mod">Update Data</button>
            <a href="mod_list.php" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">Batal</a>
        </form>
    </div>
</body>
</html>