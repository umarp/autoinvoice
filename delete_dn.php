<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dnId'])) {

    include_once("connection/connection.php");

    // Get the Delivery Note ID to delete
    $dnId = $_POST['dnId'];

    // Prepare and execute the SQL query to delete the Delivery Note
    $query = "DELETE FROM delivery_note WHERE d_id = :dnId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':dnId', $dnId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Delivery Note deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting Delivery Note: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>