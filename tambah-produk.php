<?php
session_start();
include "db.php";

// Cek login
if(!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true){ 
    echo '<script>window.location="login.php"</script>'; 
    exit();
}

// Ambil data kategori untuk dropdown
$kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY category_name ASC");

if(isset($_POST['submit'])){
    // ambil data dari formulir
    $category_id = $_POST['category_id'];
    $nama = $_POST['product_name'];
    $harga = $_POST['product_price'];
    $deskripsi = $_POST['product_description'];
    $status = $_POST['product_status'];
    
    // ambil data file
    $filename = $_FILES['product_image']['name'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    
    $type1 = explode('.', $filename);
    $type2 = $type1[1];
    
    $newname = 'produk'.time().'.'.$type2;
    
    // menampung data format file yang diizinkan
    $tipe_diizinkan = array('jpg', 'jpeg', 'png', 'gif');
    
    // validasi format file
    if(!in_array($type2, $tipe_diizinkan)){
        // jika format file tidak ada di dalam tipe diizinkan
        echo '<script>alert("Format file tidak diizinkan")</script>';
    } else {
        // jika format file sesuai dengan yang ada di dalam array tipe diizinkan
        // proses upload file sekaligus insert ke database
        move_uploaded_file($tmp_name, './produk/'.$newname);
        
        $insert = mysqli_query($conn, "INSERT INTO tb_product VALUES (
                    null,
                    '".$category_id."',
                    '".$nama."',
                    '".$harga."',
                    '".$deskripsi."',
                    '".$newname."',
                    '".$status."',
                    null
                ) ");
        if($insert){
            echo '<script>alert("Tambah data berhasil")</script>';
            echo '<script>window.location="data-produk.php"</script>';
        } else {
            echo '<script>alert("Tambah data gagal")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Produk | Bukawarung</title>
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
            <h3>Tambah Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <table>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>
                                <select class="input-control" name="category_id" required>
                                    <option value="">--Pilih--</option>
                                    <?php while($r = mysqli_fetch_array($kategori)){ ?>
                                    <option value="<?php echo $r['category_id'] ?>"><?php echo $r['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="product_name" class="input-control" placeholder="Nama Produk" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td>:</td>
                            <td>
                                <input type="number" name="product_price" class="input-control" placeholder="Harga Produk" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>:</td>
                            <td>
                                <textarea class="input-control" name="product_description" placeholder="Deskripsi Produk"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Gambar</td>
                            <td>:</td>
                            <td>
                                <input type="file" name="product_image" class="input-control" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>
                                <select class="input-control" name="product_status" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="submit" value="Submit" class="btn"></td>
                        </tr>
                    </table>
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