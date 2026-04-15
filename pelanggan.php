<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tambah Pelanggan
if (isset($_POST['add_customer'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
    
    mysqli_query($conn, "INSERT INTO customers (nama_pelanggan, email, nomor_hp) VALUES ('$nama', '$email', '$hp')");
    header("Location: pelanggan.php");
}

// Hapus Pelanggan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM customers WHERE id=$id");
    header("Location: pelanggan.php");
}

$result = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pelanggan - GameMod</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
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
        }

        .sidebar h2 { text-align: center; margin-bottom: 40px; font-size: 24px; }
        .sidebar a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 15px;
            margin: 5px 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.2); color: white; }
        .sidebar a i { margin-right: 15px; width: 20px; }

        /* CONTENT */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        .header { margin-bottom: 30px; }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        input { padding: 12px; border: 1px solid #ddd; border-radius: 10px; outline: none; }
        
        .btn-add {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #b2bec3; border-bottom: 2px solid #f0f3f7; }
        td { padding: 15px; border-bottom: 1px solid #f0f3f7; color: #636e72; }

        .btn-edit { color: #fdcb6e; margin-right: 15px; text-decoration: none; }
        .btn-delete { color: #ff7675; text-decoration: none; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GAMEMOD</h2>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="penjualan.php"><i class="fas fa-shopping-cart"></i> Transaksi</a>
        <a href="mod_list.php"><i class="fas fa-gamepad"></i> Daftar Game</a>
        <a href="pelanggan.php" class="active"><i class="fas fa-users"></i> Daftar Pelanggan</a>
        <a href="logout.php" style="color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

    <div class="main-content">
        <div class="header">
            <h1>Data Pelanggan</h1>
            <p style="color: #636e72;">Kelola informasi kontak pembeli mod game.</p>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 15px;">Registrasi Pelanggan Baru</h3>
            <form action="" method="POST" class="form-grid">
                <input type="text" name="nama_pelanggan" placeholder="Nama Lengkap" required>
                <input type="email" name="email" placeholder="Alamat Email" required>
                <input type="text" name="nomor_hp" placeholder="Nomor WhatsApp" required>
                <button type="submit" name="add_customer" class="btn-add">Simpan Data</button>
            </form>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo $row['nama_pelanggan']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['nomor_hp']; ?></td>
                        <td>
                            <a href="edit_pelanggan.php?id=<?php echo $row['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i></a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus pelanggan ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>