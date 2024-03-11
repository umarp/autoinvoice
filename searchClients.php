<?php
require_once("./connection/connection.php");

if (isset($_GET["term"])) {
    $value = $_GET["term"];
    try {
        $stmt = $conn->prepare("SELECT * FROM clients WHERE c_firstName LIKE :value OR c_lastName LIKE :value1");
        $stmt->bindValue(':value', '%' . $value . '%');
        $stmt->bindValue(':value1', '%' . $value . '%');

        $stmt->execute();

        // Fetch the results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // Loop through the results
            foreach ($results as $row) {
                // Access individual columns using array syntax
                echo "<option value='" . $row['c_id'] . "' >" . $row['c_firstName'] . " " . $row['c_lastName'] . "</option>";
            }
        }
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<option>Search term not provided</option>";
}
?>