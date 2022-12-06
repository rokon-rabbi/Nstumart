<?php
include_once("includes/functions.php");
$isLogged = isLogged();
if ($isLogged == 3) {
    header("Location:index.php ");
} ?>
<!DOCTYPE html>

<head>
    <title>nstumart</title>
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<style>
    body {

        /* padding-top: 140px; */
        min-height: 850px;
        background-image: url('img/shipping.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;
    }

    table {
        text-align: center;
    }

    .btn-danger {
        font-size: 25px;
        border-radius: 20px;
        height: 60px;
        width: 200px;
        margin-left: 15px;

    }

    label {
        float: left;
    }

    .form {
        margin-top: 42px;
        margin-left: 60px;
        width: 900px;
    }

    span {
        margin-right: 460px;
    }
</style>

<body>

    <?php
    drawHeader(1);

    ?>
    <?php

    $priceerror = $titleerror = $detailserror = $imageerror = $path = '';

    if (isset($_POST['save'])) {
        extract($_POST);
        //receive form data 
        $Title     = $_POST['ProTitle'];
        $Detalis = $_POST['ProDetalis'];
        $Detalis = str_replace("<", "&lt", $Detalis);
        $Detalis = str_replace(">", "&gt", $Detalis);
        $price     = $_POST['Proprice'];
        $Maincategory     = $_POST['Maincategory'];
        $UserID = $_SESSION['loggedInUserId'];
        $date = date("y-m-d");
        $submit = true;

        // Connect to DB SERVER 
        $errors = [];
        $successes = [];
        //$image 	= $_POST['image']; // receive file name ONLY
        $file_path = '';
        if ($_FILES['image']['name']) {
            $file_path = file_upload($_FILES, 'image');
            if ($file_path['status'] == false) {
                $submit = $file_path['status'];
            }
            $imageerror = $file_path['msg'];
            $path = $file_path['path'];
        }


        // $fileFinalName = '';
        // if($_FILES['image']['name']){
        //     $fileName 		= $_FILES['image']['name'];
        //     $fileType 		= $_FILES['image']['type'];
        //     $fileTmpName 	= $_FILES['image']['tmp_name'];
        //     $fileError 		= $_FILES['image']['error'];
        //     $fileSize 		= $_FILES['image']['size'];
        //     $fileFinalName = time().rand().'_'.$fileName ;
        //     //Move uploaded file from tmp directory to assets/images/products 
        //     move_uploaded_file($fileTmpName,"assets/img/{$fileFinalName}");
        //     }
        if (!$Title) {
            $titleerror = 'Title  Required';
            $submit = false;
        }

        if (!$Detalis) {
            $detailserror = 'Details can not be empty';
            $submit = false;
        }

        if (!$price) {
            $priceerror = 'Price  required';
            $submit = false;
        }


        if (is_numeric($price)) {
            echo "";
        } else {
            $errors[] = 'Please write the price correct';
        }
        if (
            $Title == "" ||
            $Detalis == "" ||
            $price == "" ||
            $Maincategory == "" ||
            $path == ""
        ) {
            $errors[] = 'Please Fill In All Data';
        }

        $result = mysqli_query($clink, "SELECT Image from advertisments where AdsID={$AdsID}");
        $row = mysqli_fetch_array($result);
        $oldImage = $row['Image'];
        // @unlink("assets/img/{$oldImage}");
        $ch = @mysqli_connect("localhost", 'root', '', 'nstumartdb') or die("Connection Failure");
        //Update the DB


        //3) SEND SQL query 
        if (count($errors) == 0) {
            $result = mysqli_query($ch, "UPDATE advertisments set Details='$ProDetalis',Price='$Proprice',Image='$path' , Title='$ProTitle' , CategoryID='$Maincategory' WHERE AdsID = '$AdsID'") or die("Cannot execute SQL - " . mysqli_error($clink));
            $successes[] = 'ADS has been successfully Edit';
            header("Location:profile.php");
        } else {
            $errors[] = "Please Follow The Instructions";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        //Add errors & success messages to the session to be displayed on the other pae	
    }

    ?>
    <section class="commercial-asd container">
        <?php

        //1) GET uid value from URL
        $AdsID = $_GET['ADS-ID'];


        //2) Connect to DB SERVER 
        $clink;

        //3) SEND SQL query -> SELECT
        $result = mysqli_query($clink, "	SELECT * FROM advertisments WHERE AdsID=$AdsID 	") or die("Cannot execute SQL - " . mysqli_error($clink));


        $row = mysqli_fetch_assoc($result);


        //4) Show edit form + insert data into the fields

        ?>


        <form class="form" action="./Editads.php" method="post" enctype="multipart/form-data">
            <div class="commercial-asd container">
                <div class="  billing-address bg-gray">
                    <div class="card text-center">
                        <div class="card-header">
                            <h4>Place an Ad</h4>
                        </div>
                        <div class=" card-body">

                            <div class="mb-3">
                                <label for="formGroupExampleInput2" class="form-label">Please write Your Product Title: </label>
                                <input type="text" name="ProTitle" placeholder="Title" alt="wating" class="form-control" id="formGroupExampleInput2" value="<?php echo $row['Title']; ?>">
                                <span style='color:red'><?php echo $titleerror; ?></span>

                                <label for="my-input" class="form-label">Please write Your Product Description: </label>
                                <textarea placeholder="Detalis" name="ProDetalis" id="my-input" class="form-control " value="<?php echo $row['Details']; ?>" placeholder="<?php echo $row['Details']; ?>" rows="5" required></textarea> <span style='color:red'><?php echo $detailserror; ?></span>
                                <!-- <textarea placeholder="Detalis" name="ProDetalis" id="my-input" class="form-control " rows="5"></textarea> -->

                                <div class="mb-3">
                                    <label for="formGroupExampleInput2" class="form-label">Please write Your Product price: </label>
                                    <input type="number" name="Proprice" placeholder="price" alt="wating" title="Pleaes write Your price" class="form-control" id="formGroupExampleInput2" value="<?php echo $row['Price']; ?>">
                                    <span style='color:red'><?php echo $priceerror; ?></span>
                                </div>

                                <div class="form-group ">
                                    <label class="input-group-text" for="inputGroupFile02">Select Image</label>
                                    <input type="file" class="form-control" name="image" id="inputGroupFile02" required>
                                    <span style='color:red'><?php echo $imageerror; ?></span>
                                    <?php
                                    if ($row['Image'] !== '') {
                                        echo "<img style='float:left' src='assets/img/{$row['Image']}' style='width:100px;'/> <br>";
                                    }
                                    ?>
                                </div>
                                <select class="kolo" name="Maincategory" value="<?php echo $row['CategoryID']; ?>">
                                    <?php
                                    $resultcategories = mysqli_query($clink, "SELECT CategoryID , CategoryName FROM categories");
                                    while ($rowcategories = mysqli_fetch_assoc($resultcategories)) {
                                        echo "<option  value='{$rowcategories['CategoryID']}'>{$rowcategories['CategoryName']}</option>";
                                    }

                                    ?>
                                </select>
                                <input type="hidden" name="AdsID" value="<?php echo $AdsID ?>">
                                <input class="btn" name="save" type="submit" value="save">
                                <a class="btn" href="deleteads.php?ADS-ID=<?php echo $AdsID ?>" style="color:#fff;background-color:red;">Delete</a>

                            </div>
                        </div>
                    </div>

                </div>


        </form>



    </section>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <?php
    include_once("footer.php");
    ?>
</body>

</html>