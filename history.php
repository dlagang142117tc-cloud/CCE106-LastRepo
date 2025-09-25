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
    <title>History</title>
    <link rel="stylesheet" href="history.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="appSidebar">
        <h2>UM Clinic</h2>
        <ul>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <li><a href="student_dashboard.php">🏠 Student Dashboard</a></li>
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
                    <h1>History</h1>
                    <p>Hello, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Student'; ?>. Here are your previous clinic visits.</p>
                </div>
                <div class="header-actions">
                    <form action="logout.php" method="POST" style="display:inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div class="history-section">
                <div class="history-header">
                    <h2>Past Visits</h2>
                    <div>
                        <button class="icon-btn" title="Refresh" onclick="location.reload()">⟳</button>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Visit Type</th>
                            <th>Notes</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Aug 12, 2025</td>
                            <td>Dr. Santos</td>
                            <td>Consultation</td>
                            <td>Flu-like symptoms, advised rest and hydration.</td>
                            <td><span class="badge success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Jul 22, 2025</td>
                            <td>Dr. Reyes</td>
                            <td>Vital Check</td>
                            <td>Blood pressure monitoring, normal range.</td>
                            <td><span class="badge success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Jun 15, 2025</td>
                            <td>Dr. Cruz</td>
                            <td>Document</td>
                            <td>Medical certificate issued for PE exemption.</td>
                            <td><span class="badge info">Archived</span></td>
                        </tr>
                        <tr>
                            <td>May 5, 2025</td>
                            <td>Dr. Gomez</td>
                            <td>Follow-up</td>
                            <td>Cleared for regular activities.</td>
                            <td><span class="badge success">Completed</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="divider"></div>

                <div class="right-info">
                    <div class="info-group">
                        <h3>Tips</h3>
                        <ul>
                            <li>Keep your vaccination card updated.</li>
                            <li>Track symptoms before your visit.</li>
                            <li>Bring any relevant lab results.</li>
                        </ul>
                    </div>
                    <div class="info-group">
                        <h3>Need help?</h3>
                        <p>For questions about your history, please contact the clinic staff.</p>
                    </div>
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
            try { sidebar.classList.contains('open') ? closeSidebar() : openSidebar(); }
            catch (err) { console.error('Sidebar toggle error:', err); }
        }

        closeSidebar();

        if (triggerEls && triggerEls.length) {
            triggerEls.forEach(function(el){
                el.addEventListener('click', function(e){ e.preventDefault(); openSidebar(); });
            });
        }
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e){ e.preventDefault(); toggleSidebar(); });
        }
        sidebar.addEventListener('click', function(e){
            if (!sidebar.classList.contains('open')) { e.stopPropagation(); openSidebar(); }
        });
        document.addEventListener('keydown', function(e){ if (e.key === 'Escape' && sidebar.classList.contains('open')) closeSidebar(); });
        if (overlay) { overlay.addEventListener('click', function(){ closeSidebar(); }); }
    })();
    </script>
</body>
</html>
