<?php
include 'db.php';

// Hapus Kategori
if (isset($_GET['idk'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '" . $_GET['idk'] . "' ");
    echo '<script>window.location="data-kategori.php"</script>';
}

// Hapus Produk
if (isset($_GET['idp'])) {
    // Ambil data produk berdasarkan ID
    $produk = mysqli_query($conn, "SELECT product_image FROM tb_product WHERE product_id = '" . $_GET['idp'] . "' ");
    $p = mysqli_fetch_object($produk);

    // Hapus file gambar jika ada
    if ($p && file_exists('./produk/' . $p->product_image)) {
        unlink('./produk/' . $p->product_image);
    }

    // Hapus data dari database
    $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id = '" . $_GET['idp'] . "' ");
    echo '<script>window.location="data-produk.php"</script>';
}
?>
