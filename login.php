<?php
include 'config.php';
session_start();

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Menggunakan MD5 sesuai permintaan

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Page</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 350px;
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        h2 { text-align: center; margin-bottom: 20px; letter-spacing: 2px; }
        .input-group { margin-bottom: 20px; }
        input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(255,255,255,0.2);
            color: white;
            outline: none;
        }
        input::placeholder { color: #ddd; }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #fff;
            color: #764ba2;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { background: #f0f0f0; transform: scale(1.02); }
        .error { color: #ff8080; font-size: 14px; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>LOGIN</h2>
    <?php if($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form action="" method="POST">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="login">Masuk</button>
    </form>
</div>

</body>
</html>