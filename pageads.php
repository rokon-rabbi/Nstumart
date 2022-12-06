<?php
include_once("includes/functions.php");



?>
<!DOCTYPE html>

<head>
    <title>nstumart</title>
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/pageads.css" />
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

    <script>
        function getareas(cid) {
            $(document).ready(function() {
                $.get("getAreas.php?cid=" + cid, function(data, status) {
                    $("#areaDiv").html(data);
                });
            });
        }
    </script>
    <style>
        .control .addads {
            font-style: bold;
            font-size: 15px;
            float: right;
            width: 12%;
            margin: -46px 0 !important;
            color: #fff;
            background-color: #fff;
        }

        .card2 img {
            height: 150px;
            width: 100px;
            object-fit: contain;

        }
    </style>
</head>

<body>

    <?php
    drawHeader(1);
    ?>


    <section class="ads">
        <?php
        // get id ads to get information ads
        $AdsID = $_GET['ADS-ID'];
        $clink;
        $resultADS = mysqli_query($clink, "SELECT Date,Details,Price,Image,Status,Title,CategoryID,UserID FROM advertisments WHERE AdsID=$AdsID");
        $rowADS = mysqli_fetch_assoc($resultADS);
        $UserID = $rowADS['UserID'];
        // admin only can to visit this page
        if ($rowADS['Status'] == 0 && isLogged() !== 2) {
            header('location:index.php');
        }
        ######################### get information user by UserID owner ADS
        $resultuser = mysqli_query($clink, "SELECT UserName,Email,Phone,areaID FROM users WHERE UserID=$UserID");
        $rowuser = mysqli_fetch_assoc($resultuser);
        ######################### get name area  by areasID
        $areaID = $rowuser['areaID'];
        $resultareas = mysqli_query($clink, "SELECT areaName,cityID FROM areas WHERE areaID=$areaID");
        $rowareas = mysqli_fetch_assoc($resultareas);
        ######################### get name city by cityID
        $cityID = $rowareas['cityID'];
        $resultcity = mysqli_query($clink, "SELECT cityName FROM cities WHERE cityID=$cityID");
        $rowcity = mysqli_fetch_assoc($resultcity);
        ####################################################################################
        ########################## get name categories ID
        $CategoryID = $rowADS['CategoryID'];
        $resultCategory = mysqli_query($clink, "SELECT CategoryName FROM categories WHERE CategoryID=$CategoryID");
        $rowCategory = mysqli_fetch_assoc($resultCategory);
        #############################################################################  get name report user ID
        $AdsID;
        $resultreport = mysqli_query($clink, "SELECT UserID FROM report WHERE AdsID=$AdsID");
        $rowreport = mysqli_fetch_assoc($resultreport);
        ?>
        <div class="container">
            <hr>

            <div class="card h-100">
                <div class="row">
                    <aside class="col-sm-5 border-right">
                        <div class="text-center "> <a href="#"><img src='assets/img/<?php echo $rowADS['Image']; ?>'></a></div>
                        <hr>
                        <div class=" pl-5">
                            <dl class="param param-feature">
                                <dt>user name</dt>
                                <dd><?php echo $rowuser['UserName']; ?></dd>
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>Email </dt>
                                <dd><?php if (isLogged() == 1 || isLogged() == 2) {
                                        echo  $rowuser['Email'];
                                    } ?></dd>
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>phone</dt>
                                <dd><?php if (isLogged() == 1 || isLogged() == 2) {
                                        echo $rowuser['Phone'];
                                    }
                                    // else{
                                    //     echo"<span style='color:rgb(210, 210, 210);width: 33.3%'></span>";
                                    // }
                                    ?></dd>
                            </dl> <!-- item-property-hor .// -->
                            </dl> <!-- item-property-hor .// -->
                            <dl class="param param-feature">
                                <dt>Address</dt>
                                <dd><?php echo $rowcity['cityName'] . " , " . $rowareas['areaName']; ?></dd>
                            </dl> <!-- item-property-hor .// -->
                        </div> <!-- card-body.// -->
                    </aside>
                    <aside class="col-sm-7">
                        <article class="card-body p-9">
                            <h3 class=" mb-3"><?php echo $rowADS['Title']; ?></h3>
                            <dl class="item-property">
                                <dt>Description</dt>
                                <dd>
                                    <p><?php echo $rowADS['Details']; ?></p>
                                </dd>
                            </dl>
                            <dl class="param param-feature">
                                <dt>price</dt>
                                <dd><?php echo  $rowADS['Price'];
                                    echo ' Tk' ?></dd>
                                <dl class="param param-feature">
                                    <dt>date</dt>
                                    <dd><?php echo $rowADS['Date']; ?></dd>
                                </dl> <!-- item-property-hor .// -->
                                <dl class="param param-feature">
                                    <dt>category</dt>
                                    <dd><?php echo $rowCategory['CategoryName']; ?></dd>
                                </dl> <!-- item-property-hor .// -->
                                <hr>

                                <?php

                                if (isLogged() == 1 && $_SESSION['loggedInUserId'] !== isset($rowreport['UserID'])) {
                                    if (isset($_SESSION['loggedInUserId']) and $_SESSION['loggedInUserId'] !== $rowADS['UserID']) {
                                        echo '<a href="" class="btn btn-lg btn-danger text-uppercase float-right" data-toggle="modal" data-target="#myModal2">Report</a>';
                                    }
                                    echo "
                                    <div  class='modal' id='myModal2'>
                                            <div class='modal-dialog'>
                                                <div style='margin-top: 110px;box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);' class='modal-content LogIn'>
                                                    <div class='modal-header'>
                                                        <h4 class='modal-title'>Report</h4>
                                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <div class='col-12 float-left'>
                                                            <form action='Report.php' method='POST'>
                                                                <div class='form-group'>
                                                                    <textarea placeholder='Detalis' name='Detalis' id='my-input' class='form-control ' rows='5'></textarea>
                                                                    <input type='hidden' name='AdsID' value='$AdsID'>
                                                                </div>
                                                                <button type='submit' class='btn btn-lg btn-danger text-uppercase float-right'>send</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                } else if (isLogged() == 3) {

                                    echo "
                                <a href='' class='btn btn-lg btn-danger text-uppercase float-right' data-toggle='modal' data-target='#myModal'>Report</a>";
                                } else {
                                    echo "";
                                } ?>
                                <?php
                                if ($rowADS['Status'] == 1 && (isLogged() == 2)) {
                                    echo "<br><a href='adsshoworhide.php?ADS-ID={$AdsID}' class='btn btn-danger mt-0  float-right' >Hide<a>";
                                } else if ($rowADS['Status'] == 0 && (isLogged() == 2)) {
                                    echo "<br><a href='adsshoworhide.php?ADS-ID={$AdsID}' class='btn btn-primary mt-0 ' >Show<a>";
                                }
                                ?>
                        </article> <!-- card-body.// -->
                    </aside> <!-- col.// -->
                </div> <!-- row.// -->
            </div> <!-- card.// -->
        </div>
        <!--container.//-->

    </section>

    <section class="comment">

        <div class="container px-5">
            <?php
            // $resultcomments=mysqli_query($clink,"SELECT users.UserName, comments.Date, comments.Details , comments.UserID
            //                                             from users , comments 
            //                                             WHERE comments.AdsID=$AdsID 
            //                                             and users.UserID=comments.UserID");

            // while($rowcomments = mysqli_fetch_assoc($resultcomments)){
            // echo "<div class='card'>
            //     <div class='card-header'>{$rowcomments['UserName']}</div>
            //     <div class='card-body'>{$rowcomments['Details']}</div>
            //     <div class='card-footer text-right'>{$rowcomments['Date']}</div>
            // </div>";
            // used function
            echo "<div class='listcomments '>";
            $comments = getcomments();
            for ($i = 0; $i < @sizeof($comments); $i++) {
                if ($comments[$i]['Status'] == 1) {
                    echo "
                        <div class='p-1' >

                        <div class='com '>
                        <div class='card-header pt-1 pb-1'>    
                            <img src='assets/img/user.jpg'> <span class='float-right pt-4'>{$comments[$i]['Date']}</span>
                        {$comments[$i]['UserName']}</div>
                        <div class='card-body pt-2 pb-2 '>{$comments[$i]['Details']}</div>
                        </div>
                        ";
                    // show button
                    if ($comments[$i]['Status'] == 1 && (isLogged() == 2)) {
                        echo "<a href='commentshoworhide.php?comment-ID={$comments[$i]['commentID']}' class='btn btn-danger mt-2' >Hide<a>";
                    }
                    echo "</div> ";
                } else if (isLogged() == 2) {
                    echo "
                        <div class='p-1 ' >

                        <div class='com overright'>
                        <div class='card-header pt-1 pb-1'>    
                            <img src='assets/img/user.jpg'> <span class='float-right pt-4'>{$comments[$i]['Date']}</span>
                        {$comments[$i]['UserName']}</div>
                        <div class='card-body pt-2 pb-2'>{$comments[$i]['Details']}</div>
                        </div>
                        ";
                    // show button 
                    if ($comments[$i]['Status'] == 0 && (isLogged() == 2)) {
                        echo "<a href='commentshoworhide.php?comment-ID={$comments[$i]['commentID']}' class='btn btn-primary mt-2 ' >Show<a>";
                    }
                    echo "</div> ";
                } else {
                    echo "";
                }
            }
            ?>


        </div>
        <form action="sendcomment.php" method='POST'>
            <div class="form-group">
                <h5 style='display:block' class='card-title'><b>Comments:</b></h5>
                <input type="hidden" name="AdsID" value="<?php echo $AdsID ?>">
                <textarea class="form-control" name="textarea" rows="3"></textarea>
                <input <?php $isLogged = isLogged();
                        if ($isLogged == 1 || $isLogged == 2) {
                            echo "type='submit' class='btn btn-primary float-right 'value='send'  ";
                        } else {
                            echo "class='btn btn-primary float-right mb-5' data-toggle='modal' data-target='#myModal' value='send' name='submitlogin'";
                        }
                        ?>>
            </div>
        </form>
        </div>


    </section>

    <section class="ads">

        <div class="container">
            <h5 class='card-title'><b>Similar Products:</b></h5>

            <div class="row ">


                <?php
                //Get DB products and display them with limit

                $result = mysqli_query($clink, "SELECT * FROM advertisments , categories where categories.CategoryID= $CategoryID and advertisments.CategoryID = categories.CategoryID  LIMIT 4");
                if (isLogged() == 1) {
                    if (mysqli_num_rows($result) > 0) {
                        //Show them

                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['Status'] == 1 || isLogged() == 2) {
                                echo "<div style='display:inline-block' class=' col-lg-3 col-md-6 col-sm-6 offset-md-0 offset-sm-1 mb-3 '>
                           <div class='text-center  card card2 h-100' > 
                           <a href='pageads.php?ADS-ID={$row['AdsID']}' >
                           <img  class='' src='assets/img/{$row['Image']}' class='card-img-top img-fluid' alt='...'>
                           </a>
                           <span class='float-left'> Tk {$row['Price']}</span>
                               <div class='card-body p-0'>
                               <h5 style='' class='card-title'>{$row['Title']}</h5>
                               
                               <a href='pageads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary more'>More Details</a>
                               
                               ";



                                echo " </div> </div></div>";
                            }
                        }
                    } else {
                        outputMessage("No products found in our catalog", 'warning');
                    }
                }
                ?>

            </div>


        </div>

    </section>
    <?php
    include_once("footer.php");
    ?>
    <script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>