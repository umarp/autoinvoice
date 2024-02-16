<!doctype html>
<html lang="en">
<?php


include("connection/connection.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST["clientId"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $dob = $_POST["dob"];

    // Update user data in the database
    $stmt = $conn->prepare("UPDATE clients SET 
            c_firstName = :firstName,
            c_lastName = :lastName,
            c_email = :email,
            c_phone = :phone,
            c_address = :address,
            c_dob = :dob
            WHERE c_id = :id");

    $stmt->bindParam(':id', $userId);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':dob', $dob);

    $stmt->execute();

    header("Location: client.php");
    exit;
}
?>

<head>
    <?php require_once("main/head.php");
    require_once("main/header.php"); ?>

</head>

<body id="body-pd">

    <div class="container mt-5">
        <h2>Edit Client</h2>

        <?php

        try {

            // Check if client ID is provided in the URL
            if (isset($_GET['id'])) {
                $clientId = $_GET['id'];

                // Retrieve Client data from the database
                $stmt = $conn->prepare("SELECT * FROM clients WHERE c_id = :id");
                $stmt->bindParam(':id', $clientId);
                $stmt->execute();
                $client = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($client) {
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="clientId" value="<?php echo $client['c_id']; ?>">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    value="<?php echo $client['c_firstName']; ?>" required>
                            </div>

                            <div class=" col-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    value="<?php echo $client['c_lastName']; ?>" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo $client['c_email']; ?>" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone"
                                    value="<?php echo $client['c_phone']; ?>" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="phone" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo $client['c_address']; ?>" required>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="dob" class="form-label">Date of birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $client['c_dob']; ?>"
                                    required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="dob" class="form-label">Date Added</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $client['c_dob']; ?>"
                                    readonly>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Client</button>
                    </form>
                    <?php
                } else {
                    echo "Client not found.";
                }
            } else {
                echo "Client ID not provided.";
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