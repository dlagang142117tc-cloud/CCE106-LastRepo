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
  <link rel="stylesheet" href="logs.css?v=1" />
  <link rel="icon" type="image/png" href="asset/images/um_logo_no_bg.png">
</head>
<body>
<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">
         <h2 class="js-sidebar-trigger">UM CLINIC</h2>
            <ul>
                <?php if ($_SESSION['role'] === 'staff'): ?>
                    <li><a href="staff_dashboard.php" class="<?php echo ($currentPage === 'staff_dashboard.php') ? 'active' : ''; ?>">🏠 Staff Dashboard</a></li>
                    <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical Records</a></li>
                    <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 Manage Inventory</a></li>
                    <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">👨🏻‍⚕️ Manage Patients</a></li>
                    <li><a href="appointment.php" class="<?php echo ($currentPage === 'appointment.php') ? 'active' : ''; ?>">📅 Appointments</a></li>
                <?php elseif ($_SESSION['role'] === 'sta'): ?>
                    <li><a href="staff_dashboard.php" class="<?php echo ($currentPage === 'staff_dashboard.php') ? 'active' : ''; ?>">🏠 STA Dashboard</a></li>
                    <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical Records</a></li>
                    <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 Manage Inventory</a></li>
                    <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">👨🏻‍⚕️ Manage Patients</a></li>
                    <li><a href="logs.php" class="<?php echo ($currentPage === 'logs.php') ? 'active' : ''; ?>">Logs</a></li>
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
                <h1>LOGS</h1>
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

                <table class="student">
                    <tr>
                        <th>Date & Time</th>
                        <th>User Role</th>
                        <th>User ID</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                    <tr>
                        <td>2025-10-04 09:30 AM</td>
                        <td>Student</td>
                        <td>142466</td>
                        <td>Login</td>
                        <td>Logged into the system</td>
                    </tr>
                    <tr>
                        <td>2025-10-04 09:40 AM</td>
                        <td>STA</td>
                        <td>STA001</td>
                        <td>Added Record</td>
                        <td>Added appointment for student 142466</td>
                    </tr>
                    <tr>
                        <td>2025-10-04 09:50 AM</td>
                        <td>Staff</td>
                        <td>NURSE01</td>
                        <td>Edited Record</td>
                        <td>Updated vaccine for student 142466</td>
                    </tr>
                    <tr>;
                        <td>2025-10-04 10:00 AM</td>
                        <td>Staff</td>
                        <td>NURSE01</td>
                        <td>Added</td>
                        <td>Added 50 paracetamol to inventory</td>
                    </tr>
                    <tr>
                        <td>2025-10-04 10:30 AM</td>
                        <td>Student</td>
                        <td>142469</td>
                        <td>Request</td>
                        <td>Request for medical certificate</td>
                    </tr>
                    <tr>
                        <td>2025-10-04 10:55 AM</td>
                        <td>STA</td>
                        <td>STA002</td>
                        <td>Edit</td>
                        <td>Edited a record</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

  <script>
        (function() {
            var triggerEls = document.querySelectorAll('.js-sidebar-trigger');
            var sidebar = document.getElementById('appSidebar');
            var container = document.querySelector('.dashboard-container');
            var overlay = document.querySelector('.sidebar-overlay');
            var toggleBtn = document.getElementById('sidebarToggleBtn');
            if (!sidebar || !container) return;

            function openSidebar() {
                sidebar.classList.add('open');
                if (container) container.classList.add('with-sidebar-open');
                if (overlay) overlay.classList.add('visible');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                if (container) container.classList.remove('with-sidebar-open');
                if (overlay) overlay.classList.remove('visible');
            }

            function toggleSidebar() {
                try {
                    if (sidebar.classList.contains('open')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                } catch (err) {
                    console.error('Sidebar toggle error:', err);
                }
            }

            // Hide by default
            closeSidebar();

            // Click any trigger (UM CLINIC title) to open sidebar
            if (triggerEls && triggerEls.length) {
                triggerEls.forEach(function(el) {
                    el.addEventListener('click', function(e) {
                        e.preventDefault();
                        openSidebar();
                    });
                });
            }

            // Toggle button for opening/closing sidebar
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }

            // Also allow clicking the collapsed sidebar edge
            sidebar.addEventListener('click', function(e) {
                if (!sidebar.classList.contains('open')) {
                    e.stopPropagation();
                    openSidebar();
                }
            });

            // ESC to close sidebar
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                    closeSidebar();
                }
            });

            // Click outside on overlay to close
            if (overlay) {
                overlay.addEventListener('click', function() {
                    closeSidebar();
                });
            }
        })();
    </script>
</body>
</html>
