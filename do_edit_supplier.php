<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $supplierId = $_POST["supplierId"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $dob = $_POST["country"];

    // Update supplier data in the database
    $stmt = $conn->prepare("UPDATE supplier SET 
            s_name = :name,
            s_email = :email,
            s_phone = :phone,
            s_address = :address,
            s_country = :country
            WHERE s_id = :id");

    $stmt->bindParam(':id', $supplierId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':country', $country);

    $stmt->execute();

    echo "Supplier updated successfully";
    header("Location: supplier.php");
}
