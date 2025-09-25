<?php
session_start();
if(!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
            <h2>UM CLINIC</h2>
  
        <ul>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <li><a href="#">📅 Next Schedule</a></li>
                <li><a href="#">📜 History</a></li>
                <li><a href="#">👤 Profile</a></li>
            <?php else: ?>
                <li><a href="sta_dashboard.php">🏠 Dashboard</a></li>
                <li><a href="inventory.php">📦 View Inventory</a></li>
                <li><a href="record.php">📋 View Records</a></li>
                <li><a href="#">➕ Add New Record</a></li>
            <?php endif; ?>
        </ul>
        <ul class="bottom">
            <li><a href="#">❔ Help</a></li>
        </ul>
    </div>    

    <!-- Main Content -->
            <!--Put ID to this div to manipulate BG-->
    <div class="main-content" id="main-content-dashboard">
        <div class="top-header">
            <!--THIS IS FOR SIDEBAR SLIDE-->
                <button id="toggleSidebar" class="icon-btn">☰</button>
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
            <div class="cards-container">
                <div class="card">
                    <h2>📦 Inventory</h2>
                    <p>Manage and view current medical supplies.</p>
                </div>
                <div class="card">
                    <h2>📋 Records</h2>
                    <p>Access patient records and clinic history.</p>
                </div>
                <div class="card">
                    <h2>➕ Add Record</h2>
                    <p>Insert new patient or clinic data.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
<script>
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('full');
    });
</script>
</body>
</html>
