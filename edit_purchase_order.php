<?php
include("./connection/connection.php");

// Check if the purchase order ID is provided via GET request
if (isset($_GET['id'])) {
    $po_id = $_GET['id'];

    try {
        // Retrieve the purchase order details from the database
        $stmt = $conn->prepare("SELECT * FROM purchase_order WHERE po_id = :po_id");
        $stmt->bindParam(':po_id', $po_id);
        $stmt->execute();
        $purchase_order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the purchase order exists
        if ($purchase_order) {
            // Retrieve product details associated with the purchase order
            $stmt = $conn->prepare("SELECT * FROM po_products WHERE pop_po_id = :po_id");
            $stmt->bindParam(':po_id', $po_id);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Redirect to an error page or show an error message
            echo "Purchase order not found.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to an error page or show an error message
    echo "Purchase order ID not provided.";
    exit();
}
?>

<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">
    <?php require_once("main/header.php"); ?>

    <div class="container">
        <div class="container-fluid">
            <h4>Edit Purchase Order</h4>
            <form class="form" action="update_purchase_order.php" method="POST">
                <!-- Display purchase order details -->
                <input type="hidden" name="po_id" value="<?php echo $purchase_order['po_id']; ?>">
                <div class="row">
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Company Details</h2>
                            <!-- Display company details -->
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-box form-group search-box">
                            <h2>Supplier Details</h2>
                            <!-- Display supplier details -->
                        </div>
                    </div>
                </div>
                <!-- Display product details -->
                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <table class="table table-bordered table-hover mt-4" id="poItems">
                            <!-- Display product details -->
                        </table>
                    </div>
                </div>
                <!-- Display subtotal, VAT, total, and general remarks -->
                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <label>General Remarks</label>
                        <textarea name="generalRemarks" class="form-control" rows="3">
                            <?php echo $purchase_order['po_remarks']; ?>
                        </textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>