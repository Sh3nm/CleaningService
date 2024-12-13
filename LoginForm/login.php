<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cleaning_service";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'login') {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                // Corrected redirect to the correct path
                header("Location: /Cleaning%20Service/Cleaning%20Service/index.html");
                exit();
            } else {
                $error = "Password salah.";
            }
            
        } else {
            $error = "Email tidak ditemukan.";
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] === 'register') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if ($password !== $confirm_password) {
            $error = "Password dan konfirmasi password tidak cocok.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error = "Email sudah terdaftar.";
            } else {
                $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Terjadi kesalahan saat mendaftar: " . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <title>Login & Register</title>
</head>
<body>
  <div class="form-container">
    <div class="col-1">
      <div class="layer-image">
        <img src="pakvincent.jpeg" alt="Vincent Logo" class="form-image-main"> </div>
      <p class="featured-words">Aku Mau Dua<span></span></p>
    </div>
    <div class="col-2">
      <div class="btn-box">
        <button class="btn btn-1" onclick="showLoginForm()">Sign In</button>
        <button class="btn btn-2" onclick="showRegisterForm()">Sign Up</button>
      </div>

      <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

      <form id="loginForm" method="POST" class="login-form">
        <input type="hidden" name="form_type" value="login">
        <div class="form-title">Sign In</div>
        <div class="form-inputs">
          <div class="input-box">
            <input type="email" name="email" class="input-field" placeholder="Email" required>
            <i class="bx bx-envelope"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <i class="bx bx-lock-alt"></i>
          </div>
          <div class="input-box">
            <button class="input-submit" type="submit">Sign In</button>
          </div>
        </div>
      </form>

      <form id="registerForm" method="POST" class="register-form">
        <input type="hidden" name="form_type" value="register">
        <div class="form-title">Create Account</div>
        <div class="form-inputs">
          <div class="input-box">
            <input type="text" name="name" class="input-field" placeholder="Full Name" required>
            <i class="bx bx-user"></i>
          </div>
          <div class="input-box">
            <input type="email" name="email" class="input-field" placeholder="Email" required>
            <i class="bx bx-envelope"></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            <i class="bx bx-lock-alt"></i>
          </div>
          <div class="input-box">
            <input type="password" name="confirm_password" class="input-field" placeholder="Confirm Password" required>
            <i class="bx bx-lock-alt"></i>
          </div>
          <div class="input-box">
            <button class="input-submit" type="submit">Sign Up</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    function showLoginForm() {
      document.querySelector('.login-form').style.display = 'contents';
      document.querySelector('.register-form').style.display = 'none';
    }

    function showRegisterForm() {
      document.querySelector('.login-form').style.display = 'none';
      document.querySelector('.register-form').style.display = 'contents';
    }
  </script>
  <script src="main.js"></script>

</body>
</html
