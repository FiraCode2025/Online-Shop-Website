<?php
session_start();
include "db.php";

// Cek login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){ 
    echo '<script>window.location="login.php"</script>'; 
    exit();
}

// Proses form tambah kategori
if(isset($_POST['submit'])){
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    
    // Validasi input
    if(empty($kategori)){
        echo '<script>alert("Nama kategori tidak boleh kosong!")</script>';
    } else {
        // Cek apakah kategori sudah ada
        $cek = mysqli_query($conn, "SELECT * FROM tb_category WHERE category_name='$kategori'");
        if(mysqli_num_rows($cek) > 0){
            echo '<script>alert("Kategori sudah ada!")</script>';
        } else {
            // Insert data kategori
            $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES (
                '',
                '$kategori'
            )");
            
            if($insert){
                echo '<script>alert("Tambah data berhasil"); window.location="data-kategori.php"</script>';
            } else {
                echo '<script>alert("Tambah data gagal")</script>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Kategori | Bukawarung</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
            <h1><a href="dashboard.php">Bukawarung</a></h1>
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
            <h3>Tambah Data Kategori</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="kategori" placeholder="Nama Kategori" class="input-control" required>
                    <input type="submit" name="submit" value="Submit" class="btn">
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