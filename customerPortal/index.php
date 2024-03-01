<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoInvoice+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php
    session_start();
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
    }
    require_once("../connection/connection.php");
    ?>
    <style>
        .box {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../image/logo/logo-no-background.png" alt="Logo" width="100"
                    class="d-inline-block align-text-top">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a href="logout.php"><button class="btn btn-primary">Logout</button></a>
                </span>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <h2 class="mt-2">Welcome to the customer portal</h2>
                <?php
                if ($_SESSION['type'] == "Client") {
                    $stmt1 = $conn->prepare("SELECT * FROM clients WHERE c_id = :id");
                    $stmt1->bindParam(':id', $_SESSION['company']);
                    $stmt1->execute();
                    $client = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $clientSupplierid = $client['s_id'];
                    $clientSuppliername = $client['c_firstName'] . " " . $client['c_lastName'];
                } else {
                    $stmt2 = $conn->prepare("SELECT * FROM supplier WHERE s_id = :id");
                    $stmt2->bindParam(':id', $_SESSION['company']);
                    $stmt2->execute();
                    $supplier = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $clientSuppliername = $supplier['s_name'];
                    $clientSupplierid = $supplier['s_id'];

                }
                $stmt3 = $conn->prepare("SELECT * FROM purchase_order WHERE po_supplierId = :id");
                $stmt3->bindParam(':id', $clientSupplierid);
                $stmt3->execute();
                $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows3 as $row) {
                    echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Purchase Order Reference: ' . $row['po_refference'] . '</p>
                                        <p>From: ' . $row['po_companyAttn'] . '</p>
                                        <p>To: ' . $row['po_supplierAttn'] . '</p>
                                    </div>
                                        <div class="col-md-6">
                                        <p>Total Amount: ' . $row['po_total'] . '</p>
                                        <p>Date Issued: ' . $row['po_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_po.php?id= ' . $row['po_id'] . '" target="_blank" class="btn btn-success">Print Purchase Order</a>
                                </div>
                            </div>
                        </div>';
                }

                $stmt4 = $conn->prepare("SELECT * FROM purchase_order WHERE po_supplierId = :id");
                $stmt4->bindParam(':id', $clientSupplierid);
                $stmt4->execute();
                $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows4 as $row4) {
                    echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Invoice Reference: ' . $row['po_refference'] . '</p>
                                        <p>From: ' . $row4['po_companyAttn'] . '</p>
                                        <p>To: ' . $row4['po_supplierAttn'] . '</p>
                                    </div>
                                        <div class="col-md-6">
                                        <p>Total Amount: ' . $row4['po_total'] . '</p>
                                        <p>Date Issued: ' . $row4['po_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_po.php?id= ' . $row4['po_id'] . '" target="_blank" class="btn btn-success">Print Invoice</a>
                                </div>
                            </div>
                        </div>';
                }
                $stmt5 = $conn->prepare("SELECT * FROM purchase_order WHERE po_supplierId = :id");
                $stmt5->bindParam(':id', $clientSupplierid);
                $stmt5->execute();
                $rows5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows5 as $row5) {
                    echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Delivery Note Reference: ' . $row['po_refference'] . '</p>
                                        <p>From: ' . $row5['po_companyAttn'] . '</p>
                                        <p>To: ' . $row5['po_supplierAttn'] . '</p>
                                    </div>
                                        <div class="col-md-6">
                                        <p>Total Amount: ' . $row5['po_total'] . '</p>
                                        <p>Date Issued: ' . $row5['po_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_po.php?id= ' . $row5['po_id'] . '" target="_blank" class="btn btn-success">Print Delivery Note</a>
                                </div>
                            </div>
                        </div>';
                }


                ?>
            </div>
        </div>
    </div>

</body>

</html>