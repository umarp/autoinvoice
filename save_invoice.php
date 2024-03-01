<?php
include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the maximum reference from the purchase_order table
    $stmt = $conn->prepare("SELECT MAX(i_refference) AS ref FROM invoice");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxValue = $result['ref'];
    $ref = $maxValue + 1;

    // Extract data from the form
    $clientId = $_POST['clientName'];
    $currency = $_POST['currency'];
    $generalRemarks = $_POST['generalRemarks'];
    $subTotal = $_POST['subTotal'];
    $vatAmount = $_POST['vatAmount'];
    $total = $_POST['total'];

    // Assuming 'currency' is the user value
    $user = 'asd';
    $date = date("d-m-y");

    try {
        // Insert into the purchase_order table
        $sql = "INSERT INTO invoice (i_refference, i_clientId, i_currency, i_subTotal, i_vatAmount, i_total, i_remarks, i_user, i_date) 
                VALUES (:ref, :clientId, :currency, :subTotal, :vatAmount, :total, :generalRemarks, :user, :date)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ref', $ref);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':subTotal', $subTotal);
        $stmt->bindParam(':vatAmount', $vatAmount);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        // Get the last inserted ID
        $i_id = $conn->lastInsertId();

        // Loop through the product details
        foreach ($_POST['description'] as $key => $description) {
            $quantity = $_POST['quantity'][$key];
            $unitPrice = $_POST['unitPrice'][$key];
            $totalPrice = $_POST['totalPrice'][$key];
            $remarks = $_POST['remarks'][$key];

            // Insert into po_products table
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

        echo '<form method="GET" id="form" action="print_in.php" target="_blank">
            <input type="hidden" name="id" value="' . $i_id . '">
            </form>';


        header("Location: invoice.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>

<script>
    document.getElementById('form');
</script>