<html>

<?php
session_start();
var_dump($_POST);
include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Extract data from the form
    $d_id = $_POST['d_id'];
    $clientId = $_POST['clientName'];
    $generalRemarks = $_POST['generalRemarks'];
    $user = $_SESSION['userLogin'];

    try {
        // Insert into the purchase_order table
        $sql = "UPDATE delivery_note SET 
                d_clientId = :clientId, 
                d_remarks = :generalRemarks, 
                d_user = :user

                WHERE d_id = :d_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':d_id', $d_id);

        $stmt->execute();

        $deleteSql = "DELETE FROM delivery_products WHERE dp_d_id = :d_id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bindParam(':d_id', $d_id);
        $deleteStmt->execute();
        // Loop through the product details
        foreach ($_POST['description'] as $key => $description) {
            $quantity = $_POST['quantity'][$key];
            $remarks = $_POST['remarks'][$key];

            // Insert into po_products table
            $sql = "INSERT INTO delivery_products (dp_description, dp_quantity, dp_remarks, dp_d_id) 
                    VALUES (:description, :quantity, :remarks, :d_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':d_id', $d_id);
            $stmt->execute();
        }

        echo '<form action="print_dn.php" method="GET" id="form1"  target="_blank">
            <input type="text" name="id" value="' . $d_id . '">
        </form>';
        echo '<script>console.log("??");document.getElementById("form1").submit();</script>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}

?>

</html>