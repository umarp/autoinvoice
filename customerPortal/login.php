<?php

require_once("../connection/connection.php");
$error = 0;
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve form data
    $cl_email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to select user with provided username
    $stmt = $conn->prepare('SELECT * FROM customer_login WHERE cl_email = :cl_email');
    $stmt->execute(['cl_email' => $cl_email]);

    // Fetch the user
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists and password matches, login successful
    if ($user && password_verify($password, $user['cl_password'])) {

        session_start();
        $_SESSION['login'] = $cl_email;
        $_SESSION['type'] = $user['cl_type'];
        $_SESSION['company'] = $user['cl_supplierCustomerId'];

        header('Location: index.php');


    } else {
        $error = 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoInvoice+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />


    <style>
        .container-fluid {
            max-width: 600px;
            /* Adjust the width as needed */
            width: 100%;
            padding: 20px;
            border: 3px solid #ccc;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        body {
            background-image: url("../image/background/bg.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="container-fluid p-4 bg-light  ">
            <h1 class="text-center">AutoInvoice+</h1>
            <h4 class="text-center">Customer Portal</h4>
            <form method="post" class="mt-4">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <h5 class="mt-2">
                <?php if ($error == 1) {
                    echo "Invalid username or password";
                } ?>
            </h5>
        </div>
    </div>

</body>

</html>