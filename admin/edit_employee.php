<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once('C:\xampp\htdocs\SCG_Fairmanpower\config\connection.php');

    // Get values from the form
    $card_id = $_POST['card_id'];
    $employee_name = $_POST['employee_name'];

    // Update the employee data in the database
    $sql = "UPDATE employee SET employee_name = ? WHERE card_id = ?";
    $params = array($employee_name, $card_id);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Check if the update was successful
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Redirect to the employee list page
    header("Location: listemployee.php");
    exit();
} else {
    // Redirect to the appropriate page if the form is not submitted
    header("Location: listemployee.php");
    exit();
}
