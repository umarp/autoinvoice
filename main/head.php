<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AutoInvoice+</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<link rel="stylesheet" href="style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="./js/script.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
require_once("./connection/connection.php");

session_start();

if (!isset($_SESSION['userRole'])) {
    session_destroy();
    header("Location: login.php");
}
if (isset($_SESSION['type'])) {
    session_destroy();
    header("Location: customerPortal/login.php");
}
if (
    $_SESSION['userRole'] == "Staff" && (basename($_SERVER['PHP_SELF']) == "users.php"
        || basename($_SERVER['PHP_SELF']) == "view_user.php"
        || basename($_SERVER['PHP_SELF']) == "organisation.php"
        || basename($_SERVER['PHP_SELF']) == "view_user.php"
        || basename($_SERVER['PHP_SELF']) == "customerLogin.php"
        || basename($_SERVER['PHP_SELF']) == "view_customerLogin.php"
        || basename($_SERVER['PHP_SELF']) == "edit_customerLogin.php"
        || basename($_SERVER['PHP_SELF']) == "do_edit_customerLogin.php")
) {
    echo "Access denied. You do not have permission to access this page.";
    // Perform logout
    session_destroy();
    header("Location: login.php?message=Access denied. You do not have permission to access this page");
    exit; // Terminate script execution after redirection
}
if (
    $_SESSION['userRole'] == "Manager" && (basename($_SERVER['PHP_SELF']) == "users.php"
        || basename($_SERVER['PHP_SELF']) == "view_user.php"
        || basename($_SERVER['PHP_SELF']) == "organisation.php"
        || basename($_SERVER['PHP_SELF']) == "view_user.php")
) {
    echo "Access denied. You do not have permission to access this page.";

    session_destroy();
    header("Location: login.php?message=Access denied. You do not have permission to access this page");
    exit;
}
?>