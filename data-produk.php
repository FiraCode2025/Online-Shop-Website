<?php
session_start();
include "db.php";

// Cek login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){ 
    echo '<script>window.location="login.php"</script>'; 
    exit();
}

// Ambil data produk dari database dengan join ke tabel kategori
$produk = mysqli_query($conn, "SELECT p.*, c.category_name FROM tb_product p 
                               LEFT JOIN tb_category c ON p.category_id = c.category_id 
                               ORDER BY p.product_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Produk | Bukawarung</title>
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
            <h3>Data Produk</h3>
            <div class="box">
                <p><a href="tambah-produk.php">Tambah Data</a></p>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($produk) > 0){
                            $no = 1;
                            while($row = mysqli_fetch_array($produk)){
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']) ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']) ?></td>
                            <td>Rp. <?php echo number_format($row['product_price']) ?></td>
                            <td><a href="produk/<?php echo $row['product_image'] ?>" target="_blank">
                                <img src="produk/<?php echo $row['product_image'] ?>" width="50px">
                            </a></td>
                            <td><?php echo ($row['product_status'] == 0)? 'Tidak Aktif':'Aktif'; ?></td>
                            <td>
                                <a href="edit-produk.php?id=<?php echo $row['product_id'] ?>">Edit</a> || 
                                <a href="proses-hapus.php?idp=<?php echo $row['product_id'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php }} else { ?>
                        <tr>
                            <td colspan="7">Tidak ada data</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
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