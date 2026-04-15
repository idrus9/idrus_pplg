<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengambil total penjualan untuk statistik
$total_sales = mysqli_query($conn, "SELECT SUM(harga) as total FROM mod_sales");
$res_total = mysqli_fetch_assoc($total_sales);

$total_pembeli = mysqli_query($conn, "SELECT COUNT(*) as jml FROM mod_sales");
$res_pembeli = mysqli_fetch_assoc($total_pembeli);

// 1. Definisikan variabel dengan nilai default agar tidak 'Undefined'
$mod_terpopuler = "Belum ada data";

$query_populer = mysqli_query($conn, "SELECT mods.nama_mod, COUNT(transaksi.id_mod) AS total_beli 
                                      FROM transaksi 
                                      JOIN mods ON transaksi.id_mod = mods.id_mod 
                                      GROUP BY transaksi.id_mod 
                                      ORDER BY total_beli DESC 
                                      LIMIT 1");

if ($query_populer && mysqli_num_rows($query_populer) > 0) {
    $res_populer = mysqli_fetch_assoc($query_populer);
    $mod_terpopuler = $res_populer['nama_mod'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameMod Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #6c5ce7;
            --secondary: #a29bfe;
            --accent: #fd79a8;
            --bg: #f0f3f7;
            --sidebar-grad: linear-gradient(180deg, #6c5ce7 0%, #a29bfe 100%);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { display: flex; background: var(--bg); min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px; background: var(--sidebar-grad); color: white;
            padding: 30px 20px; position: fixed; height: 100%; display: flex; flex-direction: column;
        }
        .sidebar h2 { text-align: center; margin-bottom: 40px; letter-spacing: 1px; }
        .sidebar a {
            color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px;
            margin: 5px 0; border-radius: 10px; display: flex; align-items: center; transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.2); color: white; }
        .sidebar a i { margin-right: 15px; width: 20px; }

        /* MAIN CONTENT STYLE */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-info img { width: 40px; border-radius: 50%; border: 2px solid var(--primary); }

        /* CARDS STYLE */
        .cards-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .card {
            padding: 25px;
            border-radius: 20px;
            color: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card:hover { transform: translateY(-5px); }
        .card-1 { background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); }
        .card-2 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
        .card-3 { background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); }
        
        .card h3 { font-size: 14px; opacity: 0.8; text-transform: uppercase; }
        .card h1 { font-size: 28px; margin-top: 10px; }

        /* TABLE STYLE */
        .recent-sales {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .recent-sales h2 { margin-bottom: 20px; color: #2d3436; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: #b2bec3; font-weight: 500; border-bottom: 2px solid #f0f3f7; }
        td { padding: 15px; border-bottom: 1px solid #f0f3f7; color: #636e72; }
        .status { padding: 5px 12px; border-radius: 20px; font-size: 12px; background: #e3fcef; color: #00b894; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>GAMEMOD</h2>
        <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
        <a href="penjualan.php"><i class="fas fa-shopping-cart"></i> Transaksi</a>
        <a href="mod_list.php"><i class="fas fa-gamepad"></i> Daftar Game</a>
       <a href="pelanggan.php"><i class="fas fa-users"></i> Daftar Pelanggan</a>
         <a href="logout.php" style="color: #ff7675;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <div>
                <h1>Halo! 👋</h1>
                <p style="color: #636e72;">Selamat Datang!, Di idrus.S store penyedia mod game!.</p>
            </div>
            <div class="user-info">
                <span>Admin Panel</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=6c5ce7&color=fff" alt="User">
            </div>
        </div>

        <div class="cards-container">
            <div class="card card-1">
                <h3>Total Pendapatan</h3>
                <h1>Rp <?php echo number_format($res_total['total'] ? $res_total['total'] : 0); ?></h1>
            </div>
            <div class="card card-2">
                <h3>Total Pembeli</h3>
                <h1><?php echo $res_pembeli['jml']; ?> Orang</h1>
            </div>
            <div class="card card-3">
    <h3>Mod Terpopuler</h3>
    <h1><?php echo $mod_terpopuler; ?></h1>
</div>
    </div>

        <div class="recent-sales">
            <h2>Aktivitas Penjualan Terakhir</h2>
            <table>
                <thead>
                    <tr>
                        <th>Pembeli</th>
                        <th>Game</th>
                        <th>Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $latest = mysqli_query($conn, "SELECT * FROM mod_sales ORDER BY id DESC LIMIT 5");
                    while($row = mysqli_fetch_assoc($latest)):
                    ?>
                    <tr>
                        <td><strong><?php echo $row['nama_pembeli']; ?></strong></td>
                        <td><?php echo $row['nama_game']; ?></td>
                        <td>Rp <?php echo number_format($row['harga']); ?></td>
                        <td><span class="status">Selesai</span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>