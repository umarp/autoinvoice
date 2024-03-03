<?php
include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $po_id = $_POST['po_id']; // Assuming you have a hidden input field in your form to retrieve the PO ID
    $supplierId = $_POST['companyName'];
    $currency = $_POST['currency'];
    $generalRemarks = $_POST['generalRemarks'];
    $subTotal = $_POST['subTotal'];
    $vatAmount = $_POST['vatAmount'];
    $total = $_POST['total'];
    $supplierAttn = $_POST['supplierAttn'];
    $companyAttn = $_POST['companyAttn'];


    // Assuming 'currency' is the user value
    $user = 'Umar';
    $date = date("d-m-y");

    try {
        // Update the purchase_order table
        $sql = "UPDATE purchase_order SET po_supplierId = :supplierId, po_currency = :currency, po_subTotal = :subTotal, 
                po_vatAmount = :vatAmount, po_total = :total, po_remarks = :generalRemarks, po_user = :user, po_date = :date 
                WHERE po_id = :po_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':supplierId', $supplierId);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':vatAmount', $vatAmount);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':po_id', $po_id);
        $stmt->bindParam(':supplierAttn', $supplierAttn);
        $stmt->bindParam(':companyAttn', $companyAttn);
        $stmt->execute();

        // Delete existing product details associated with this purchase order
        $deleteSql = "DELETE FROM po_products WHERE pop_po_id = :po_id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':po_id', $po_id);
        $deleteStmt->execute();

        // Loop through the product details
        foreach ($_POST['description'] as $key => $description) {
            $quantity = $_POST['quantity'][$key];
            $unitPrice = $_POST['unitPrice'][$key];
            $totalPrice = $_POST['totalPrice'][$key];
            $remarks = $_POST['remarks'][$key];

            // Insert into po_products table
            $insertSql = "INSERT INTO po_products (pop_description, pop_quantity, pop_unitPrice, pop_totalPrice, pop_remarks, pop_po_id) 
                    VALUES (:description, :quantity, :unitPrice, :totalPrice, :remarks, :po_id)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bindParam(':description', $description);
            $insertStmt->bindParam(':quantity', $quantity);
            $insertStmt->bindParam(':unitPrice', $unitPrice);
            $insertStmt->bindParam(':totalPrice', $totalPrice);
            $insertStmt->bindParam(':remarks', $remarks);
            $insertStmt->bindParam(':po_id', $po_id);

            $insertStmt->execute();
        }

        // Redirect after successful update
        header("Location: purchase_order.php");
        echo "good";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>