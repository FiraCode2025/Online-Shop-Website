<?php
session_start();
include "db.php";

// Cek login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){ 
    echo '<script>window.location="login.php"</script>'; 
    exit();
}

// Ambil ID kategori dari URL
$kategori_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data kategori berdasarkan ID
$kategori = mysqli_query($conn, "SELECT * FROM tb_category WHERE category_id='$kategori_id'");
if(mysqli_num_rows($kategori) == 0){
    echo '<script>alert("Data tidak ditemukan"); window.location="data-kategori.php"</script>';
    exit();
}
$k = mysqli_fetch_array($kategori);

// Proses form edit kategori
if(isset($_POST['submit'])){
    $kategori_name = mysqli_real_escape_string($conn, $_POST['kategori']);
    
    // Validasi input
    if(empty($kategori_name)){
        echo '<script>alert("Nama kategori tidak boleh kosong!")</script>';
    } else {
        // Cek apakah kategori sudah ada (kecuali kategori yang sedang diedit)
        $cek = mysqli_query($conn, "SELECT * FROM tb_category WHERE category_name='$kategori_name' AND category_id != '$kategori_id'");
        if(mysqli_num_rows($cek) > 0){
            echo '<script>alert("Kategori sudah ada!")</script>';
        } else {
            // Update data kategori
            $update = mysqli_query($conn, "UPDATE tb_category SET 
                category_name='$kategori_name'
                WHERE category_id='$kategori_id'
            ");
            
            if($update){
                echo '<script>alert("Ubah data berhasil"); window.location="data-kategori.php"</script>';
            } else {
                echo '<script>alert("Ubah data gagal")</script>';
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
    <title>Edit Kategori | Bukawarung</title>
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
            <h3>Edit Data Kategori</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="kategori" placeholder="Nama Kategori" class="input-control" 
                           value="<?php echo htmlspecialchars($k['category_name']) ?>" required>
                    <input type="submit" name="submit" value="Ubah" class="btn">
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