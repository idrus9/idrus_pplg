<?php
include 'config.php';
session_start();

// Proteksi halaman
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses Tambah Data
if (isset($_POST['add'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pembeli']);
    $game = mysqli_real_escape_string($conn, $_POST['nama_game']);
    $mod  = mysqli_real_escape_string($conn, $_POST['jenis_mod']);
    $harga = $_POST['harga'];
    mysqli_query($conn, "INSERT INTO mod_sales (nama_pembeli, nama_game, jenis_mod, harga) VALUES ('$nama', '$game', '$mod', '$harga')");
    header("Location: penjualan.php");
}

// Proses Hapus Data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM mod_sales WHERE id=$id");
    header("Location: penjualan.php");
}

$result = mysqli_query($conn, "SELECT * FROM mod_sales ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan - GameMod</title>
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

        /* SIDEBAR (Sama dengan Dashboard) */
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
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        
        .header { margin-bottom: 30px; }
        .header h1 { font-size: 28px; color: #2d3436; }

        /* FORM CARD */
        .card-form {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        .card-form h3 { margin-bottom: 20px; color: #2d3436; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        input {
            padding: 12px;
            border: 1px solid #dfe6e9;
            border-radius: 10px;
            outline: none;
            transition: 0.3s;
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

        /* TABLE CARD */
        .card-table {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #b2bec3; font-weight: 500; border-bottom: 2px solid #f0f3f7; }
        td { padding: 15px; border-bottom: 1px solid #f0f3f7; color: #636e72; }
        
        .btn-edit { color: #fdcb6e; text-decoration: none; margin-right: 10px; font-size: 18px; }
        .btn-delete { color: #ff7675; text-decoration: none; font-size: 18px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GAMEMOD</h2>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="penjualan.php" class="active"><i class="fas fa-shopping-cart"></i> Transaksi</a>
        <a href="mod_list.php"><i class="fas fa-gamepad"></i> Daftar Game</a>
        <a href="pelanggan.php"><i class="fas fa-users"></i> Daftar Pelanggan</a>
        <a href="logout.php" style="color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Manajemen Penjualan</h1>
            <p style="color: #636e72;">Input dan kelola data transaksi pembeli.</p>
        </div>

        <div class="card-form">
            <h3>Tambah Transaksi Baru</h3>
            <form action="" method="POST">
                <div class="form-grid">
                    <input type="text" name="nama_pembeli" placeholder="Nama Pembeli" required>
                    <input type="text" name="nama_game" placeholder="Nama Game" required>
                    <input type="text" name="jenis_mod" placeholder="Jenis Mod" required>
                    <input type="number" name="harga" placeholder="Harga (Rp)" required>
                    <button type="submit" name="add" class="btn-submit">Simpan Transaksi</button>
                </div>
            </form>
        </div>

        <div class="card-table">
            <h3>Riwayat Penjualan</h3>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Pembeli</th>
                        <th>Game</th>
                        <th>Mod</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo $row['nama_pembeli']; ?></strong></td>
                        <td><?php echo $row['nama_game']; ?></td>
                        <td><?php echo $row['jenis_mod']; ?></td>
                        <td>Rp <?php echo number_format($row['harga']); ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn-delete" title="Hapus" onclick="return confirm('Hapus data ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>