<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clinic Records</title>
  <link rel="stylesheet" href="appointment.css?v=1" />
  <link rel="icon" type="image/png" href="asset/images/um_logo_no_bg.png">
</head>
<body>
<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">
         <h2 class="js-sidebar-trigger">UM CLINIC</h2>
            <ul>
            <?php if ($_SESSION['role'] === 'staff'): ?>
                <li><a href="staff_dashboard.php" class="<?php echo ($currentPage === 'staff_dashboard.php') ? 'active' : ''; ?>">🏠Staff Dashboard</a></li>
                <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical Records</a></li>
                <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 Manage Inventory</a></li>
                <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">👨🏻‍⚕️ Manage Patients</a></li>
                <li><a href="appointment.php" class="<?php echo ($currentPage === 'appointment.php') ? 'active' : ''; ?>">📅 Appointments</a></li>
            <?php elseif ($_SESSION['role'] === 'sta'): ?>
                <li><a href="sta_dashboard.php" class="<?php echo ($currentPage === 'sta_dashboard.php') ? 'active' : ''; ?>">🏠 STA Dashboard</a></li>
                <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical Records</a></li>
                <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 Manage Inventory</a></li>
                <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">👨🏻‍⚕️ Manage Patients</a></li>
            <?php endif; ?>
            </ul>
            <ul class="bottom">
                <li><a href="logs.php" class="<?php echo ($currentPage === 'logs.php') ? 'active' : ''; ?>">📝Logs</a></li>
            </ul>
    </div>

    <!-- Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Launcher -->
    <button type="button" class="sidebar-launcher" id="sidebarToggleBtn" aria-label="Toggle sidebar">
        <img src="asset/images/sidebar.png" alt="Sidebar" style="width:40px;height:auto;" />
    </button>

    <!-- === MAIN CONTENT === -->
    <div class="main">

        <!-- Top Header -->
        <div class="top-header">
            <div class="welcome-text">
                <h1>APPOINTMENTS</h1>
            </div>
            <div class="header-actions">
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <!-- Records -->
        <div class="record">
            <div class="patient-div">
                <div class="action-buttons">
                    <button class="add-btn">Add</button>
                    <button class="edit-btn">Edit</button>
                </div>

                <table class="patients">
                    <tr>
                        <th>Name</th>
                        <th>Staff</th>
                        <th>Last Consultation</th>
                        <th>Next Consultation</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                        <th>Status 
                            <select class="status-filter">
                                <option value="all" selected>All</option>
                                <option value="Completed">Completed</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </th>
                    </tr>
                    <tr>
                        <td>Marc Jason Alagase</td>
                        <td>Sir Delacruz</td>
                        <td>09-20-2025</td>
                        <td>09-30-2025</td>
                        <td>Doc. Willie Ong</td>
                        <td>Fever</td>
                        <td>Canceled</td>
                    </tr>
                    <tr>
                        <td>Kaichi Espiritu</td>
                        <td>Sir Doidoi</td>
                        <td>09-21-2025</td>
                        <td>10-11-2025</td>
                        <td>Doc. Santos</td>
                        <td>Stomach problems</td>
                        <td>Completed</td>
                    </tr>
                    <tr>
                        <td>Denns Lagang</td>
                        <td>Sir Neil</td>
                        <td>09-20-2025</td>
                        <td>09-25-2025</td>
                        <td>Doc. Dela Cruz</td>
                        <td>Nosebleed</td>
                        <td>Upcoming</td>
                    </tr>
                    <tr>
                        <td>Jack Daray</td>
                        <td>Sir Aguilar</td>
                        <td>09-20-2025</td>
                        <td>09-30-2025</td>
                        <td>Doc. Cenita</td>
                        <td>Fever</td>
                        <td>Upcoming</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SIDEBAR SCRIPT -->
<script>
(function() {
    const sidebar = document.getElementById('appSidebar');
    const container = document.querySelector('.dashboard-container');
    const overlay = document.querySelector('.sidebar-overlay');
    const toggleBtn = document.getElementById('sidebarToggleBtn');

    function openSidebar() {
        sidebar.classList.add('open');
        container.classList.add('with-sidebar-open');
        overlay.classList.add('visible');
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        container.classList.remove('with-sidebar-open');
        overlay.classList.remove('visible');
    }

    toggleBtn.addEventListener('click', (e) => {
        e.preventDefault();
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);
})();
</script>

<!-- STATUS FILTER SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const filter = document.querySelector(".status-filter");
  const rows = document.querySelectorAll(".patients tr");

  filter.addEventListener("change", function() {
    const selectedStatus = this.value.toLowerCase();

    rows.forEach((row, index) => {
      if (index === 0) return; // skip header
      const statusCell = row.cells[6]?.textContent.trim().toLowerCase();

      if (selectedStatus === "all" || statusCell === selectedStatus) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
});
</script>

</body>
</html>
