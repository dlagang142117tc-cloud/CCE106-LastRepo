<?php
include("database.php");
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'];
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
      <!--   REMOVE THE HELP BECAUSE WE DONT NEED FAQs 
        <ul class="bottom">
            <li><a href="#">❔ Help</a></li>
        </ul>    -->
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

        <!-- Add Button -->
        <div id="inv-header">
            <button class="inv-btn" id="openAdd">Add</button>
        </div>

        <!-- Inventory Table -->
        <div id="inventory-div">
            <table id="table">
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Total Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get distinct medicines and total quantities
                    $sql = "SELECT medicine_name, SUM(quantity) as total_qty 
                            FROM inventory 
                            GROUP BY medicine_name";
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $medicineName = $row['medicine_name'];
                            $totalQty = $row['total_qty'];

                            echo "<tr class='medicine-row'>
                                    <td>$medicineName</td>
                                    <td>$totalQty</td>
                                    <td>
                                        <button class='inv-btn toggleBatches' data-name='$medicineName'>▼ Batches</button>
                                    </td>
                                  </tr>";

                            // Hidden batch rows for each medicine
                            echo "<tr class='batch-row' data-medicine='$medicineName' style='display:none;'>
                                    <td colspan='3'>
                                        <table class='batch-table'>
                                            <thead>
                                                <tr>
                                                    <th>Receive Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                            
                            $batchSql = "SELECT * FROM inventory WHERE medicine_name = '$medicineName'";
                            $batchResult = mysqli_query($conn, $batchSql);

                            if ($batchResult && mysqli_num_rows($batchResult) > 0) {
                                while ($batch = mysqli_fetch_assoc($batchResult)) {
                                    echo "<tr>
                                            <td>{$batch['receive_date']}</td>
                                            <td>{$batch['expiry_date']}</td>
                                            <td>{$batch['quantity']}</td>
                                            <td>
                                                <button 
                                                    class='inv-btn editBtn'
                                                    data-id='{$batch['medicine_id']}'
                                                    data-name='{$batch['medicine_name']}'
                                                    data-receive='{$batch['receive_date']}'
                                                    data-expiry='{$batch['expiry_date']}'
                                                    data-quantity='{$batch['quantity']}'>
                                                    Edit
                                                </button>
                                                <button 
                                                    class='inv-btn deleteBtn'
                                                    data-id='{$batch['medicine_id']}'>
                                                    Delete
                                                </button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No batches found</td></tr>";
                            }

                            echo "      </tbody>
                                        </table>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No records found</td></tr>";
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
            <input type="hidden" name="medicine_id" id="edit_id">
            <label>Medicine Name</label>
            <input type="text" name="medicine_name" id="edit_name" required>
            <label>Receive Date</label>
            <input type="date" name="receive_date" id="edit_receive" required>
            <label>Expiry Date</label>
            <input type="date" name="expiry_date" id="edit_expiry" required>
            <label>Quantity</label>
            <div class="qty-container">
                <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                <input type="number" name="quantity" id="edit_quantity" required>
                <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
            </div>
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
    // Sidebar
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

    closeSidebar();
    if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // Modals
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

    // Edit
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

    // Delete
    document.querySelectorAll('.deleteBtn').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('delete_id').value = this.dataset.id;
            openModal('deleteModal');
        });
    });

    // Toggle batches
    document.querySelectorAll('.toggleBatches').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var medicine = this.getAttribute('data-name');
            var batchRow = document.querySelector('.batch-row[data-medicine="' + medicine + '"]');
            if (batchRow.style.display === 'none') {
                batchRow.style.display = 'table-row';
                this.textContent = '▲ Batches';
            } else {
                batchRow.style.display = 'none';
                this.textContent = '▼ Batches';
            }
        });
    });

})();
function changeQty(val) {
    var qtyInput = document.getElementById('edit_quantity');
    var current = parseInt(qtyInput.value) || 0;
    var newValue = current + val;
    if (newValue >= 0) qtyInput.value = newValue;
}
</script>
</body>
</html>
