<!doctype html>
<html lang="en">

<head>
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
</head>

<body id="body-pd">


    <?php
    require_once("main/header.php");
    if (isset($_GET['id'])) {
        $d_id = $_GET['id'];

        try {
            // Retrieve the delivery note details from the database
            $stmt = $conn->prepare("SELECT * FROM delivery_note WHERE d_id = :d_id");
            $stmt->bindParam(':d_id', $d_id);
            $stmt->execute();
            $d = $stmt->fetch(PDO::FETCH_ASSOC);

            $client_id = $d['d_clientId'];
            $d_remarks = $d['d_remarks'];

            $stmtc = $conn->prepare("SELECT * FROM clients WHERE c_id = :c_id");
            $stmtc->bindParam(':c_id', $client_id);
            $stmtc->execute();
            $client = $stmtc->fetch(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=5");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $companyname = $result['o_value'];

            $stmt1 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=6");
            $stmt1->execute();
            $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $vat = $result1['o_value'];

            $stmt2 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=7");
            $stmt2->execute();
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $brn = $result2['o_value'];

            $stmt3 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=8");
            $stmt3->execute();
            $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
            $address = $result3['o_value'];

            $stmt4 = $conn->prepare("SELECT o_value FROM organisation WHERE o_id=9");
            $stmt4->execute();
            $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
            $phone = $result4['o_value'];


            // Check if the delivery note exists
            if ($d) {
                // Retrieve product details associated with the delivery noter
                $stmt2 = $conn->prepare("SELECT * FROM delivery_products WHERE dp_d_id = :d_id");
                $stmt2->bindParam(':d_id', $d_id);
                $stmt2->execute();
                $prod = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Redirect to an error page or show an error message
                echo "Delivery Note not found.";
                exit();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Redirect to an error page or show an error message
        echo "Delivery Note ID not provided.";
        exit();
    }
    ?>
    <!--Container Main start-->
    <div class="container">
        <div class="container-fluid">

            <h4>Delivery Note</h4>
            <form class="formdn" action="do_edit_delivery_note.php" method="POST">
                <input type="hidden" name="d_id" value="<?php echo $d['d_id']; ?>">

                <div class="row">
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Company Details</h2>
                            <label for="Company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="Company" readonly
                                value="<?php echo $companyname; ?>">

                            <label for="Address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="Address" readonly
                                value="<?php echo $address; ?>">

                            <label for="Phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="Phone" readonly value="<?php echo $phone; ?>">


                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-box form-group search-box">
                            <h2>Client Details</h2>
                            <div class="row">
                                <div class="col">
                                    <label for="companyName">Select Client name</label>
                                    <input type="text" class="form-control" placeholder="Type to search...">
                                </div>
                                <div class="col">
                                    <label>&nbsp;</label>
                                    <select name="clientName" class="result form-control" id="selectBox">
                                        <option value="<?php echo $client_id; ?>">
                                            <?php echo $client["c_firstName"] . " " . $client["c_lastName"]; ?>
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <div id="clientInfo">
                                <label for="Company" class="form-label">Client</label>
                                <input type="text" class="form-control" id="Company" readonly
                                    value="<?php echo $client["c_firstName"] . " " . $client["c_lastName"]; ?>">

                                <label for="Address" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" readonly
                                    value="<?php echo $client["c_email"]; ?>">

                                <label for="Phone" class="form-label">Phone</label>
                                <input type="number" class="form-control" id="Phone" readonly
                                    value="<?php echo $client["c_phone"]; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 form-box">
                    <div class="col-12">
                        <table class="table table-bordered table-hover mt-4" id="dnItems">
                            <thead>
                                <tr>
                                    <th><input id="checkAll1" class="formcontrol" type="checkbox"></th>
                                    <th>Desctiption</th>
                                    <th>Quantity</th>

                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count1 = 0;
                                foreach ($prod as $dp) {
                                    $count1++;
                                    echo '<tr>
                                    <td><input type="checkbox" class="itemRow1"></td>
                                    <td><input type="text" name="description[]" id="description_' . $count1 . '" class="form-control"
                                            required value=' . $dp['dp_description'] . '></td>
                                    <td><input type="number" name="quantity[]" id="quantity_' . $count1 . '"
                                            class="form-control quantity" required value=' . $dp['dp_quantity'] . '></td>
      
                                    <td><input type="text" name="remarks[]" id="remarks_' . $count1 . '" class="form-control" value=' . $dp['dp_remarks'] . '></td>
                                </tr>';
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="btn-group" role="group">
                                <a class="btn btn-danger" id="removeRows1">- Remove</a>
                                <a class="btn btn-success" id="addRows1">+ Add More</a>
                            </div>
                        </div>

                    </div>


                </div>


                <div class="row mt-4 mb-2 form-box">
                    <div class="col-12"><label>General Remarks</label>
                        <textarea name="generalRemarks" class="form-control" id="generalRemarks" rows="3">
                            <?php echo $d_remarks; ?>
                        </textarea>

                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>


<!-- Your JavaScript code -->
<script>
    $(document).ready(function () {
        $('.search-box input[type="text"]').on("keyup input", function () {
            var inputVal = $(this).val();
            var resultDropdown = $('#selectBox'); // Selecting the selectBox element
            if (inputVal.length) {
                $.get("searchClients.php", {
                    term: inputVal,
                }).done(function (data) {
                    resultDropdown.html(data); // Update the selectBox with the search results
                });
            } else {
                resultDropdown.empty();
            }
        });

        $(document).on("click", "#selectBox", function () {

            var selectedValue = $(this).val();
            if (selectedValue !== 'Click to select') {
                $.get("clientDetails.php", {
                    id: selectedValue,
                }).done(function (data) {
                    $('#clientInfo').html(data);
                    // Set the HTML of #supplierInfo
                });
            } else {
                $('#clientInfo').empty();
            }
        });

    });
    //deliver Note JS

    //check All
    $(document).on("click", "#checkAll1", function () {
        $(".itemRow1").prop("checked", this.checked);
    });

    $(document).on("click", ".itemRow1", function () {
        if ($(".itemRow1:checked").length == $(".itemRow1").length) {
            $("#checkAll1").prop("checked", true);
        } else {
            $("#checkAll1").prop("checked", false);
        }
    });

    // add row
    var count1 = $(".itemRow1").length;
    $(document).on("click", "#addRows1", function () {
        count1++;
        var newRow1 = "";
        newRow1 += "<tr>";
        newRow1 += '<td><input class="itemRow1" type="checkbox"></td>';
        newRow1 +=
            '<td><input class="form-control" type="text" id="description_' +
            count1 +
            '" name="description[]" required></td>';
        newRow1 +=
            '<td><input class="form-control quantity" type="number" id="quantity_' +
            count1 +
            '" name="quantity[]" required></td>';

        newRow1 +=
            '<td><input class="form-control" type="text" id="remarks_' +
            count1 +
            '" name="remarks[]" > </td>';

        newRow1 += "</tr>";
        $("#dnItems tbody").append(newRow1); // Changed to append to tbody
    });

    //Remove Rows
    $(document).on("click", "#removeRows1", function () {
        $(".itemRow1:checked").each(function () {
            $(this).closest("tr").removed;
        });
        $("#checkAll1").prop("checked", false);
    });
</script>





</html>