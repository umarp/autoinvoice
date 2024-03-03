<?php
include("./connection/connection.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Extract data from the form   


    $i_id = $_POST['i_id'];
    $clientId = $_POST['clientName'];
    $currency = $_POST['currency'];
    $generalRemarks = $_POST['generalRemarks'];
    $subTotal = $_POST['subTotal'];
    $vatAmount = $_POST['vatAmount'];
    $total = $_POST['total'];

    $user = $_SESSION['userLogin'];


    try {
        // Insert into the purchase_order table
        $sql = "UPDATE invoice SET 
                i_clientId = :clientId, 
                i_currency = :currency, 
                i_subTotal = :subTotal, 
                i_vatAmount = :vatAmount, 
                i_total = :total, 
                i_remarks = :generalRemarks, 
                i_user = :user

                WHERE i_id = :i_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':vatAmount', $vatAmount);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);

        $stmt->bindParam(':i_id', $i_id);
        $stmt->execute();

        // Delete existing product details associated with this invoice
        $deleteSql = "DELETE FROM invoice_products WHERE ip_i_id = :i_id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':i_id', $i_id);
        $deleteStmt->execute();
        // Loop through the product details
        foreach ($_POST['description'] as $key => $description) {
            $quantity = $_POST['quantity'][$key];
            $unitPrice = $_POST['unitPrice'][$key];
            $totalPrice = $_POST['totalPrice'][$key];
            $remarks = $_POST['remarks'][$key];

            // Insert into i_products table
            $sql = "INSERT INTO invoice_products (ip_description, ip_quantity,ip_unitPrice,ip_totalPrice, ip_remarks, ip_i_id) 
                    VALUES (:description, :quantity, :unitPrice, :totalPrice, :remarks, :i_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unitPrice', $unitPrice);
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':i_id', $i_id);
            $stmt->execute();
        }




        // header("Location: invoice.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>