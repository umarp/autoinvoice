<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['poId'])) {

    include_once("connection/connection.php");

    // Get the PO ID to delete
    $poId = $_POST['poId'];

    // Prepare and execute the SQL query to delete the PO
    $query = "DELETE FROM purchase_order WHERE p_id = :poId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':poId', $poId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        echo "PO deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting PO: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>