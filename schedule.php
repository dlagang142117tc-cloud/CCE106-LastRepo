<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule</title>
    <link rel="stylesheet" href="schedule.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">
        <h2>UM Clinic</h2>
        <ul>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <li><a href="student_dashboard.php">🏠Student Dashboard</a></li>
                <li><a href="schedule.php">📅 Next Schedule</a></li>
                <li><a href="history.php">📜 History</a></li>
            <?php else: ?>
                <li><a href="#">🧑‍⚕️ Manage Patients</a></li>
                <li><a href="#">📋 Appointments</a></li>
                <li><a href="#">⚙️ Settings</a></li>
            <?php endif; ?>
        </ul>
        <ul class="bottom">
            <li><a href="#">❔ Help</a></li>
        </ul>
    </div>

    <button type="button" class="sidebar-launcher" id="sidebarToggleBtn" aria-label="Toggle sidebar">
        <img src="asset/images/um_logo_no_bg.png" alt="Sidebar" style="width:40px;height:auto;" />
    </button>

    <div class="dashboard-container">
        <!-- Main Content -->
        <div class="main-content">
            <div class="top-header">
                <div class="welcome-text">
                    <h1>
                        My Schedule
                    </h1>
                    <p>Hello, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Student'; ?>. Here are your upcoming appointments.</p>
                </div>
                <div class="header-actions">
                    <form action="logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div class="schedule-section">
                <div class="schedule-header">
                    <h2>Upcoming Appointments</h2>
                    <div>
                        <!-- Placeholder actions -->
                        <button class="icon-btn" title="Refresh" onclick="location.reload()">⟳</button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>September 15, 2025</td>
                            <td>09:30 AM</td>
                            <td>Dr. Santos</td>
                            <td>General Checkup</td>
                            <td><span class="status upcoming">Upcoming</span></td>
                        </tr>
                        <tr>
                            <td>September 27, 2025</td>
                            <td>02:00 PM</td>
                            <td>Dr. Cruz</td>
                            <td>Follow-up</td>
                            <td><span class="status upcoming">Upcoming</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cards-container" style="margin-top:40px;">
                <div class="card">
                    <h2>How to reschedule</h2>
                    <p>Please contact the clinic hotline or visit the clinic to request a change to your appointment.</p>
                </div>
                <div class="card">
                    <h2>Preparation tips</h2>
                    <ul>
                        <li>Bring your student ID.</li>
                        <li>Arrive 10 minutes early.</li>
                        <li>List symptoms or questions beforehand.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Click-outside overlay for sidebar -->
    <div class="sidebar-overlay" data-close-sidebar="true"></div>

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

        closeSidebar();

        if (triggerEls && triggerEls.length) {
            triggerEls.forEach(function(el){
                el.addEventListener('click', function(e){
                    e.preventDefault();
                    openSidebar();
                });
            });
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e){
                e.preventDefault();
                toggleSidebar();
            });
        }

        sidebar.addEventListener('click', function(e){
            if (!sidebar.classList.contains('open')) {
                e.stopPropagation();
                openSidebar();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });

        if (overlay) {
            overlay.addEventListener('click', function(){
                closeSidebar();
            });
        }
    })();
    </script>
</body>
</html>
