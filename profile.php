<?php
include_once("includes/functions.php");
$isLogged = isLogged();
if ($isLogged == 3) {
    header("Location:index.php ");
}
?>
<!DOCTYPE html>

<head>
    <title>nstumart</title>
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/css/profile.css" />
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <style>
        body {
            padding-top: 140px;
        }
    </style>
</head>

<body>

    <?php
    drawHeader(1);
    ?>

    <section class="tabs px-5 pt-3 ">
        <div class="container">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">ADS</a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container active tab1" id="home">
                    <div class="row">


                        <?php
                        //Get UserID by sission
                        $UserID = $_SESSION['loggedInUserId'];

                        //Get DB products and display them
                        $result = mysqli_query($clink, "SELECT * FROM `advertisments` WHERE UserID=$UserID");
                        if (mysqli_num_rows($result) > 0) {
                            //Show them

                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['Status'] == 1) {
                                    echo "<div class=' col-lg-3 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3 '>
                                <div class='text-center card  h-100' > 
                                <a href='pageads.php?ADS-ID={$row['AdsID']}' >
                                <img  class='' src='assets/img/{$row['Image']}' class='card-img-top img-fluid' alt='...'>
                                </a>
                                <span class='float-left'> Tk {$row['Price']}</span>
                                    <div class='card-body p-0'>
                                    <div class='title'>
                                    <h5 style='display:inline-block;' class='card-title'>{$row['Title']}</h5>

                                    </div>
                                    <a href='Editads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary '>Edit Details</a>
                                </div> </div></div>";
                                } else {
                                    echo "
                            <div class=' col-lg-3 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-3' >
                             <div class='card text-center  h-100 ' >
                                    <img style='margin-left:15px' class='' src='assets/img/{$row['Image']}' class='card-img-top img-fluid' alt='...'>
                                        <div class='card-body'>
                                        <h5 class='card-title'>The advertisments is not active</h5>
                                        <a href='Editads.php?ADS-ID={$row['AdsID']}' class='btn btn-primary '>Edit Details</a>
                                    </div></div>
                                    </div>";
                                }
                            }
                        } else {
                            outputMessage("No products found in our catalog", 'warning');
                        }
                        ?>

                    </div>

                </div>

            </div>
    </section>
    <?php
    include_once("footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>