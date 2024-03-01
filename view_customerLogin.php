<!doctype html>
<html lang="en">

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    ?>
    <div class="container mt-5">
        <h2 class="mt-4">View customer Login info</h2>

        <?php

        try {
            include("connection/connection.php");

            // Check if user ID is provided in the URL
            if (isset($_GET['id'])) {
                $customerLoginId = $_GET['id'];

                // Retrieve user data from the database
                $stmt = $conn->prepare("SELECT * FROM customer_login WHERE cl_id = :id");
                $stmt->bindParam(':id', $customerLoginId);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    ?>
                    <form class="form-box">
                        <input type="hidden" name="customerLoginId" value="<?php echo $user['cl_id']; ?>">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    value="<?php echo $user['cl_firstName']; ?>" readonly>
                            </div>

                            <div class=" col-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    value="<?php echo $user['cl_lastName']; ?>" readonly>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $user['cl_email']; ?>" readonly>
                            </div>


                            <?php
                            if ($user['cl_type'] == "Client") {
                                $stmt1 = $conn->prepare("SELECT * FROM clients WHERE c_id = :id");
                                $stmt1->bindParam(':id', $user['cl_supplierCustomerId']);
                                $stmt1->execute();
                                $client = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $clientSupplier = $client['c_firstName'] . " " . $client['c_lastName'];
                            } else {
                                $stmt2 = $conn->prepare("SELECT * FROM supplier WHERE s_id = :id");
                                $stmt2->bindParam(':id', $user['cl_supplierCustomerId']);
                                $stmt2->execute();
                                $supplier = $stmt2->fetch(PDO::FETCH_ASSOC);
                                $clientSupplier = $supplier['s_name'];
                            }
                            ?>
                            <div class="col-6 mb-3">
                                <label for="department" class="form-label">Customer or Supplier</label>
                                <input type="text" class="form-control" id="type" name="type" value="<?php echo $clientSupplier; ?>"
                                    readonly>
                            </div>


                            <div class="col-6 mb-3">
                                <label for="date" class="form-label">Date Added</label>
                                <input type="text" class="form-control" value="<?php echo $user['cl_dateAdded']; ?>" readonly>
                            </div>
                        </div>


                    </form>
                    <?php
                } else {
                    echo "Customer Login not found.";
                }
            } else {
                echo "Customer Login ID not provided.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fa9pT4uFq5UK+YdklN/3eO7D5I1Gr9KM2Fzqsz5a6cA1x7Ff3kkzPQ0l7uwcDA"
        crossorigin="anonymous"></script>
</body>

</html>