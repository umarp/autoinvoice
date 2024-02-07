<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {

        require_once("connection/connection.php");
        // Get the POST data
        $oId = $_POST['oId'];
        $dataType = $_POST['dataType'];
        $editedData = $_POST['editedData'];

        // Update the data in the database for the specified organization
        $updateQuery = "UPDATE organisation SET o_value = :editedData WHERE o_id = :oId AND o_name = :dataType";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':editedData', $editedData);
        $stmt->bindParam(':oId', $oId);
        $stmt->bindParam(':dataType', $dataType);
        $stmt->execute();

        // Return a success message or handle as needed
        echo 'Data updated successfully';

    } catch (PDOException $e) {
        // Handle database connection errors
        echo 'Error: ' . $e->getMessage();
    }
}
?>