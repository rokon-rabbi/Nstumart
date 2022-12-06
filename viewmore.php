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

    .view:hover {
        text-decoration: none;
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
    <div class="container ">
        <div class="control d-flex  justify-content-around">
            <div class="search text-center">
                <form style="-top: 0px" method="get" action="index.php" class=" ">



                    <select class="select " name="Maincategory">
                        <option value='0'>CategoryName</option>
                        <?php
                        $resultcategories = mysqli_query($clink, "SELECT CategoryID , CategoryName FROM categories");
                        while ($rowcategories = mysqli_fetch_assoc($resultcategories)) {

                            echo "<option value='{$rowcategories['CategoryID']}'>{$rowcategories['CategoryName']}</option>";
                        }

                        ?>
                    </select><input type="submit" class="btn clicksearch" value="search">
                </form>
            </div>
        </div>
    </div>
    <div class='container' style="padding-right: 32px;">
        <div class="btn-group btn-group-justified col-sm-12 m-2">
            <a href="index.php?pricedp" class="btn btnselect ">Lowest price</a>
            <a href="index.php?pricepd" class="btn btnselect ">Highest price</a>
            <a href="index.php?New" class="btn btnselect ">New</a>
        </div>
    </div>
    <!-- first -->

    <section class="ads">
        <div class="container">
            <h5 style=' display:block;color:#3D443A' class='card-title'><b>Based on your last search</b></h5>
            <div class="row ">

                <?php

                //Get DB products and display them
                if (isset($_GET['pricedp'])) {
                    $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` ASC LIMIT $start_from, $limit ");
                } else if (isset($_GET['pricepd'])) {
                    $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`Price` DESC LIMIT $start_from, $limit ");
                } else if (isset($_GET['New'])) {
                    $result = mysqli_query($clink, "SELECT * FROM `advertisments` ORDER BY `advertisments`.`AdsID` DESC   LIMIT $start_from, $limit  ");
                } else if (isset($_GET['Maincategory']) and $_GET['Maincategory'] != 0) {

                    $categoryID = $_GET['Maincategory'];
                    $result = mysqli_query($clink, "SELECT * FROM advertisments , categories where categories.CategoryID= $categoryID and advertisments.CategoryID = categories.CategoryID LIMIT $start_from, $limit");

                    if (isLogged() == 1) {
                        $UserID = $_SESSION['loggedInUserId'];
                        $col = mysqli_query($clink, "SELECT * FROM `recommendation` WHERE UserID=$UserID ");

                        if (mysqli_num_rows($col) == 1) {
                            mysqli_query($clink, "UPDATE  `recommendation` SET CategoryID=$categoryID WHERE UserID= $UserID ");
                        } else if (mysqli_num_rows($col) == 0) {
                            mysqli_query($clink, "INSERT INTO `recommendation` (`UserID`, `CategoryID`) VALUES ($UserID ,$categoryID)");
                        }
                    }
                } else {
                    $UserID = $_SESSION['loggedInUserId'];
                    $rec = mysqli_query($clink, "SELECT * FROM advertisments ,recommendation where recommendation.UserID= $UserID and advertisments.CategoryID = recommendation.CategoryID ORDER BY `recommendation`.`rid` DESC   ");
                }
                if (mysqli_num_rows($rec) > 0) {
                    //Show them

                    while ($row = mysqli_fetch_assoc($rec)) {

                        if ($row['Status'] == 1 || isLogged() == 2) {
                            echo "<div class=' col-lg-3 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3 '>
                            <div class='text-center card  h-100' > 
                            <a href='pageads.php?ADS-ID={$row['AdsID']}' >
                            <img  class='' src='assets/img/{$row['Image']}' class='card-img-top img-fluid' alt='...'>
                            </a>
                            <span class='float-left'> Tk {$row['Price']}</span>
                                <div class='card-body p-0'>
                                <div class=''>
                                <h5 style='display:inline-block' class='card-title'>{$row['Title']}</h5>
                                </div>
                                
                                
                                <a href='pageads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary more'>More Details</a>
                                
                                ";


                            if ($row['Status'] == 1 && (isLogged() == 2)) {
                                echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}' class='btn btn-danger ml-2 ' >Hide</a>";
                            } else if ($row['Status'] == 0 && (isLogged() == 2)) {
                                echo "<a href='adsshoworhide.php?ADS-ID={$row['AdsID']}'  class='btn btn-primary  ml-2  ' >Show</a>";
                            }
                            echo " </div> </div></div>";
                        }
                    }
                } else {
                    outputMessage("No products found in our catalog", 'warning');
                }
                ?>


            </div>


        </div>
        <?php
        global $clink;
        $result_db = mysqli_query($clink, "SELECT COUNT(AdsID) FROM advertisments");
        $row_db = mysqli_fetch_row($result_db);
        $total_records = $row_db[0];
        $total_pages = ceil($total_records / $limit);
        /* echo  $total_pages; */

        echo '<ul style="margin-top: 50px;position:relative;z-index:1;" class="pagination justify-content-center">';
        if ($page > 1) {
            echo '<li class="page-item ">
 <a class="page-link" href="dashboard.php?page=' . ($page - 1) . '">Previous</a> 
  </li>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {

                $active = "active";
            } else {

                $active = "";
            }

            echo '<li class="page-item ' . $active . ' ">
   <a class="page-link" href="viewmore.php?page=' . $i . '">' . $i . '</a> 
    </li>';
        }
        if ($total_pages > $page) {
            echo '<li class="page-item ' . $active . ' ">
 <a class="page-link" href="viewmore.php?page=' . ($page + 1) . '">Next</a> 
  </li>';
        }
        echo '</ul>';

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

        <script>
            $(".owl-carousel").owlCarousel({
                loop: true,
                navRewind: true,
                margin: 10,
                nav: true,
                dots: false,
                navText: [
                    '<i class="fa-solid fa-angle-left"></i>',
                    '<i class="fa-solid fa-angle-right"></i> ',
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 3,
                    },
                    1000: {
                        items: 5,
                    },
                },
            });
        </script>
        <!-- dfjwerjh -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

        <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>