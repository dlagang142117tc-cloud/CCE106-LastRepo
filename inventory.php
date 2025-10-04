<?php
include("database.php");
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}
// Determine current page to highlight active menu item
$currentPage = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'];
// Just to check the current role if correct (echo $role;)
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
            <?php endif; ?>
        </ul>       
    </div>

    <div class="sidebar-overlay"></div>

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

        <!-- 🔹 Add Button on top (like original design) -->
        <div id="inv-header">
            <button class="inv-btn" id="openAdd">Add</button>
        </div>

        <!-- Inventory Table -->
        <div id="inventory-div">
            <table id="table">
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Receive Date</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th>Actions</th> <!-- Column for Edit/Delete buttons -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // ✅ Fetch medicines from DB
                    $sql = "SELECT medicine_id, medicine_name, receive_date, expiry_date, quantity FROM inventory";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['medicine_name']}</td>
                                    <td>{$row['receive_date']}</td>
                                    <td>{$row['expiry_date']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button 
                                            class='inv-btn editBtn'
                                            data-id='{$row['medicine_id']}'
                                            data-name='{$row['medicine_name']}'
                                            data-receive='{$row['receive_date']}'
                                            data-expiry='{$row['expiry_date']}'
                                            data-quantity='{$row['quantity']}'>
                                            Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button 
                                            class='inv-btn deleteBtn'
                                            data-id='{$row['medicine_id']}'>
                                            Delete
                                        </button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ===== MODALS ===== -->

<!-- Add Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" data-close="addModal">&times;</span>
        <h2>Add Medicine</h2>
        <form method="POST" action="add_inventory.php">
            <label>Medicine Name</label>
            <input type="text" name="medicine_name" required>
            <label>Receive Date</label>
            <input type="date" name="receive_date" required>
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" required>
            <label>Quantity</label>
            <input type="number" name="quantity" required>
            <div class="modal-actions">
                <button type="submit" class="inv-btn">Save</button>
                <button type="button" class="inv-btn" data-close="addModal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" data-close="editModal">&times;</span>
        <h2>Edit Medicine</h2>
        <form method="POST" action="edit_inventory.php">
            <!-- Hidden field to pass medicine_id -->
            <input type="hidden" name="medicine_id" id="edit_id">
            <label>Medicine Name</label>
            <input type="text" name="medicine_name" id="edit_name" required>
            <label>Receive Date</label>
            <input type="date" name="receive_date" id="edit_receive" required>
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" id="edit_expiry" required>
            <label>Quantity</label>
            <input type="number" name="quantity" id="edit_quantity" required>
            <div class="modal-actions">
                <button type="submit" class="inv-btn">Update</button>
                <button type="button" class="inv-btn" data-close="editModal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" data-close="deleteModal">&times;</span>
        <h2>Delete Medicine</h2>
        <p>Are you sure you want to delete this record?</p>
        <form method="POST" action="delete_inventory.php">
            <input type="hidden" name="medicine_id" id="delete_id">
            <div class="modal-actions">
                <button type="submit" class="inv-btn">Delete</button>
                <button type="button" class="inv-btn" data-close="deleteModal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- ===== Sidebar + Modal Script ===== -->
<script>
(function() {
    // ===== Sidebar Logic =====
    var sidebar = document.getElementById('appSidebar');
    var container = document.querySelector('.dashboard-container');
    var overlay = document.querySelector('.sidebar-overlay');
    var toggleBtn = document.getElementById('sidebarToggleBtn');

    function openSidebar() {
        sidebar.classList.add('open');
        container.classList.add('with-sidebar-open');
        overlay.classList.add('visible');
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        container.classList.remove('with-sidebar-open');
        overlay.classList.remove('visible');
    }
    function toggleSidebar() {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    }

    closeSidebar(); // start closed
    if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // ===== Modal Logic =====
    function openModal(id) { document.getElementById(id).style.display = 'block'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    document.getElementById('openAdd').addEventListener('click', function() {
        openModal('addModal');
    });

    document.querySelectorAll('[data-close]').forEach(function(btn) {
        btn.addEventListener('click', function() {
            closeModal(this.getAttribute('data-close'));
        });
    });

    // ===== Edit Button Logic =====
    document.querySelectorAll('.editBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_receive').value = this.dataset.receive;
            document.getElementById('edit_expiry').value = this.dataset.expiry;
            document.getElementById('edit_quantity').value = this.dataset.quantity;
            openModal('editModal');
        });
    });

    // ===== Delete Button Logic =====
    document.querySelectorAll('.deleteBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('delete_id').value = this.dataset.id;
            openModal('deleteModal');
        });
    });
})();
</script>
</body>
</html>
