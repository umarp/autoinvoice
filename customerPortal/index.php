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
            box-shadow: 0px 0px 5px 5px grey;
        }

        body {


            font-family: "Lato", sans-serif;
            background-image: url("../image/background/7.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }

        .navbar {

            background-image: url("../image/background/1.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body>
    <?php
    $stmtlogo = $conn->prepare("SELECT * FROM organisation WHERE o_id = 1");
    $stmtlogo->execute();
    $logovalue = $stmtlogo->fetch(PDO::FETCH_ASSOC);
    $logo = $logovalue['o_value'];
    ?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../<?php echo $logo; ?>" alt="Logo" width="100" class="d-inline-block align-text-top">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item m-2">
                        <a href="index.php"><button class="btn btn-success">All documents</button></a>
                    </li>
                    <li class="nav-item m-2">
                        <a href="index.php?category=po"><button class="btn btn-success">All Purchase Orders</button></a>
                    </li>
                    <li class="nav-item m-2">
                        <a href="index.php?category=in"> <button class="btn btn-success">All invoice</button></a>

                    </li>
                    <li class="nav-item m-2">
                        <a href="index.php?category=dn"> <button class="btn btn-success">All Delivery Note</button></a>

                    </li>
                </ul>
                <span class="navbar-text">
                    <a href="logout.php"><button class="btn btn-danger">Sign Out</button></a>
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
                if (isset($_GET['category'])) {

                    if ($_GET['category'] == "po") {
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
                                    <a href="../print_po.php?id=' . $row['po_id'] . '" target="_blank" class="btn btn-primary">Print Purchase Order</a>
                                </div>
                            </div>
                        </div>';
                        }

                    } else if ($_GET['category'] == "in") {
                        $stmt4 = $conn->prepare("SELECT * FROM invoice WHERE i_clientId = :id");
                        $stmt4->bindParam(':id', $clientSupplierid);
                        $stmt4->execute();
                        $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows4 as $row4) {
                            echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Invoice Reference: ' . $row4['i_refference'] . '</p>

                                    </div>
                                        <div class="col-md-6">
                                        <p>Total Amount: ' . $row4['i_total'] . '</p>
                                        <p>Date Issued: ' . $row4['i_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_in.php?id=' . $row4['i_id'] . '" target="_blank" class="btn btn-primary">Print Invoice</a>
                                </div>
                            </div>
                        </div>';
                        }
                    } else if ($_GET['category'] == "dn") {
                        $stmt5 = $conn->prepare("SELECT * FROM delivery_note WHERE d_clientId = :id");
                        $stmt5->bindParam(':id', $clientSupplierid);
                        $stmt5->execute();
                        $rows5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows5 as $row5) {
                            echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Delivery Note Reference: ' . $row5['d_refference'] . '</p>
                                      
                                    </div>
                                        <div class="col-md-6">
                                     
                                        <p>Date Issued: ' . $row5['d_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_dn.php?id=' . $row5['d_id'] . '" target="_blank" class="btn btn-primary">Print Delivery Note</a>
                                </div>
                            </div>
                        </div>';
                        }
                    }

                } else {
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
                                    <a href="../print_po.php?id=' . $row['po_id'] . '" target="_blank" class="btn btn-primary">Print Purchase Order</a>
                                </div>
                            </div>
                        </div>';
                    }

                    $stmt4 = $conn->prepare("SELECT * FROM invoice WHERE i_clientId = :id");
                    $stmt4->bindParam(':id', $clientSupplierid);
                    $stmt4->execute();
                    $rows4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows4 as $row4) {
                        echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Invoice Reference: ' . $row4['i_refference'] . '</p>

                                    </div>
                                        <div class="col-md-6">
                                        <p>Total Amount: ' . $row4['i_total'] . '</p>
                                        <p>Date Issued: ' . $row4['i_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_in.php?id=' . $row4['i_id'] . '" target="_blank" class="btn btn-primary">Print Invoice</a>
                                </div>
                            </div>
                        </div>';
                    }
                    $stmt5 = $conn->prepare("SELECT * FROM delivery_note WHERE d_clientId = :id");
                    $stmt5->bindParam(':id', $clientSupplierid);
                    $stmt5->execute();
                    $rows5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows5 as $row5) {
                        echo '<div class="col-md-3">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Delivery Note Reference:' . $row5['d_refference'] . '</p>
                                      
                                    </div>
                                        <div class="col-md-6">
                                     
                                        <p>Date Issued: ' . $row5['d_date'] . '</p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="../print_dn.php?id=' . $row5['d_id'] . '" target="_blank" class="btn btn-primary">Print Delivery Note</a>
                                </div>
                            </div>
                        </div>';
                    }

                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>