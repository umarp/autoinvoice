<?php
// delete_supplier.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supplierId'])) {

    include_once("connection/connection.php");

    // Get the supplier ID to delete
    $supplierId = $_POST['supplierId'];

    // Prepare and execute the SQL query to delete the supplier
    $query = "DELETE FROM supplier WHERE s_id = :supplierId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':supplierId', $supplierId, PDO::PARAM_INT);

    try {
        $stmt->execute();

        echo "Supplier deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting Supplier: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>