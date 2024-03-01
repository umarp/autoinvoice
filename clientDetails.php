<?php
require_once("./connection/connection.php");

try {
    // Establish database connection
    $value = $_GET["id"];
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM clients WHERE c_id = :value");
    $stmt->bindParam(':value', $value);
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results
    foreach ($results as $row) {
        // Access individual columns using array syntax

        echo '
        
                            <label for="name" class="form-label">Client Name</label>
                            <input type="text" class="form-control" id="clientName" readonly value="' . $row["c_firstName"] . ' ' . $row['c_lastName'] . '">

                            <label for="Address" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" readonly value="' . $row["c_email"] . '">

                            <label for="Phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="Phone" readonly value="' . $row["c_phone"] . '">

                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" readonly value="' . $row["c_address"] . '">
        
        ';

        // Add more columns as needed
    }
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}