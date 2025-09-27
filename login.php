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
  <link rel="icon" type="image/png" href="asset/images/um_logo_no_bg.png">
</head>
<body>
  <div class="center-container">

    <div class="login-box" id="loginBox">
      <div class="logo-container">
        <img src="asset/images/um_logo_no_bg.png" >
      </div>
      <h2>Login</h2>
      <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
      <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <div class="password-box">
          <input type="password" id="loginPassword" name="password" placeholder="Password" required>
          <img src="asset/images/eye-close.png" id="toggleLoginPwdImg" alt="Toggle password visibility">
        </div>
        <select name="role">
          <option value="student">Student</option>
          <option value="staff">Staff</option>
          <option value="sta">STA</option>
        </select><br>
        <button type="submit">Login</button>
      </form>

      <div class="register-cta">
        <p>Don't have an account?</p>
        <button type="button" id="showRegisterBtn">Register</button>
      </div>
    </div>

    <!-- Registration Box (layout only) -->
    <div class="register-box" id="registerBox" hidden>
      <h2>Register</h2>
      <form onsubmit="return false;">
        <input type="text" name="reg_id" placeholder="ID Number (Username)" required>
        <div class= "password-box"> 
          <input type="password" id="regPassword" name="reg_password" placeholder="Password" required>
          <img src="asset/images/eye-close.png" id="toggleRegPwdImg" alt="Toggle password visibility">
        </div>
        <select name="reg_role" required>
          <option value="student">Student</option>
          <option value="staff">Staff</option>
          <option value="sta">STA</option>
        </select>
        <button type="button" id="registerNowBtn">Register</button>
        <p class="note">Note: This is a layout only. Hook this form to your database later.</p>
      </form>
      <div class="register-actions">
        <button type="button" id="backToLoginBtn" class="secondary">Back to Login</button>
      </div>
    </div>
  </div>
  <script>
    (function() {
      var showBtn = document.getElementById('showRegisterBtn');
      var regBox = document.getElementById('registerBox');
      var backBtn = document.getElementById('backToLoginBtn');
      var loginBox = document.getElementById('loginBox');

      function showRegisterOnly() {
        if (loginBox) loginBox.style.display = 'none';
        if (regBox) regBox.hidden = false;
        try { regBox && regBox.scrollIntoView({ behavior: 'smooth', block: 'center' }); } catch(e) {}
      }
      function showLoginOnly() {
        if (regBox) regBox.hidden = true;
        if (loginBox) loginBox.style.display = '';
        try { loginBox && loginBox.scrollIntoView({ behavior: 'smooth', block: 'center' }); } catch(e) {}
      }

      if (showBtn) {
        showBtn.addEventListener('click', showRegisterOnly);
      }
      if (backBtn) {
        backBtn.addEventListener('click', showLoginOnly);
      }

      var regNow = document.getElementById('registerNowBtn');
      if (regNow) {
        regNow.addEventListener('click', function() {
          alert('Registration layout only. Connect to your database to enable this.');
        });
      }

      // Toggle visibility for Register password using the eye image
      var regPwdInput = document.getElementById('regPassword');
      var regEye = document.getElementById('toggleRegPwdImg');
      if (regPwdInput && regEye) {
        regEye.addEventListener('click', function() {
          var hidden = regPwdInput.getAttribute('type') === 'password';
          regPwdInput.setAttribute('type', hidden ? 'text' : 'password');
          // swap icon if the open eye exists; fallback to keep same icon
          var openSrc = 'asset/images/eye-open.png';
          var closeSrc = 'asset/images/eye-close.png';
          try {
            regEye.src = hidden ? openSrc : closeSrc;
          } catch(e) {}
        });
      }

      // Toggle visibility for Login password using the eye image
      var loginPwdInput = document.getElementById('loginPassword');
      var loginEye = document.getElementById('toggleLoginPwdImg');
      if (loginPwdInput && loginEye) {
        loginEye.addEventListener('click', function() {
          var hidden = loginPwdInput.getAttribute('type') === 'password';
          loginPwdInput.setAttribute('type', hidden ? 'text' : 'password');
          var openSrc = 'asset/images/eye-open.png';
          var closeSrc = 'asset/images/eye-close.png';
          try {
            loginEye.src = hidden ? openSrc : closeSrc;
          } catch(e) {}
        });
      }
    })();
  </script>
</body>
</html>