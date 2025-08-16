<?php
session_start();
include "db.php";

// Cek apakah user sudah login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){ 
    echo '<script>window.location="login.php"</script>'; 
    exit();
}

// Ambil data admin dari session dengan pengecekan
$admin_id = '';
if(isset($_SESSION['a_global']) && isset($_SESSION['a_global']->admin_id)){
    $admin_id = $_SESSION['a_global']->admin_id;
} else {
    echo '<script>alert("Session tidak valid!"); window.location="login.php";</script>';
    exit();
}

// Ambil data terbaru dari database
$query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE admin_id='$admin_id'");
if (!$query) {
    echo '<script>alert("Error database: ' . mysqli_error($conn) . '"); window.location="dashboard.php";</script>';
    exit();
}
$data = mysqli_fetch_array($query);

// Jika tidak ada data, redirect ke login
if(!$data){
    echo '<script>alert("Data admin tidak ditemukan!"); window.location="login.php";</script>';
    exit();
}

// Proses form ubah profil
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $user = mysqli_real_escape_string($conn, $_POST['user']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    $update = mysqli_query($conn, "UPDATE tb_admin SET 
        admin_name='$nama', 
        username='$user', 
        admin_telp='$hp', 
        admin_email='$email', 
        admin_address='$alamat' 
        WHERE admin_id='$admin_id'");
    
    if ($update) {
        // Update session data dengan pengecekan
        if(isset($_SESSION['a_global'])){
            $_SESSION['a_global']->admin_name = $nama;
            $_SESSION['a_global']->username = $user;
            $_SESSION['a_global']->admin_telp = $hp;
            $_SESSION['a_global']->admin_email = $email;
            $_SESSION['a_global']->admin_address = $alamat;
        }
        
        echo "<script>alert('Profil berhasil diupdate!'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal update profil!');</script>";
    }
}

// Proses form ubah password
if (isset($_POST['ubah_password'])) {
    $password_baru = mysqli_real_escape_string($conn, $_POST['password_baru']);
    $konfirmasi_password = mysqli_real_escape_string($conn, $_POST['konfirmasi_password']);
    
    // Validasi password
    if ($password_baru != $konfirmasi_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } elseif (strlen($password_baru) < 6) {
        echo "<script>alert('Password minimal 6 karakter!');</script>";
    } else {
        // Hash password dengan MD5 (sesuai dengan login)
        $password_hash = md5($password_baru);
        
        $update_password = mysqli_query($conn, "UPDATE tb_admin SET 
            password='$password_hash' 
            WHERE admin_id='$admin_id'");
        
        if ($update_password) {
            echo "<script>alert('Password berhasil diubah!'); window.location='profil.php';</script>";
        } else {
            echo "<script>alert('Gagal mengubah password!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil | Bukawarung</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">penjualan online</a></h1>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="data-kategori.php">Data Kategori</a></li>
                <li><a href="data-produk.php">Data Produk</a></li>
                <li><a href="keluar.php">Keluar</a></li>
            </ul>
        </div>
    </header>

    <!-- content -->
    <div class="section">
        <div class="container">
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" 
                           value="<?php echo isset($data['admin_name']) ? htmlspecialchars($data['admin_name']) : ''; ?>">
                    
                    <input type="text" name="user" placeholder="Username" class="input-control" 
                           value="<?php echo isset($data['username']) ? htmlspecialchars($data['username']) : ''; ?>">
                    
                    <input type="text" name="hp" placeholder="No Hp" class="input-control" 
                           value="<?php echo isset($data['admin_telp']) ? htmlspecialchars($data['admin_telp']) : ''; ?>">
                    
                    <input type="email" name="email" placeholder="Email" class="input-control" 
                           value="<?php echo isset($data['admin_email']) ? htmlspecialchars($data['admin_email']) : ''; ?>">
                    
                    <input type="text" name="alamat" placeholder="Alamat" class="input-control" 
                           value="<?php echo isset($data['admin_address']) ? htmlspecialchars($data['admin_address']) : ''; ?>">
                    
                    <input type="submit" name="submit" value="Ubah Profil" class="btn">
                </form>
            </div>

            <h3>Ubah Password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="password_baru" placeholder="Password Baru" class="input-control">
                    
                    <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password Baru" class="input-control">
                    
                    <input type="submit" name="ubah_password" value="Ubah Password" class="btn">
                </form>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2025 - penjualan online.</small>
        </div>
    </footer>
</body>
</html>