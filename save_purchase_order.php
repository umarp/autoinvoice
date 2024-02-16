<?php
include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the maximum reference from the purchase_order table
    $stmt = $conn->prepare("SELECT MAX(po_refference) AS ref FROM purchase_order");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxValue = $result['ref'];
    $ref = $maxValue + 1;

    // Extract data from the form
    $supplierId = $_POST['companyName'];
    $currency = $_POST['currency'];
    $generalRemarks = $_POST['generalRemarks'];
    $subTotal = $_POST['subTotal'];
    $vatAmount = $_POST['vatAmount'];
    $total = $_POST['total'];

    // Assuming 'currency' is the user value
    $user = 'currency';
    $date = date("d-m-y");

    try {
        // Insert into the purchase_order table
        $sql = "INSERT INTO purchase_order (po_refference, po_supplierId, po_currency, po_subTotal, po_vatAmount, po_total, po_remarks, po_user, po_date) 
                VALUES (:ref, :supplierId, :currency, :subTotal, :vatAmount, :total, :generalRemarks, :user, :date)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ref', $ref);
        $stmt->bindParam(':supplierId', $supplierId);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':vatAmount', $vatAmount);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        // Get the last inserted ID
        $po_id = $conn->lastInsertId();

        // Loop through the product details
        foreach ($_POST['description'] as $key => $description) {
            $quantity = $_POST['quantity'][$key];
            $unitPrice = $_POST['unitPrice'][$key];
            $totalPrice = $_POST['totalPrice'][$key];
            $remarks = $_POST['remarks'][$key];

            // Insert into po_products table
            $sql = "INSERT INTO po_products (pop_description, pop_quantity, pop_unitPrice, pop_totalPrice, pop_remarks, pop_po_id) 
                    VALUES (:description, :quantity, :unitPrice, :totalPrice, :remarks, :po_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':unitPrice', $unitPrice);
            $stmt->bindParam(':totalPrice', $totalPrice);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':po_id', $po_id);
            $stmt->execute();
        }

        header("Location: purchase_order.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>