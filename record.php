<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role']; // ✅ Fix for the undefined variable
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Records</title>
    <link rel="stylesheet" href="record.css">
</head>

<body>

    <div class="sidebar">
        <h2>UM CLINIC</h2>
        <ul>
            <?php if ($role === 'staff'): ?>
                <li><a href="staff_dashboard.php">🏠 Dashboard</a></li>
                <li><a href="">➕ Manage Records</a></li>
                <li><a href="inventory.php">📦 Manage Inventory</a></li>
                <li><a href="record.php">👨🏻‍⚕️ Manage Patients</a></li>
                <li><a href="#">📅 Appointments</a></li>

            <?php elseif ($role === 'sta'): ?>
                <li><a href="sta_dashboard.php">🏠 Dashboard</a></li>
                <li><a href="inventory.php">📦 View Inventory</a></li>
                <li><a href="record.php">📋 View Records</a></li>
                <li><a href="">➕ Add New Record</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="main">
        <!-- <h2>Clinic Records</h2> -->
        <div class="top-header">
            <div class="top-header-left">
                <button id="toggleSidebar" class="icon-btn">☰</button>
            </div>
            <div class="top-header-center">
                <h1>RECORDS</h1>
            </div>
            <div class="top-header-right">
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>





        <div class="record">
            <table>
                <tr class="tr1">
                    <th>Name</th>
                    <th>ID No.</th>
                    <th>Medicine</th>
                    <th>Staff</th>
                    <th>Date Visited</th>
                    <th>Time Visited</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Mj Alagase</td>
                    <td>142455</td>
                    <td>Biogesic</td>
                    <td>Nurse</td>
                    <td>04/21/2025</td>
                    <td>3pm</td>
                    <td>recovering</td>
                </tr>
                <tr>
                    <td>Mj Alagase</td>
                    <td>142455</td>
                    <td>Biogesic</td>
                    <td>Nurse</td>
                    <td>04/21/2025</td>
                    <td>3pm</td>
                    <td>recovering</td>
                </tr>
                <tr>
                    <td>Mj Alagase</td>
                    <td>142455</td>
                    <td>Biogesic</td>
                    <td>Nurse</td>
                    <td>04/21/2025</td>
                    <td>3pm</td>
                    <td>recovering</td>
                </tr>
                <tr>
                    <td>Mj Alagase</td>
                    <td>142455</td>
                    <td>Biogesic</td>
                    <td>Nurse</td>
                    <td>04/21/2025</td>
                    <td>3pm</td>
                    <td>recovering</td>
                </tr>
            </table>
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