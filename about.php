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
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    ul {
        -bottom: 200px;
    }

    /* recommendation */
    .priceTk {
        background-color: rgba(0, 0, 0, 0.8);
        position: absolute;
        color: #fff;
        padding: 5px;
        min-width: 50px;
    }

    .card {
        height: 100%;
        overflow: hidden;
        padding: 1px;
        margin: 10px 10px;
    }



    /* .title2{
    width:400px;
    text-overflow: ellipsis;
    white-space:nowrap;
    overflow:hidden;
   
} */
</style>

<body>
    <?php
    drawHeader(1);
    ?>
    <!-- slider-start -->
    <img style="margin-top:-30px" src="img/about.png" class="img-fluid" alt="Responsive image">
    </div>

    <!-- slider-end -->

    <!-- team start -->
    <div class="team-area pt-95 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                    <div class="section-title mb-50 text-center">
                        <div class="section-title-heading mb-20">
                            <h1 style="padding:30px 100px ;" class="primary-color">Our Team</h1>
                            <hr>
                        </div>
                        <div style="padding:40px 50px ;" class="section-title-para">
                            <p class="gray-color">"Talent wins games, but teamwork and intelligence win championships." – Michael Jordan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="team-list">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="team-wrapper mb-30">
                            <div class="team-thumb">
                                <img src="img/sumon.jpg" width="270" height="335" alt="">
                            </div>
                            <div class="team-social-info text-center">
                                <div class="team-social-para">
                                    <p>Assistant professor - Noakhali Science and Technology University</p>
                                </div>

                            </div>
                            <div class="team-teacher-info text-center">
                                <h1>Auhidur Rahman</h1>
                                <h2>Project Mentor</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="team-wrapper mb-30">
                            <div class="team-thumb">
                                <img src="img/rokon.jpg" width="270" height="335" alt="">
                            </div>
                            <div class="team-social-info text-center">
                                <div class="team-social-para">
                                    <p>Student - Noakhali Science and Technology University</p>
                                </div>

                            </div>
                            <div class="team-teacher-info text-center">
                                <h1>Md.Rokonuzzaman</h1>
                                <h2>Web Desiner & Developer</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="team-wrapper mb-30">
                            <div class="team-thumb">
                                <img src="img/raju.jpg" width="270" height="335" alt="">
                            </div>
                            <div class="team-social-info text-center">
                                <div class="team-social-para">
                                    <p>Student - Noakhali Science and Technology University</p>
                                </div>

                            </div>
                            <div class="team-teacher-info text-center">
                                <h1>Md.Raju Biswas</h1>
                                <h2>Web Designer & Developer</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="team-wrapper mb-30">
                            <div class="team-thumb">
                                <img src="img/dhruba.jpg" width="270" height="335" alt="">
                            </div>
                            <div class="team-social-info text-center">
                                <div class="team-social-para">
                                    <p>Student - Noakhali Science and Technology University</p>
                                </div>
                                <!-- <div class="team-social-icon-list">
                                    <ul>
                                        <li><a href="#"><span class="ti-facebook"></span></a></li>
                                        <li><a href="#"><span class="ti-twitter-alt"></span></a></li>
                                        <li><a href="#"><span class="ti-google"></span></a></li>
                                        <li><a href="#"><span class="ti-linkedin"></span></a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="team-teacher-info text-center">
                                <h1>Dhruba kanto bakshi</h1>
                                <h2>Designer & Tester</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    ?>
    <?php
    include_once("footer.php");
    ?>

    <script src="assets/js/jquery.min.js"></script>
    <!-- script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>


    <!-- dfjwerjh -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>