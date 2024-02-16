<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];
    $currentDate = date("Y-m-d");

    // Prepare the SQL statement
    $sql = "INSERT INTO clients (c_firstName, c_lastName, c_email, c_phone, c_address, c_dob, c_dateAdded)
                VALUES (:firstName, :lastName, :email, :phone, :address, :dob, :date)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':date', $currentDate);

    // Execute the prepared statement
    $stmt->execute();
    header('Location: client.php');
    // echo "New record created successfully";
}

?>