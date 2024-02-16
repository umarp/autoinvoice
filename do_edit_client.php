<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST["clientId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];


    // Update user data in the database
    $stmt = $conn->prepare("UPDATE clients SET 
            c_firstName = :firstName,
            c_lastName = :lastName,
            c_email = :email,
            c_phone = :phone,
            c_address = :address,
            c_dob = :dob


            WHERE c_id = :id");

    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':dob', $dob);


    $stmt->execute();

    echo "Client updated successfully";
    header("Location: client.php");
}
