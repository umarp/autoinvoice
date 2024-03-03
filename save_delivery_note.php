<html>

<?php
session_start();

include("./connection/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the maximum reference from the purchase_order table
    $stmt = $conn->prepare("SELECT MAX(d_refference) AS ref FROM delivery_note");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $maxValue = $result['ref'];
    $ref = $maxValue + 1;

    // Extract data from the form
    $clientId = $_POST['clientName'];
    $generalRemarks = $_POST['generalRemarks'];

    $user = $_SESSION['userLogin'];
    $date = date("y-m-d");

    try {
        // Insert into the purchase_order table
        $sql = "INSERT INTO delivery_note (d_refference,d_clientId, d_remarks, d_user, d_date) 
                VALUES (:ref, :clientId, :generalRemarks, :user, :date)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ref', $ref);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->bindParam(':generalRemarks', $generalRemarks);
        $stmt->bindParam(':user', $user);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        // Get the last inserted ID
        $d_id = $conn->lastInsertId();

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