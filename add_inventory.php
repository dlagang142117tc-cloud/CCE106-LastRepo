<?php
// Include the database connection file
require 'database.php';

// Check if the form was submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and get the input values with the correct field names
    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $receive_date = mysqli_real_escape_string($conn, $_POST['receive_date']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $quantity = (int) $_POST['quantity'];

    // Prepare the SQL INSERT statement to add a new inventory item
    $sql = "INSERT INTO inventory (medicine_name, receive_date, expiry_date, quantity) 
            VALUES ('$medicine_name', '$receive_date', '$expiry_date', $quantity)";
    
    // Execute the query and check if successful
    if (mysqli_query($conn, $sql)) {
        // Redirect back to inventory.php with a success message
        header('Location: inventory.php?message=Item added successfully');
        exit; // Stop further execution after redirect
    } else {
        // If error occurs, display the error message
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // If the request is not POST, redirect to inventory.php
    header('Location: inventory.php');
    exit;
}
?>
