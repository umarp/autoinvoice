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
            <h4 class="mt-2">View Users</h4>
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
                    <a href="add_user.php">
                        <div class="box">Add User</div>
                    </a>
                </div>
            </div>

            <hr>

            <table class="table table-hover cell-border" id="userTable">
                <thead>
                    <tr>
                        <th>View</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM login";
                    $stmt = $conn->query($query);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row):
                        echo "<tr>
                    <td><a href='view_user.php?id=" . $row['l_id'] . "'><button class='btn btn-secondary'>View</button></a></td>
                    <td>" . $row['l_id'] . "</td>
                    <td>" . $row['l_firstName'] . " </td>
                    <td>" . $row['l_lastName'] . " </td>
                    <td>" . $row['l_email'] . " </td>
                    <td>" . $row['l_department'] . " </td>
                    <td><a href='edit_user.php?id=" . $row['l_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteUser(" . $row['l_id'] . ")'>Delete</button></td>
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
                        url: 'delete_user.php',
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