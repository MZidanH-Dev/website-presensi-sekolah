<?php
session_start();
// Destroy any existing session when accessing login page
session_destroy();
session_start(); // Start fresh session

include 'koneksi.php';

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    
    // Cek di tabel admin
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        if(password_verify($password, $data['password'])) {
            $_SESSION['admin'] = $data;
            header("Location: admin/data_siswa.php");
            exit();
        }
    }
    
    // Cek di tabel guru
    $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE username='$username'");
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        if(password_verify($password, $data['password'])) {
            $_SESSION['guru'] = $data;
            header("Location: guru/data_siswa.php");
            exit();
        }
    }
    
    // Cek di tabel siswa
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE username='$username'");
    if(mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_array($query);
        if(password_verify($password, $data['password'])) {
            $_SESSION['siswa'] = $data;
            header("Location: siswa/data_presensi.php");
            exit();
        }
    }
    
    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Presensi</title>
    <link rel="stylesheet" href="style2.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <form action="" method="POST" class="login-form">
            <h1><i class="fas fa-user"></i> Login</h1>
            <?php if(isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div>
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html> 