<!doctype html>
<html lang="en">
<?php
include("connection/connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $userId = $_POST["userId"];
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $department = $_POST["department"];
  $accessInvoice = isset($_POST["accessInvoice"]) ? 1 : 0;
  $accessPurchaseOrder = isset($_POST["accessPurchaseOrder"]) ? 1 : 0;
  $accessDeliveryNote = isset($_POST["accessDeliveryNote"]) ? 1 : 0;

  // Update user data in the database
  $stmt = $conn->prepare("UPDATE login SET 
            l_firstName = :firstName,
            l_lastName = :lastName,
            l_email = :email,
            l_password = :password,
           l_department = :department,
            l_invoice = :accessInvoice,
            l_purchaseOrder = :accessPurchaseOrder,
            l_deliveryNote = :accessDeliveryNote
            WHERE l_id = :id");

  $stmt->bindParam(':id', $userId);
  $stmt->bindParam(':firstName', $firstName);
  $stmt->bindParam(':lastName', $lastName);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $hashedPassword);
  $stmt->bindParam(':department', $department);
  $stmt->bindParam(':accessInvoice', $accessInvoice, PDO::PARAM_INT);
  $stmt->bindParam(':accessPurchaseOrder', $accessPurchaseOrder, PDO::PARAM_INT);
  $stmt->bindParam(':accessDeliveryNote', $accessDeliveryNote, PDO::PARAM_INT);

  $stmt->execute();

  echo "User updated successfully";
  header('Location: users.php');
}


?>

<head>
  <?php require_once("main/head.php") ?>
</head>

<body id="body-pd">


  <?php
  require_once("main/header.php");
  ?>
  <div class="container mt-5">
    <h2>Edit User</h2>

    <?php

    try {
      include("connection/connection.php");

      // Check if user ID is provided in the URL
      if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Retrieve user data from the database
        $stmt = $conn->prepare("SELECT * FROM login WHERE l_id = :id");
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
          ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <input type="hidden"
              name="userId" value="<?php echo $user['l_id']; ?>">
            <div class="row">
              <div class="col-6 mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName"
                  value="<?php echo $user['l_firstName']; ?>" required>
              </div>

              <div class=" col-6 mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName"
                  value="<?php echo $user['l_lastName']; ?>" required>
              </div>

              <div class="col-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['l_email']; ?>"
                  required>
              </div>

              <div class="col-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                  value="<?php echo $user['l_password']; ?>" required>
              </div>

              <div class="col-6 mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department"
                  value="<?php echo $user['l_department']; ?>" required>
              </div>
            </div>
            <div class="col-6 mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="accessInvoice" name="accessInvoice" <?php echo ($user['l_invoice'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="accessInvoice">Access to Invoice</label>
            </div>

            <div class="col-6 mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="accessPurchaseOrder" name="accessPurchaseOrder" <?php echo ($user['l_purchaseOrder'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="accessPurchaseOrder">Access to Purchase Order</label>
            </div>

            <div class="col-6 mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="accessDeliveryNote" name="accessDeliveryNote" <?php echo ($user['l_deliveryNote'] == 1) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="accessDeliveryNote">Access to Delivery Note</label>
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
          </form>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fa9pT4uFq5UK+YdklN/3eO7D5I1Gr9KM2Fzqsz5a6cA1x7Ff3kkzPQ0l7uwcDA" crossorigin="anonymous"></script>
</body>

</html>