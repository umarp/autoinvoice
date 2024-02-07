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
            <h4 class="mt-2">View Client</h4>
            <hr>
            <div class="row mt-4 mb-4">
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>
                <div class="col-3">
                    <div class="box">number of users: 10</div>
                </div>
                <div class="col-3">
                    <a href="add_client.php">
                        <div class="box">Add client</div>
                    </a>
                </div>
            </div>

            <hr>

            <table class="table table-hover cell-border" id="clientTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>DOB</th>
                        <th>Date Added</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM client";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):
                        echo "<tr>
                    <td><a href='view_client.php?id=" . $row['c_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['c_id'] . "</td>
                    <td>" . $row['c_firstName'] . " </td>
                    <td>" . $row['c_lastName'] . " </td>
                    <td>" . $row['c_email'] . " </td>
                    <td>" . $row['c_address'] . " </td>
                    <td>" . $row['c_phone'] . " </td>
                    <td>" . $row['c_dob'] . " </td>
                    <td>" . $row['c_dateAdded'] . " </td>
                    <td><a href='edit_client.php?id=" . $row['c_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteClient(" . $row['c_id'] . ")'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#clientTable').DataTable();
        });
    </script>
    <script>
        function deleteClient(clientId) {
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
                        url: 'delete_user.php',
                        data: { clientId: clientId },
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