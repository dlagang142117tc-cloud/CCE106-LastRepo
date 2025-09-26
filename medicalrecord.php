<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clinic Records</title>
  <link rel="stylesheet" href="record.css" />
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="appSidebar">
    <h2>UM Clinic</h2>
    <ul>
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
        <li><a href="schedule.php">📅 Next Schedule </a></li>
        <li><a href="history.php">📜 History </a></li>
      <?php else: ?>
        <li><a href="staff_dashboard.php">🏠 Dashboard</a></li>
        <li><a href="medicalrecord.php">➕ Medical Records</a></li>
        <li><a href="inventory.php">📦 Manage Inventory</a></li>
        <li><a href="record.php">👨🏻‍⚕️ Manage Patients</a></li>
        <li><a href="#">📅 Appointments</a></li>
      <?php endif; ?>
    </ul>
  </div>

  <!-- Sidebar Toggle -->
  <button type="button" class="sidebar-launcher" id="sidebarToggleBtn" aria-label="Toggle sidebar">
    <img src="asset/images/um_logo_no_bg.png" alt="Sidebar" style="width:40px;height:auto;" />
  </button>

  <div class="top-header">
        <button id="toggleSidebar" class="icon-btn">☰</button>
            <div class="welcome-text">
                <h1>PATIENT INFO</h1>
            </div>
        <div class="header-actions">
            <form action="logout.php" method="POST" style="display:inline;">
            <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="record">

      <!-- STUDENT INFO -->
      <div class="patient-div">
            <h2 class="section-title">PATIENT INFO</h2>
            <div class="action-buttons">
            <button class="add-btn">Add</button>
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Delete</button>
            </div>

            <table class="student">
            <tr>
                <th>ID No.</th>
                <th>Name</th>
                <th>Age</th>
                <th>Role</th>
                <th>Address</th>
                <th>Contact Number</th>
            </tr>
            <tr>
                <td>142455</td>
                <td>Marc Jason Alagase</td>
                <td>20</td>
                <td>Professor</td>
                <td>Tagum City</td>
                <td>0987654321</td>
            </tr>
            <tr>
                <td>142456</td>
                <td>Denns Lawrence Lagang</td>
                <td>20</td>
                <td>Student</td>
                <td>Tagum City</td>
                <td>0987654321</td>
            </tr>
            <tr>
                <td>142457</td>
                <td>Paul Daniel Varon</td>
                <td>20</td>
                <td>Professor</td>
                <td>Tagum City</td>
                <td>0987654321</td>
            </tr>
            <tr>
                <td>142458</td>
                <td>Ireneo Barayuga</td>
                <td>20</td>
                <td>Student</td>
                <td>Tagum City</td>
                <td>0987654321</td>
            </tr>
            </table>
      </div>
  </div>

  <script>
  // Sidebar toggle script
  (function() {
      const sidebar = document.getElementById('appSidebar');
      const toggleBtn = document.getElementById('sidebarToggleBtn');
      function toggleSidebar() {
          sidebar.classList.toggle('open');
      }
      toggleBtn.addEventListener('click', toggleSidebar);
  })();
  </script>
</body>
</html>
