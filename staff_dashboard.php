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
    <link rel="stylesheet" href="staffdash.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
            <!-- <img src="Hamburger_icon.svg.png" alt="Sidebar" class="sidebar-logo"> -->
            <h2>UM CLINIC</h2>
  
        <ul>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
                <li><a href="#">📅 Next Schedule</a></li>
                <li><a href="#">📜 History</a></li>
                <li><a href="#">👤 Profile</a></li>
            <?php else: ?>
                <li><a href="staff_dashboard.php">🏠 Dashboard</a></li>
                <li><a href="">➕ Add New Records</a></li>
                <li><a href="inventory.php">📦 Manage Inventory</a></li>
                <li><a href="record.php">👨🏻‍⚕️ Manage Patients</a></li>
                <li><a href="#">📅 Appointmens</a></li>
            <?php endif; ?>
        </ul>
    </div>    

    <!-- Main Content -->
    <div class="main-content">
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
        <div class="reports">
            <h2 class=monthly>Monthly reports</h2>
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
