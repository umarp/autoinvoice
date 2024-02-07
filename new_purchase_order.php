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

            <h4>Purchase Order</h4>
            <form class="form" action="save_purchase_order.php" method="POST">
                <div class="mb-3">

                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Company Details</h2>
                            <label for="exampleInputPassword1" class="form-label">Company</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">

                            <label for="exampleInputPassword1" class="form-label">Address</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">

                            <label for="exampleInputPassword1" class="form-label">Phone</label>
                            <input type="password" class="form-control" id="exampleInputPassword1">
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-box">
                            <h2>Supplier Details</h2>
                            <div id="supplierInfo"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"></div>
                </div>
                <div class="row">
                    <div class="col-12"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
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