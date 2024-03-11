<!doctype html>
<html lang="en">
<?php
include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $type = $_POST["type"];
    $clientId = $_POST["clientId"];
    $supplierId = $_POST["supplierId"];
    if ($type == "Supplier") {
        $clientSupplierId = $supplierId;
    } else {
        $clientSupplierId = $clientId;
    }

    $date = date("d-m-y");
    // Prepare the SQL statement
    $sql = "INSERT INTO customer_login (cl_firstName, 
    cl_lastName, cl_email, cl_password, cl_type, 
    cl_supplierCustomerId,cl_dateAdded)
                VALUES (:firstName, :lastName, 
                :email, :password, :type, :clientSupplierId,:date)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':clientSupplierId', $clientSupplierId);
    $stmt->bindParam(':date', $date);


    // Execute the prepared statement
    $stmt->execute();
    header('Location: customerLogin.php');
    // echo "New record created successfully";
}

?>

<head>
    <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    ?>

    <!--Container Main start-->
    <div class="container">
        <div class="container-fluid">

            <h4>Add Customer Login</h4>
            <form class="form-box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8"
                            required>
                        <div class="form-text">Password should be at least 8 characters.</div>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="type" class="form-label">Client or Supplier</label>
                        <select class="form-select" id="type" name="type" required onchange="toggleBox()">
                            <option></option>
                            <option value="Client">Client</option>
                            <option value="Supplier">Supplier</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3" id="supplierBox" style="display: none;">
                        <label for="supplierId" class="form-label">Supplier Name</label>
                        <select class="form-select" id="supplierId" name="supplierId" required>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM supplier");
                            $stmt->execute();
                            $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($suppliers as $supplier) {
                                echo "<option value='" . $supplier['s_id'] . "'>" . $supplier['s_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6 mb-3" id="clientBox" style="display: none;">
                        <label for="clientId" class="form-label">Client Name</label>
                        <select class="form-select" id="clientId" name="clientId" required>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM clients");
                            $stmt->execute();
                            $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($clients as $client) {
                                echo "<option value='" . $client['c_id'] . "'>" . $client['c_firstName'] . " " . $client['c_lastName'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <script>
                        function toggleBox() {
                            var type = document.getElementById("type").value;
                            if (type === "Client") {
                                document.getElementById("clientBox").style.display = "block";
                                document.getElementById("supplierBox").style.display = "none";
                            } else if (type === "Supplier") {
                                document.getElementById("clientBox").style.display = "none";
                                document.getElementById("supplierBox").style.display = "block";
                            }
                        }
                    </script>


                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>