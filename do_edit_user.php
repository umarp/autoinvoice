<?php 
include("connection/connection.php");
    // Check if the form is submitted
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $userId = $_POST["userId"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $department = $_POST["department"];
        $accessInvoice = isset($_POST["accessInvoice"]) ? 1 : 0;
        $accessPurchaseOrder = isset($_POST["accessPurchaseOrder"]) ? 1 : 0;
        $accessDeliveryNote = isset($_POST["accessDeliveryNote"]) ? 1 : 0;

        // Update user data in the database
        $stmt = $conn->prepare("UPDATE login SET 
            l_firstName = :firstName,
            l_lastName = :lastName,
            l_email = :email,
            l_password = :password,
           l_department = :department,
            l_invoice = :accessInvoice,
            l_purchaseOrder = :accessPurchaseOrder,
            l_deliveryNote = :accessDeliveryNote
            WHERE l_id = :id");

        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':accessInvoice', $accessInvoice, PDO::PARAM_INT);
        $stmt->bindParam(':accessPurchaseOrder', $accessPurchaseOrder, PDO::PARAM_INT);
        $stmt->bindParam(':accessDeliveryNote', $accessDeliveryNote, PDO::PARAM_INT);

        $stmt->execute();

        echo "User updated successfully";
    }


?>