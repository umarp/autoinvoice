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
  $role = $_POST["role"];
  $accessInvoice = isset($_POST["accessInvoice"]) ? 1 : 0;
  $accessPurchaseOrder = isset($_POST["accessPurchaseOrder"]) ? 1 : 0;
  $accessDeliveryNote = isset($_POST["accessDeliveryNote"]) ? 1 : 0;

  // Prepare the SQL statement
  $sql = "INSERT INTO login (l_firstName, l_lastName, l_email, l_password, l_role, l_invoice, l_purchaseOrder, l_deliveryNote)
                VALUES (:firstName, :lastName, :email, :password, :role, :accessInvoice, :accessPurchaseOrder, :accessDeliveryNote)";

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':firstName', $firstName);
  $stmt->bindParam(':lastName', $lastName);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':password', $hashedPassword);
  $stmt->bindParam(':role', $role);
  $stmt->bindParam(':accessInvoice', $accessInvoice, PDO::PARAM_INT);
  $stmt->bindParam(':accessPurchaseOrder', $accessPurchaseOrder, PDO::PARAM_INT);
  $stmt->bindParam(':accessDeliveryNote', $accessDeliveryNote, PDO::PARAM_INT);

  // Execute the prepared statement
  $stmt->execute();
  header('Location: users.php');
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

      <h4>Add User</h4>
      <form class="form-box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" id="role" name="role" required>
            <option value="Staff">Staff</option>
            <option value="Manager">Manager</option>
            <option value="Admin">Admin</option>
          </select>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="accessInvoice" name="accessInvoice">
          <label class="form-check-label" for="accessInvoice">Access to Invoice</label>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="accessPurchaseOrder" name="accessPurchaseOrder">
          <label class="form-check-label" for="accessPurchaseOrder">Access to Purchase Order</label>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="accessDeliveryNote" name="accessDeliveryNote">
          <label class="form-check-label" for="accessDeliveryNote">Access to Delivery Note</label>
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