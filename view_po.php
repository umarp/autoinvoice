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
        $po = $stmt->fetch(PDO::FETCH_ASSOC);

        $sup_id = $po['po_supplierId'];
        $po_currency = $po['po_currency'];
        $po_subTotal = $po['po_subTotal'];
        $po_vatAmount = $po['po_vatAmount'];
        $po_total = $po['po_total'];
        $po_remarks = $po['po_remarks'];


        $stmt1 = $conn->prepare("SELECT * FROM supplier WHERE s_id = :s_id");
        $stmt1->bindParam(':s_id', $sup_id);
        $stmt1->execute();
        $sup = $stmt1->fetch(PDO::FETCH_ASSOC);

        $stmt3 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=5");
        $stmt3->execute();
        $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
        $companyname = $result3['o_value'];

        $stmt4 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=6");
        $stmt4->execute();
        $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
        $vat = $result4['o_value'];

        $stmt5 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=7");
        $stmt5->execute();
        $result5 = $stmt5->fetch(PDO::FETCH_ASSOC);
        $brn = $result5['o_value'];

        $stmt6 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=8");
        $stmt6->execute();
        $result6 = $stmt6->fetch(PDO::FETCH_ASSOC);
        $address = $result6['o_value'];

        $stmt7 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=9");
        $stmt7->execute();
        $result7 = $stmt7->fetch(PDO::FETCH_ASSOC);
        $phone = $result7['o_value'];



        // Check if the purchase order exists
        if ($po) {
            // Retrieve product details associated with the purchase order
            $stmt2 = $conn->prepare("SELECT * FROM po_products WHERE pop_po_id = :po_id");
            $stmt2->bindParam(':po_id', $po_id);
            $stmt2->execute();
            $prod = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
            <h4>View Purchase Order</h4>
            <form class="form">
                <!-- Display purchase order details -->
                <input type="hidden" name="po_id" value="<?php echo $po['po_id']; ?>">
                <div class="row">
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Company Details</h2>
                            <label for="Company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="Company" readonly
                                value="<?php echo $companyname; ?>">

                            <label for="Address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="Address" readonly
                                value="<?php echo $address; ?>">

                            <label for="Phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="Phone" readonly value="<?php echo $phone; ?>">

                            <label for="Attention" class="form-label">Attention</label>
                            <input type="text" class="form-control" id="Attention" name="attention"
                                value="<?php echo $po['po_companyAttn']; ?>" readonly>
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-box form-group search-box">
                            <h2>Supplier Details</h2>

                            <div id="supplierInfo">

                                <label for="Company" class="form-label">Company</label>
                                <input type="text" class="form-control" id="Company" readonly
                                    value="<?php echo $sup["s_name"]; ?>">

                                <label for="Address" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" readonly
                                    value="<?php echo $sup["s_email"]; ?>">

                                <label for="Phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="Phone" readonly
                                    value="<?php echo $sup["s_phone"]; ?>">

                                <label for="Attention" class="form-label">Attention</label>
                                <input type="text" class="form-control" id="Attention" name="attention"
                                    value="<?php echo $po['po_supplierAttn']; ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Display product details -->
                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <div class="btn btn-primary" readonly>

                            <?php echo $po_currency; ?>

                        </div>


                        <table class="table table-bordered table-hover mt-4" id="poItems">
                            <thead>
                                <tr>
                                    <th>Desctiption</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                foreach ($prod as $pop) {
                                    $count++;
                                    echo '<tr>
                                    
                                    <td><input readonly type="text" name="description[]" id="description_' . $count . '" class="form-control"
                                            required value=' . $pop['pop_description'] . '></td>
                                    <td><input readonly type="number" name="quantity[]" id="quantity_' . $count . '"
                                            class="form-control quantity" required value=' . $pop['pop_unitPrice'] . '></td>
                                    <td><input readonly type="number" name="unitPrice[]" id="unitPrice_' . $count . '" step=".01"
                                            class="form-control unitPrice" required value=' . $pop['pop_quantity'] . '></td>
                                    <td><input readonly type="number" name="totalPrice[]" id="totalPrice_' . $count . '" step=".01"
                                            class="form-control totalPrice" required value=' . $pop['pop_totalPrice'] . '></td>
                                    <td><input type="text" readonly name="remarks[]" id="remarks_' . $count . '" 
                                            class="form-control" value=' . $pop['pop_remarks'] . '></td>
                                </tr>';
                                }
                                ?>


                            </tbody>
                        </table>


                    </div>

                    <div class="row">

                        <div class="col-md-3 form-group">
                            <label for="subTotal" class="mr-2">Sub total:</label>
                            <input type="number" class="form-control" name="subTotal" id="subTotal"
                                placeholder="Sub Total" step=".01" readonly value="<?php echo $po_subTotal; ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="vatAmount" class="mr-2">Vat Amount:</label>
                            <input type="number" class="form-control" name="vatAmount" id="vatAmount"
                                placeholder="Vat Amount" step=".01" readonly value="<?php echo $po_vatAmount; ?>">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="total" class="mr-2">Total:</label>
                            <input type="number" class="form-control" name="total" id="total" placeholder="Total"
                                step=".01" readonly value="<?php echo $po_total; ?>">
                        </div>
                    </div>

                </div>

                <!-- Display subtotal, VAT, total, and general remarks -->
                <div class="row mt-4 mb-4 form-box">
                    <div class="col-12">
                        <label>General Remarks</label>
                        <textarea name="generalRemarks" class="form-control" rows="3" readonly>
                            <?php echo $po['po_remarks']; ?>
                        </textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>


</html>