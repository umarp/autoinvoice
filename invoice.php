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
            <h4 class="mt-2">View Invoice</h4>
            <hr>
            <div class="row mt-2 mb-2">
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
                    <a href="add_user.php">
                        <div class="box">Add User</div>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row mt-2 mb-4">
                <div class="col-12">
                    <a href="new_invoice.php">
                        <button class="btn btn-primary">Create New Invoice</button>
                    </a>
                </div>
            </div>

            <table class="table table-hover cell-border" id="inTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>Refference</th>
                        <th>Client</th>
                        <th>Issued By</th>
                        <th>Total</th>
                        <th>Date Issued</th>
                        <th>Edit</th>
                        <th>Reprint</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM invoice i JOIN clients c WHERE i.i_clientId = c.c_id";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):
                        echo "<tr>
                    <td><a href='view_in.php?id=" . $row['i_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['i_id'] . "</td>
                    <td>" . $row['i_refference'] . "</td>
                    <td>" . $row['c_firstName'] . " " . $row['c_lastName'] . "</td>
                    <td>" . $row['i_user'] . "</td>
                    <td>" . $row['i_total'] . "</td>
                    <td>" . $row['i_date'] . "</td>


                     <td><a href='edit_invoice.php?id=" . $row['i_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                     <td><a href='print_in.php?id=" . $row['i_id'] . "' target='_blank'><button class='btn btn-primary'>Reprint</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteIn(" . $row['i_id'] . ")'>Delete</button></td>
                </tr>";
                    endforeach;
                    ?>

                </tbody>
            </table>

        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#inTable').DataTable();
        });
    </script>
    <script>
        function deleteIn(inId) {
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
                        url: 'delete_in.php',
                        data: { inId: inId },
                        success: function (response) {
                            // Reload the page or update the table after successful deletion
                            location.reload();
                            // console.log(response);
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting Invoice: ' + error
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