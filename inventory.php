<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}
// Determine current page to highlight active menu item
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" href="asset/images/um_logo_no_bg.png">
</head>

<body>
    <div class="dashboard-container">

        <!-- Sidebar -->
        <div class="sidebar" id="appSidebar">
            <h2 class="js-sidebar-trigger">UM CLINIC</h2>

            <ul>
                <!-- CHECK ROLE AND DEPEND ON THAT THE SIDE BAR WILL ADJUST (STAFF/STA) -->
                <?php if ($_SESSION['role'] === 'staff'): ?>
                    <li><a href="staff_dashboard.php" class="<?php echo ($currentPage === 'staff_dashboard.php') ? 'active' : ''; ?>">🏠 Staff Dashboard</a></li>
                    <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical Records</a></li>
                    <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 Manage Inventory</a></li>
                    <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">👨🏻‍⚕️ Manage Patients</a></li>
                    <li><a href="appointment.php" class="<?php echo ($currentPage === 'appointment.php') ? 'active' : ''; ?>">📅 Appointments</a></li>

                <?php elseif ($_SESSION['role'] === 'sta'): ?>
                    <li><a href="sta_dashboard.php" class="<?php echo ($currentPage === 'sta_dashboard.php') ? 'active' : ''; ?>">🏠 STA Dashboard</a></li>
                    <li><a href="inventory.php" class="<?php echo ($currentPage === 'inventory.php') ? 'active' : ''; ?>">📦 View Inventory</a></li>
                    <li><a href="record.php" class="<?php echo ($currentPage === 'record.php') ? 'active' : ''; ?>">📋 View Records</a></li>
                    <li><a href="medicalrecord.php" class="<?php echo ($currentPage === 'medicalrecord.php') ? 'active' : ''; ?>">➕ Medical History</a></li>
                <?php endif; ?>
            </ul>
            <ul class="bottom">
                <li><a href="#">❔ Help</a></li>
            </ul>
        </div>

        <!-- Sidebar Overlay (click to close) -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar Launcher (logo button) -->
        <button type="button" class="sidebar-launcher" id="sidebarToggleBtn" aria-label="Toggle sidebar">
            <img src="asset/images/sidebar.png" alt="Sidebar" style="width:40px;height:auto;" />
        </button>







        <!-- Main Content -->
        <div class="main-content">
            <div class="top-header">
                <div class="welcome-text">
                    <h1>INVENTORY</h1>
                </div>
                <div class="header-actions">
                    <form action="logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div id="inv-header">
                <button class="inv-btn">Add</button>
                <button class="inv-btn">Edit</button>
                <button class="inv-btn">Delete</button>
            </div>
            <div id="inventory-div">
                <table id="table">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Receive Date</th>
                            <th>Expiry Date</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Paracetamol</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Amoxicilin</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Neozep</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Diatabs</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Amoxicilin</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Vitamins</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td>Bioflu</td>
                            <td>2025-09-01</td>
                            <td>2026-09-01</td>
                            <td>120</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Sidebar Script -->
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