<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="dashboard-container">

        <!-- Sidebar -->
        <div class="sidebar">
            <h2>UM CLINIC</h2>
            <ul>
                <!-- CHECK ROLE AND DEPEND ON THAT THE SIDE BAR WILL ADJUST (STAFF/STA) -->
                <?php if ($_SESSION['role'] === 'staff'): ?>
                    <li><a href="staff_dashboard.php">🏠 Dashboard</a></li>
                    <li><a href="">➕ Add New Records</a></li>
                    <li><a href="inventory.php">📦 Manage Inventory</a></li>
                    <li><a href="record.php">👨🏻‍⚕️ Manage Patients</a></li>
                    <li><a href="#">📅 Appointments</a></li>

                <?php elseif ($_SESSION['role'] === 'sta'): ?>
                    <li><a href="sta_dashboard.php">🏠 Dashboard</a></li>
                    <li><a href="inventory.php">📦 View Inventory</a></li>
                    <li><a href="record.php">📋 View Records</a></li>
                    <li><a href="">➕ Add New Record</a></li>
                <?php endif; ?>
            </ul>
            <ul class="bottom">
                <li><a href="#">❔ Help</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="top-header">
                <button id="toggleSidebar" class="icon-btn">☰</button>
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