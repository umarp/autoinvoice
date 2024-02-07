<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $department = $_POST["department"];
    $accessInvoice = isset($_POST["accessInvoice"]) ? 1 : 0;
    $accessPurchaseOrder = isset($_POST["accessPurchaseOrder"]) ? 1 : 0;
    $accessDeliveryNote = isset($_POST["accessDeliveryNote"]) ? 1 : 0;

    // Prepare the SQL statement
    $sql = "INSERT INTO login (l_firstName, l_lastName, l_email, l_password, l_department, l_invoice, l_purchaseOrder, l_deliveryNote)
                VALUES (:firstName, :lastName, :email, :password, :department, :accessInvoice, :accessPurchaseOrder, :accessDeliveryNote)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':accessInvoice', $accessInvoice, PDO::PARAM_INT);
    $stmt->bindParam(':accessPurchaseOrder', $accessPurchaseOrder, PDO::PARAM_INT);
    $stmt->bindParam(':accessDeliveryNote', $accessDeliveryNote, PDO::PARAM_INT);

    // Execute the prepared statement
    $stmt->execute();
    header('Location: users.php');
    // echo "New record created successfully";
}

?>