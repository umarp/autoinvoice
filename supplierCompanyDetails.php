<?php
require_once("./connection/connection.php");

try {
    // Establish database connection
    $value = $_GET["id"];
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM supplier WHERE s_id = :value");
    $stmt->bindParam(':value', $value);
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results
    foreach ($results as $row) {
        // Access individual columns using array syntax

        echo '
        
                                    <label for="Company" class="form-label">Company</label>
                            <input type="test" class="form-control" id="Company" readonly value="' . $row["s_name"] . '">

                            <label for="Address" class="form-label">Address</label>
                            <input type="test" class="form-control" id="Address" readonly value="' . $row["s_email"] . '">

                            <label for="Phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="Phone" readonly value="' . $row["s_address"] . '">

                            <label for="Attention" class="form-label">Attention</label>
                            <input type="text" class="form-control" id="Attention" name="attention">
        
        ';

        // Add more columns as needed
    }
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}
?>