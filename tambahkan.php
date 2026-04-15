<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_mod']);
    $game   = mysqli_real_escape_string($conn, $_POST['game_target']);
    $versi  = mysqli_real_escape_string($conn, $_POST['versi']);
    $harga  = $_POST['harga'];
    $status = $_POST['status'];

    $query = "INSERT INTO mod_items (nama_mod, game_target, versi, harga, status) 
              VALUES ('$nama', '$game', '$versi', '$harga', '$status')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: mod_list.php");
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mod - GameMod</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
            --sidebar-grad: linear-gradient(180deg, #6c5ce7 0%, #a29bfe 100%);
            --bg: #f0f3f7;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background: var(--bg); min-height: 100vh; }

        /* SIDEBAR SAMA DENGAN HALAMAN LAIN */
        .sidebar {
            width: 260px; background: var(--sidebar-grad); color: white;
            padding: 30px 20px; position: fixed; height: 100%; display: flex; flex-direction: column;
        }
        .sidebar h2 { text-align: center; margin-bottom: 40px; }
        .sidebar a {
            color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px;
            margin: 5px 0; border-radius: 10px; display: flex; align-items: center;
        }
        .sidebar a.active { background: rgba(255,255,255,0.2); color: white; }
        .sidebar a i { margin-right: 15px; width: 20px; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; display: flex; flex-direction: column; align-items: center; }
        
        .form-card {
            background: white; padding: 40px; border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); width: 100%; max-width: 600px;
        }
        .form-card h2 { margin-bottom: 25px; color: #2d3436; }

        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; color: #636e72; font-size: 14px; }
        input, select {
            width: 100%; padding: 12px; border: 1px solid #dfe6e9;
            border-radius: 10px; outline: none; transition: 0.3s;
        }
        input:focus { border-color: var(--primary); }

        .btn-submit {
            background: var(--primary); color: white; border: none;
            padding: 15px; border-radius: 10px; width: 100%;
            font-weight: bold; cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-back { display: block; text-align: center; margin-top: 20px; color: #b2bec3; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GAMEMOD</h2>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="penjualan.php"><i class="fas fa-shopping-cart"></i> Penjualan</a>
        <a href="mod_list.php" class="active"><i class="fas fa-gamepad"></i> Daftar Mod</a>
        <a href="pelanggan.php"><i class="fas fa-users"></i> Pelanggan</a>
        <div style="margin-top: auto;"><a href="logout.php" style="color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a></div>
    </div>

    <div class="main-content">
        <div class="form-card">
            <h2>Tambah Mod Baru</h2>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Nama Mod</label>
                    <input type="text" name="nama_mod" placeholder="Contoh: Ultra Realistic Water" required>
                </div>
                <div class="input-group">
                    <label>Game Target</label>
                    <input type="text" name="game_target" placeholder="Contoh: GTA V / RDR 2" required>
                </div>
                <div class="input-group">
                    <label>Versi Mod</label>
                    <input type="text" name="versi" placeholder="Contoh: v1.0.2" required>
                </div>
                <div class="input-group">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" placeholder="0" required>
                </div>
                <div class="input-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Update">Butuh Update</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="btn-submit">Simpan ke Katalog</button>
                <a href="mod_list.php" class="btn-back">Kembali ke Daftar</a>
            </form>
        </div>
    </div>

</body>
</html>