<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inId'])) {

    include_once("connection/connection.php");

    // Get the Invoice ID to delete
    $inId = $_POST['inId'];

    // Prepare and execute the SQL query to delete the Invoice
    $query = "DELETE FROM invoice WHERE i_id = :inId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':inId', $inId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "Invoice deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting Invoice: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>