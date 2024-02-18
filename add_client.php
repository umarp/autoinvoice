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
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];
    $currentDate = date("Y-m-d");

    // Prepare the SQL statement
    $sql = "INSERT INTO clients (c_firstName, c_lastName, c_email, c_phone, c_address, c_dob, c_dateAdded)
                VALUES (:firstName, :lastName, :email, :phone, :address, :dob, :date)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':dob', $dob);
    $stmt->bindParam(':date', $currentDate);

    // Execute the prepared statement
    $stmt->execute();
    header('Location: client.php');
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

            <h4>Add Client</h4>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>

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