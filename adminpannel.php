<?php
include_once("includes/functions.php");
$limit = 14;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

?>
<!DOCTYPE html>

<head>
    <title>nstumart</title>
    <!-- favicon -->

    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" type="text/css" href="assets/css/owl.css" />
    <script>
        function getareas(cid) {
            $(document).ready(function() {
                $.get("getAreas.php?cid=" + cid, function(data, status) {
                    $("#areaDiv").html(data);
                });
            });
        }
    </script>
</head>

<style>

</style>

<body>
    <?php
    drawHeader(1);
    ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12 p-5">
                <span>
                    <h1> <i class="fa-solid fa-gauge-high" aria-hidden="true"></i> Dashboard</h1>
                </span>

                <hr />
            </div>
        </div>
        <div style="margin-left:100px" class="row">


            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                <a class="text-decoration-none" href="dashboard.php">
                    <div class="card p-3 shadow bg-purple text-center border-0">
                        <div class="card-body">
                            <i class="fas fa-ad fa-2x" aria-hidden="true"></i>
                            <hr />
                            <p class="card-title lead">Users ads</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                <a class="text-decoration-none" href='controlAccountsUsers.php'>
                    <div class="card p-3 shadow bg-purple text-center border-0">
                        <div class="card-body">
                            <i class="fa-solid fa-user fa-2x" aria-hidden="true"></i>
                            <hr />
                            <p class="card-title lead">Users</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                <a class="text-decoration-none" href="reports.php">
                    <div class="card p-3 shadow bg-purple text-center border-0">
                        <div class="card-body">
                            <i class="fa-solid fa-file fa-2x" aria-hidden="true"></i>
                            <hr />
                            <p class="card-title lead">Reports</p>
                        </div>
                    </div>
                </a>
            </div>


            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
                <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#modelHELP">
                    <div class="card p-3 shadow bg-purple text-center border-0">
                        <div class="card-body">
                            <i class="fa fa-question fa-2x" aria-hidden="true"></i>
                            <hr />
                            <p class="card-title lead">Support</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modelHELP" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-question-circle-o" aria-hidden="true"></i> Technical Support
                        24/7</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-5">
                    <p>
                        <small>(Mon - Sat / 10AM - 6PM)</small>
                    </p>
                    <hr />
                    <p> <i class="fa fa-envelope mr-3" aria-hidden="true"></i> </p>
                    <p><i class="fa fa-volume-control-phone mr-3" aria-hidden="true"></i> 01750035431 </p>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <?php
    include_once("footer.php");
    ?>

</body>

</html>