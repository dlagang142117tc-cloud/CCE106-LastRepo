<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // 🔹 For now just dummy accounts (no DB yet)
    if ($role === 'student' && $username === 'jison' && $password === '1234') {
        $_SESSION['role'] = 'student';
        $_SESSION['name'] = 'JAYSON CIPRO';
        $_SESSION['username'] = $username;
        header('Location: student_dashboard.php'); exit;
    }
    if ($role === 'staff' && $username === 'staff01' && $password === '1234') {
        $_SESSION['role'] = 'staff';
        $_SESSION['name'] = 'Nurse Santos';
        header('Location: staff_dashboard.php'); exit;
    }

    if ($role === 'sta' && $username === 'sta01' && $password === '1234') {
        $_SESSION['role'] = 'sta';
        $_SESSION['name'] = 'STA USER';
        header('Location: sta_dashboard.php'); exit;
    }

    $error = "Invalid login (dummy data).";
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>UM Visayan Clinic Login</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="center-container">

    <div class="login-box">
      <!-- UM Logo -->
      <div class="logo-container">
        <img src="asset/images/um_logo_no_bg.png" >
      </div>
      <h2>Login</h2>
      <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
      <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <select name="role">
          <option value="student">Student</option>
          <option value="staff">Staff</option>
          <option value="sta">Sta</option>
        </select><br>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>