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

    // Prepare the SQL statement
    $sql = "UPDATE customer_login 
        SET cl_firstName = :firstName,
            cl_lastName = :lastName,
            cl_email = :email,
            cl_password = :password,
            cl_type = :type,
            cl_supplierCustomerId = :clientSupplierId
        WHERE cl_id = :cl_id";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':clientSupplierId', $clientSupplierId);
    $stmt->bindParam(':cl_id', $cl_id);



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
    <div class="container mt-5">
        <div class="container-fluid">

            <h2>Edit Customer Login</h2>
            <?php try {
                include("connection/connection.php");

                // Check if user ID is provided in the URL
                if (isset($_GET['id'])) {
                    $userId = $_GET['id'];

                    // Retrieve user data from the database
                    $stmt = $conn->prepare("SELECT * FROM customer_login WHERE cl_id = :id");
                    $stmt->bindParam(':id', $userId);
                    $stmt->execute();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($user) {
                        ?>
                        <form class="form-box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="cl_id" value="<?php echo $_GET['id']; ?>">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    value="<?php echo $user['cl_firstName']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    value="<?php echo $user['cl_lastName']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $user['cl_email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    value="<?php echo $user['cl_password']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Client or Supplier</label>
                                <select class="form-select" id="type" name="type" required onchange="toggleBox()">
                                    <option value="<?php echo $user['cl_type']; ?>"></option>
                                    <option value="Client">Client</option>
                                    <option value="Supplier">Supplier</option>
                                </select>
                            </div>
                            <div class="mb-3" id="supplierBox" <?php if ($user['cl_type'] === "Supplier")
                                echo "style='display:none;'"; ?>>
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
                            <div class="mb-3" id="clientBox" <?php if ($user['cl_type'] === "Client")
                                echo "style='display:none;'"; ?>>
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



                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                    <?php
                    } else {
                        echo "User not found.";
                    }
                } else {
                    echo "User ID not provided.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }


            ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>