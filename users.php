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
            <div class="row mt-2 mb-4">
                <div class="col-12">
                    <a href="add_user.php">
                        <button class="btn btn-primary">Create New User</button>
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
                        <th>Role</th>
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
                    <td>" . $row['l_role'] . " </td>
                    <td><a href='edit_user.php?id=" . $row['l_id'] . "'><button class='btn btn-primary'>Edit</button></a></td>
                    <td><button class='btn btn-danger' onclick='deleteUser(" . $row['l_id'] . ",this.closest(`tr`))'>Delete</button></td>
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
        function deleteUser(userId, row) {
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
                            // Remove the row from the table
                            $(row).remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'User deleted successfully!'
                            });
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