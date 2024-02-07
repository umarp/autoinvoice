<!doctype html>
<html lang="en">

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
      <form method="post" action="do_add_user.php">
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
          <label for="department" class="form-label">Department</label>
          <select class="form-select" id="department" name="department" required>
            <option value="sales">Sales</option>
            <option value="finance">Finance</option>
            <option value="hr">Human Resources</option>
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