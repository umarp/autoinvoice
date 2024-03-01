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
            <h4 class="mt-2">View Cutomers login info</h4>
            <hr>
            <div class="row mt-2 mb-4">
                <div class="col-12">
                    <a href="add_customerLogin.php">
                        <button class="btn btn-primary">Create a customer login</button>
                    </a>
                </div>

            </div>
            <table class="table table-hover cell-border" id="userTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Supplier/Client</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM customer_login";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row):
                        if ($row['cl_type'] == "Client") {
                            $stmt1 = $conn->prepare("SELECT * FROM clients WHERE c_id = :id");
                            $stmt1->bindParam(':id', $row['cl_supplierCustomerId']);
                            $stmt1->execute();
                            $client = $stmt1->fetch(PDO::FETCH_ASSOC);
                            $clientSupplier = $client['c_firstName'];
                        } else {
                            $stmt2 = $conn->prepare("SELECT * FROM supplier WHERE s_id = :id");
                            $stmt2->bindParam(':id', $row['cl_supplierCustomerId']);
                            $stmt2->execute();
                            $supplier = $stmt2->fetch(PDO::FETCH_ASSOC);

                            $clientSupplier = $supplier['s_name'];
                        }
                        echo "<tr>
                    <td><a href='view_customerLogin.php?id=" . $row['cl_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['cl_id'] . "</td>
                    <td>" . $row['cl_firstName'] . " </td>
                    <td>" . $row['cl_lastName'] . " </td>
                    <td>" . $row['cl_email'] . " </td>
                    <td>" . $clientSupplier . " </td>
                    <td><a href='edit_customerLogin.php?id=" . $row['cl_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteUser(" . $row['cl_id'] . ")'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable();
        });
    </script>
    <script>
        function deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'delete_customerLogin.php',
                        data: { userId: userId },
                        success: function (response) {
                            // Reload the page or update the table after successful deletion
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting user: ' + error
                            });
                        }
                    });
                }
            });
        }
    </script>
    <!-- Include SweetAlert script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>

</html>