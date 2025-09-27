<?php
session_start();
if(!isset($_SESSION['role'])) {
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
    <title>Dashboard</title>
    <link rel="stylesheet" href="staffdash.css?v=<?php echo time(); ?>">
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
                    <li><a href="" class="<?php echo ($currentPage === 'add_record.php') ? 'active' : ''; ?>">➕ Add New Record</a></li>
                <?php endif; ?>
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
                <h1>
                    Welcome, 
                    <?php 
                        echo isset($_SESSION['name']) ? $_SESSION['name'] : ucfirst($_SESSION['role']); 
                    ?>!
                </h1>
                <p>This is your <?php echo $_SESSION['role']; ?> dashboard page.</p>
            </div> 
            <div class="header-actions">
                <!-- Logout Button -->
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>       

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
            <div class="cards-container">
                <div class="card">
                    <h2>📅 Next Appointment</h2>
                    <p>Date: <strong>September 15, 2025</strong></p>
                    <p>Doctor: <strong>Dr. Santos</strong></p>
                    <p>Reason: <strong>General Checkup</strong></p>
                </div>
                <div class="card">
                    <h2>📜 Visit History</h2>
                    <ul>
                        <li>Aug 12, 2025 - Flu Consultation</li>
                        <li>Jul 22, 2025 - Blood Pressure Check</li>
                        <li>Jun 15, 2025 - Medical Certificate Request</li>
                    </ul>
                </div>
                <div class="card">
                    <h2>👤 Profile</h2>
                    <p>Name: <?php echo $_SESSION['name'] ?? "N/A"; ?></p>
                    <p>Student ID: 2025-12345</p>
                    <p>Course: BSIT</p>
                </div>
            </div>
        <?php else: ?>
        <div class="reports">
            <h2 class=monthly>Monthly Reports</h2>
            <div class="cards-container">
                <div class="card">
                    <h2>📑 Coughing Blood </h2>
                    <p>Paul Daniel</p>
                    <p>Student - 144569</p>
                    <p>BSIT</p>
                </div>
                <div class="card">
                    <h2>📑 Diarrhea </h2>
                    <p>Denns Lagang</p>
                    <p>Student - 144669</p>
                    <p>BSIT</p>
                </div>
                <div class="card">
                    <h2>📑 Headache </h2>
                    <p>Marc Jason</p>
                    <p>Student - 144769</p>
                    <p>BSIT</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
