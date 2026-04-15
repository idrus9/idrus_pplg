<?php
include 'config.php';
session_start();

// Proteksi halaman
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 1. PROSES TAMBAH DATA (CREATE)
if (isset($_POST['add_mod'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_mod']);
    $game   = mysqli_real_escape_string($conn, $_POST['game_target']);
    $versi  = mysqli_real_escape_string($conn, $_POST['versi']);
    $harga  = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "INSERT INTO mod_items (nama_mod, game_target, versi, harga, status) 
            VALUES ('$nama', '$game', '$versi', '$harga', '$status')";
    
    mysqli_query($conn, $sql);
    header("Location: mod_list.php"); // Refresh agar data muncul
}

// 2. PROSES HAPUS DATA (DELETE)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM mod_items WHERE id=$id");
    header("Location: mod_list.php");
}

// 3. AMBIL DATA UNTUK TABEL (READ)
$result = mysqli_query($conn, "SELECT * FROM mod_items ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mod Management - GameMod</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --bg: #f0f3f7;
            --sidebar-grad: linear-gradient(180deg, #6c5ce7 0%, #a29bfe 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background: var(--bg); min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: var(--sidebar-grad);
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar h2 { text-align: center; margin-bottom: 40px; font-size: 24px; letter-spacing: 1px; }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 15px;
            margin: 5px 0;
            border-radius: 10px;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }
        .sidebar a i { margin-right: 15px; width: 20px; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.2); color: white; }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        
        .header { margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #2d3436; }

        /* CARD STYLE (FORM & TABLE) */
        .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .card h3 { margin-bottom: 20px; color: #2d3436; font-size: 18px; }

        /* FORM LAYOUT */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        input, select {
            padding: 12px;
            border: 1px solid #dfe6e9;
            border-radius: 10px;
            outline: none;
            width: 100%;
        }
        input:focus { border-color: var(--primary); }
        
        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #5649c1; }

        /* TABLE STYLE */
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #b2bec3; font-weight: 500; border-bottom: 2px solid #f0f3f7; }
        td { padding: 15px; border-bottom: 1px solid #f0f3f7; color: #636e72; }
        
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            background: #e3fcef;
            color: #00b894;
        }
        
        .btn-edit { color: #fdcb6e; text-decoration: none; margin-right: 15px; font-size: 18px; }
        .btn-delete { color: #ff7675; text-decoration: none; font-size: 18px; }
        tr:hover { background-color: #fcfcfd; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GAMEMOD</h2>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="penjualan.php"><i class="fas fa-shopping-cart"></i> Transaksi</a>
        <a href="mod_list.php" class="active"><i class="fas fa-gamepad"></i> Daftar Game</a>
        <a href="pelanggan.php"><i class="fas fa-users"></i> Daftar Pelanggan</a>
            <a href="logout.php" style="color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Manajemen Mod Game</h1>
            <p style="color: #636e72;">Tambah mod baru dan kelola daftar katalog dalam satu tempat.</p>
        </div>

        <div class="card">
            <h3><i class="fas fa-plus-circle"></i> Tambah Mod Baru</h3>
            <form action="" method="POST" class="form-grid">
                <input type="text" name="nama_mod" placeholder="Nama Mod" required>
                <input type="text" name="game_target" placeholder="Game" required>
                <input type="text" name="versi" placeholder="Versi (v1.0)" required>
                <input type="number" name="harga" placeholder="Harga (Rp)" required>
                <select name="status">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Update">Update</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
                <button type="submit" name="add_mod" class="btn-submit">Simpan</button>
            </form>
        </div>

        <div class="card">
            <h3><i class="fas fa-list"></i> Katalog Mod Saat Ini</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Mod</th>
                        <th>Game</th>
                        <th>Versi</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong><?php echo $row['nama_mod']; ?></strong></td>
                            <td><?php echo $row['game_target']; ?></td>
                            <td><code><?php echo $row['versi']; ?></code></td>
                            <td><span style="color: var(--primary); font-weight: bold;">Rp <?php echo number_format($row['harga']); ?></span></td>
                            <td><span class="status-badge"><?php echo $row['status']; ?></span></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus mod ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center;">Belum ada data mod.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>