<?php
session_start();
$error = '';
$success = '';

// 🔹 Connect to MySQL
$mysqli = new mysqli("localhost", "root", "", "clinic_db"); 
if ($mysqli->connect_errno) {
    die("DB connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // LOGIN PROCESS
    if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        $stmt = $mysqli->prepare("SELECT id, first_name, last_name, password, role FROM users WHERE id_number=? AND role=?");
        $stmt->bind_param("ss", $username, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['role'] = $row['role'];
                $_SESSION['name'] = $row['first_name'] . " " . $row['last_name'];
                $_SESSION['username'] = $username;

                if ($row['role'] === 'student') header('Location: student_dashboard.php');
                if ($row['role'] === 'staff') header('Location: staff_dashboard.php');
                //if ($row['role'] === 'sta') header('Location: sta_dashboard.php');
                if ($row['role'] === 'sta') header('Location: staff_dashboard.php'); // Since STA and Staff Have same Dashboard
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Invalid username or role.";
        }
        $stmt->close();
    }

    // REGISTRATION PROCESS
    if (isset($_POST['reg_id'], $_POST['reg_password'], $_POST['reg_role'], $_POST['first_name'], $_POST['last_name'])) {
        $id_number = trim($_POST['reg_id']);
        $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
        $role = $_POST['reg_role'];
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);

        // check if username already exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE id_number=?");
        $stmt->bind_param("s", $id_number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "ID number already exists.";
        } else {
            $stmt->close();
            $stmt = $mysqli->prepare("INSERT INTO users (first_name, last_name, id_number, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $id_number, $password, $role);
            if ($stmt->execute()) {
                $success = "Registration successful. You may now login.";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
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

    <!-- LOGIN BOX -->
    <div class="login-box" id="loginBox">
      <div class="logo-container">
        <img src="asset/images/um_logo_no_bg.png" >
      </div>
      <h2>Login</h2>
      <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
      <?php if($success): ?><p style="color:green;font-weight:bold;"><?=$success?></p><?php endif; ?>
      <form method="post">
        <input type="text" name="username" placeholder="ID Number" required><br>
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

    <!-- REGISTRATION BOX -->
    <div class="register-box" id="registerBox" hidden>
      <h2>Register</h2>
      <?php if($error): ?><p class="error"><?=$error?></p><?php endif; ?>
      <?php if($success): ?><p style="color:green;font-weight:bold;"><?=$success?></p><?php endif; ?>
      <form method="post">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
        <input type="text" name="reg_id" placeholder="ID Number (Username)" required>
        <div class="password-box"> 
          <input type="password" id="regPassword" name="reg_password" placeholder="Password" required>
          <img src="asset/images/eye-close.png" id="toggleRegPwdImg" alt="Toggle password visibility">
        </div>
        <select name="reg_role" required>
          <option value="student">Student</option>
          <option value="staff">Staff</option>
          <option value="sta">STA</option>
        </select>
        <button type="submit">Register</button>
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

      if (showBtn) showBtn.addEventListener('click', showRegisterOnly);
      if (backBtn) backBtn.addEventListener('click', showLoginOnly);

      // Toggle Register password visibility
      var regPwdInput = document.getElementById('regPassword');
      var regEye = document.getElementById('toggleRegPwdImg');
      if (regPwdInput && regEye) {
        regEye.addEventListener('click', function() {
          var hidden = regPwdInput.getAttribute('type') === 'password';
          regPwdInput.setAttribute('type', hidden ? 'text' : 'password');
          regEye.src = hidden ? 'asset/images/eye-open.png' : 'asset/images/eye-close.png';
        });
      }

      // Toggle Login password visibility
      var loginPwdInput = document.getElementById('loginPassword');
      var loginEye = document.getElementById('toggleLoginPwdImg');
      if (loginPwdInput && loginEye) {
        loginEye.addEventListener('click', function() {
          var hidden = loginPwdInput.getAttribute('type') === 'password';
          loginPwdInput.setAttribute('type', hidden ? 'text' : 'password');
          loginEye.src = hidden ? 'asset/images/eye-open.png' : 'asset/images/eye-close.png';
        });
      }
    })();
  </script>
</body>
</html>
