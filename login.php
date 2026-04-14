<?php
// Sertakan koneksi database
include 'koneksi.php';

// Memulai session
session_start();

// Jika tombol login ditekan
if (isset($_POST['login'])) {
    // Ambil data dari form dan amankan dari SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Tetap menggunakan MD5 sesuai permintaan

    // Query untuk cek user
    $query  = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    // Cek apakah data ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Set session
        $_SESSION['user'] = $data['username'];
        $_SESSION['status'] = "login";

        // Alihkan ke dashboard
        header("Location: dashboard.php");
        exit(); // Pastikan script berhenti setelah redirect
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Cafe Cianjur</title>
    <style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1501339819398-ed4fc1ad5ad7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }
        .login-box { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0px 10px 25px rgba(0,0,0,0.3); 
            width: 100%;
            max-width: 350px;
            text-align: center;
        }
        h2 { color: #5D4037; margin-bottom: 20px; }
        input { 
            display: block; 
            width: 100%; 
            margin-bottom: 15px; 
            padding: 12px; 
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }
        input:focus { border-color: #6F4E37; }
        button { 
            width: 100%; 
            padding: 12px; 
            background: #6F4E37; 
            color: white; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover { background: #5D4037; }
        .error-msg {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Coffee Admin</h2>
        
        <?php if(isset($error)): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">MASUK</button>
        </form>
        <p style="font-size: 12px; color: #777; margin-top: 20px;">© 2026 Rekomendasi Cafe Cianjur</p>
    </div>
</body>
</html>