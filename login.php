<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | penjualan online</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #e5e5e5;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background: #fff;
      padding: 40px 25px;
      border-radius: 10px;
      width: 100%;
      max-width: 360px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      box-sizing: border-box;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
      font-size: 22px;
    }

    .input-control {
      width: 100%;
      padding: 12px 14px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
      box-sizing: border-box;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #218838;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 12px;
      color: #777;
    }

    @media (max-width: 480px) {
      .login-container {
        margin: 0 15px;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Login</h2>
    <form method="POST">
      <input type="text" name="user" placeholder="Username" class="input-control" required>
      <input type="password" name="pass" placeholder="Password" class="input-control" required>
      <input type="submit" name="submit" value="Login" class="btn">
    </form>

    <?php
    if (isset($_POST['submit'])) {
      session_start();
      include 'db.php';

      $user = mysqli_real_escape_string($conn, $_POST['user']);
      $pass = $_POST['pass'];

      $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$user' AND password = '$pass'");

      if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);

        $admin_obj = new stdClass();
        $admin_obj->admin_id = $data['admin_id'] ?? '';
        $admin_obj->admin_name = $data['admin_name'] ?? ($data['username'] ?? 'Admin');
        $admin_obj->username = $data['username'] ?? '';
        $admin_obj->admin_telp = $data['admin_telp'] ?? '';
        $admin_obj->admin_email = $data['admin_email'] ?? '';
        $admin_obj->admin_address = $data['admin_address'] ?? '';

        $_SESSION['status_login'] = true;
        $_SESSION['a_global'] = $admin_obj;

        echo '<script>window.location="dashboard.php"</script>';
        exit();
      } else {
        echo "<script>alert('Username atau password salah!');</script>";
      }
    }
    ?>

    <div class="footer">©2025 penjualan online</div>
  </div>

</body>
</html>
