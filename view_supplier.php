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
        <h2>View Supplier</h2>

        <?php

        try {
            include("connection/connection.php");

            // Check if supplier ID is provided in the URL
            if (isset($_GET['id'])) {
                $supplierId = $_GET['id'];

                // Retrieve supplier data from the database
                $stmt = $conn->prepare("SELECT * FROM supplier WHERE s_id = :id");
                $stmt->bindParam(':id', $supplierId);
                $stmt->execute();
                $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($supplier) {
                    ?>
                    <form class="form-box">
                        <input type="hidden" name="supplierId" value="<?php echo $supplier['s_id']; ?>">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo $supplier['s_name']; ?>" readonly>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $supplier['s_email']; ?>" readonly>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="<?php echo $supplier['s_phone']; ?>" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo $supplier['s_address']; ?>" readonly>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country"
                                    value="<?php echo $supplier['s_country']; ?>" readonly>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="dateAdded" class="form-label">Date Added</label>
                                <input type="date" class="form-control" id="dateAdded" name="dateAdded"
                                    value="<?php echo $supplier['s_dateAdded']; ?>" readonly>
                            </div>
                        </div>

                    </form>
                    <?php
                } else {
                    echo "Supplier not found.";
                }
            } else {
                echo "Supplier ID not provided.";
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