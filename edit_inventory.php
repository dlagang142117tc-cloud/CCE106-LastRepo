<?php
// Include database connection
require 'database.php';

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the medicine ID from the hidden input and cast it to integer for safety
    $medicine_id = (int) $_POST['medicine_id'];

    // Sanitize and assign the input fields to variables
    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $receive_date = mysqli_real_escape_string($conn, $_POST['receive_date']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $quantity = (int) $_POST['quantity'];

    // Prepare SQL UPDATE statement to modify the item with the given medicine_id
    $sql = "UPDATE inventory 
            SET medicine_name = '$medicine_name', 
                receive_date = '$receive_date', 
                expiry_date = '$expiry_date', 
                quantity = $quantity 
            WHERE medicine_id = $medicine_id";

    // Run the query and check for success
    if (mysqli_query($conn, $sql)) {
        // Redirect back to inventory.php with success message
        header('Location: inventory.php?message=Item updated successfully');
        exit;
    } else {
        // Output error message if query fails
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect if accessed directly without POST data
    header('Location: inventory.php');
    exit;
}
?>
