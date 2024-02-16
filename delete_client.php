<?php
// delete_client.php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['clientId'])) {

    include_once("connection/connection.php");

    // Get the client ID to delete
    $clientId = $_POST['clientId'];

    // Prepare and execute the SQL query to delete the client
    $query = "DELETE FROM clients WHERE c_id = :clientId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':clientId', $clientId, PDO::PARAM_INT);

    try {
        $stmt->execute();

        echo "Client deleted successfully";
    } catch (PDOException $e) {
        echo "Error deleting client: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>