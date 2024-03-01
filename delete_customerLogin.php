<?php
// delete_user.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {

    include_once("connection/connection.php");

    // Get the user ID to delete
    $userId = $_POST['userId'];

    // Prepare and execute the SQL query to delete the user
    $query = "DELETE FROM customer_login WHERE cl_id = :userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "User deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting user: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>