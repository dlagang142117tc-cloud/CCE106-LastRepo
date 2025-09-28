<?php
// Include database connection
require 'database.php';

// Check if the request came from the form (POST method)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['medicine_id'])) {
    // Get medicine_id from form
    $medicine_id = (int) $_POST['medicine_id']; // cast to int for safety

    // Prepare SQL DELETE statement
    $sql = "DELETE FROM inventory WHERE medicine_id = $medicine_id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect back with success message
        header("Location: inventory.php?message=Item+deleted+successfully");
        exit;
    } else {
        // Show error if query fails
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If no medicine_id provided, go back to inventory
    header("Location: inventory.php");
    exit;
}
?>
