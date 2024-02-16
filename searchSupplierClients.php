<?php
require_once("./connection/connection.php");

if (isset($_GET["term"])) {
    $value = $_GET["term"];
    try {
        $stmt = $conn->prepare("SELECT * FROM supplier WHERE s_name LIKE :value");
        $stmt->bindValue(':value', '%' . $value . '%');
        $stmt->execute();

        // Fetch the results as an associative array
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            // Loop through the results
            foreach ($results as $row) {
                // Access individual columns using array syntax
                echo "<option value='" . $row['s_id'] . "' >" . $row['s_name'] . "</option>";
            }
        } else {
            echo "<option>No results found</option>";
        }
    } catch (PDOException $e) {
        // Handle errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<option>Search term not provided</option>";
}
?>