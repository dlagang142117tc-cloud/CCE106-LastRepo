<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
    <link rel="stylesheet" href="student_dashboard.css">
    <link rel="icon" type="image/png" href="asset/images/um_logo_no_bg.png">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">   
        <h2>
            UM CLINIC
        </h2>
        <ul>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <li><a href="student_dashboard.php" class="<?php echo ($currentPage === 'student_dashboard.php') ? 'active' : ''; ?>">🏠 Student Dashboard</a></li>
                <li><a href="schedule.php" class="<?php echo ($currentPage === 'schedule.php') ? 'active' : ''; ?>">📅 Next Schedule </a></li>
                <li><a href="history.php" class="<?php echo ($currentPage === 'history.php') ? 'active' : ''; ?>">📜 History </a></li>
            <?php else: ?>
                <li><a href="#" class="<?php echo ($currentPage === 'manage_patients.php') ? 'active' : ''; ?>">🧑‍⚕️ Manage Patients</a></li>
                <li><a href="#" class="<?php echo ($currentPage === 'appointments.php') ? 'active' : ''; ?>">📋 Appointments</a></li>
                <li><a href="#" class="<?php echo ($currentPage === 'settings.php') ? 'active' : ''; ?>">⚙️ Settings</a></li>
            <?php endif; ?>
        </ul>
            <ul class="bottom">
                <li><a href="#">❔ Help </a></li>
            </ul>
            
        </div>   
        
        <button type="button" class="sidebar-launcher" id="sidebarToggleBtn" aria-label="Toggle sidebar">
            <img src="asset/images/sidebar.png" alt="Sidebar" style="width:40px;height:auto;" />
        </button> 
        
       
<div class="dashboard-container">
    <!-- Main Content -->
    <div class="main-content">
        <div class="top-header">
            <div class="welcome-text">
                <h1>
                Welcome, 
                <?php 
                    echo $_SESSION['name']; ?>!</h1>
                <p>This is your student dashboard page.</p>
            </div> 
            <div class="header-actions">
                <!-- Logout Button -->
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
            <div class= "cards-container">
                <div class= "card">
                    <h2>📅 Next Appointment</h2>
                    <p>Date: <strong>September 15, 2025</strong></p>
                    <p>Doctor: <strong>Dr. Santos</strong></p>
                    <p>Reason: <strong>General Checkup</strong></p>
                </div>
                <div class= "card">
                    <h2>📜 Visit History</h2>
                    <ul>
                        <li>Aug 12, 2025 - Flu Consultation</li>
                        <li>Jul 22, 2025 - Blood Pressure Check</li>
                        <li>Jun 15, 2025 - Medical Certificate Request</li>
                    </ul>
                </div>
                <div class= "card">
                    <h2>👤 Profile</h2>
                    <p>Name: Jayson Cipro</p>
                    <p>Student ID: 2025-12345</p>
                    <p>Course: BSIT</p>
                </div>
            </div>
        <?php else: ?>
            <h2>🧑‍⚕️ Patient List</h2>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Visit</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>2025-001</td>
                    <td>Maria Clara</td>
                    <td>Aug 30, 2025</td>
                    <td>Recovered</td>
                </tr>
                <tr>
                    <td>2025-002</td>
                    <td>Jose Rizal</td>
                    <td>Aug 25, 2025</td>
                    <td>Under Treatment</td>
                </tr>
            </table>

            <h2>📋 Appointments</h2>
            <ul>
                <li>Sep 10, 2025 - Ana Cruz (Fever)</li>
                <li>Sep 12, 2025 - Pedro Penduko (Injury Follow-up)</li>
                <li>Sep 15, 2025 - Juan Dela Cruz (Checkup)</li>
            </ul>
        <?php endif; ?>
    </div>
</div>

    <!-- Click-outside overlay for sidebar -->
    <div class="sidebar-overlay" data-close-sidebar="true"></div>

</div>
<div class="footer">
    <div class="footer-content">
      <div class="footer-left">
        <img src="asset/images/um_logo_no_bg.png" alt="UM Logo">
        <h2>UM</h2>
        <p>The University of Mindanao</p>
        <p>Davao City 8000, Davao del Sur, Philippines</p>
        <p>+63 (082) 221 0190 - Bolton Campus</p>
        <p>+63 (082) 305 0645 - Matina Campus</p>
      </div>
      <div class="footer-right">
        <h3>BRANCHES</h3>
        <ul>
            <a href="https://umtc.umindanao.edu.ph/login" target="_blank"><li>TAGUM</li></a>
            <a href="https://umpc.umindanao.edu.ph/login" target="_blank"><li>PANABO</li></a>
            <a href="https://umdc.umindanao.edu.ph/login" target="_blank"><li>DIGOS</li></a>
            <a href="https://umbc.umindanao.edu.ph/login" target="_blank"><li>BANSALAN</li></a>
            <a href="https://umpe.umindanao.edu.ph/login" target="_blank"><li>PEÑALATA</li></a>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-bottom-left">Copyright © 2025, All Rights Reserved.</div>
      UM STUDENT PORTAL TAGUM
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

        // Hide by default (already off-screen via CSS), ensure no flash
        closeSidebar();

        // Click any trigger to open sidebar
        if (triggerEls && triggerEls.length) {
            triggerEls.forEach(function(el){
                el.addEventListener('click', function(e){
                    e.preventDefault();
                    openSidebar();
                });
            });
        }

        // Toggle button for opening/closing sidebar
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e){
                e.preventDefault();
                toggleSidebar();
            });
        }

        // Also allow clicking the visible edge of the collapsed sidebar
        sidebar.addEventListener('click', function(e){
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
            overlay.addEventListener('click', function(){
                closeSidebar();
            });
        }

        
    })();
    </script>
</body>
</html>