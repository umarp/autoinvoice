<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $country = $_POST["country"];
    $currentDate = date("Y-m-d");
    echo $name;
    echo $email;

    // Prepare the SQL statement
    $sql = "INSERT INTO supplier (s_name, s_email, s_phone, s_address, s_country, s_dateAdded)
                VALUES (:name, :email, :phone, :address, :country, :date)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':date', $currentDate);

    // Execute the prepared statement
    $stmt->execute();
    //header('Location: supplier.php');
    // echo "New record created successfully";
}

?>