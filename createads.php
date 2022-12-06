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
  <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>
<style>
  body {

    /* padding-top: 140px; */
    min-height: 850px;
    background-image: url('img/bgpay.jpg');
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

  .pay {
    margin-left: 345px;
    margin-bottom: 30px;
  }

  label {
    float: left;
  }



  .form {
    margin-top: 42px;
    margin-left: 5px;
    width: 900px;
  }

  .footer {
    margin-top: 600px;
  }

  .rule {
    margin-top: 60px;
    margin-right: 50px;
    margin-left: -5px;
    width: 350px;
    float: right;
    height: 900px;

  }

  span label {
    float: left;
    /* margin-right:460px; */
  }
</style>
<?php
error_reporting(0);
date_default_timezone_set('Asia/Dhaka');
//Generate Unique Transaction ID
function rand_string($length)
{
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $str = '';
  $size = strlen($chars);
  for ($i = 0; $i < $length; $i++) {
    $str .= $chars[rand(0, $size - 1)];
  }

  return $str;
}
$cur_random_value = rand_string(6);

?>

<body>
  <!-- <header class="header"> -->
  <?php
  drawHeader(1);

  ?>
  </div>
  <!--cart details end-->
  <div class="rule col-md-5">
    <div class="card">
      <div class="card-header" style="background:#ff0066;">
        <h4 style="color:#fff;">Rules and regulation for Ads </h4>
      </div>
      <div class="card-body" style="height:655px">
        <p><b>Seller:</b></p>
        <p>1. 5% ads cost will be charged<br>
          2. Uploaded file must be in jpg, jpeg, png & gif format and must be less than 2mb. <br>
          3. Unmatching product price will be punishable behavior. And make some charge. <br>
          4. Unethical Ads (selling drugs, gun, bombs, violation creating goods) will not accepted if anyone try to do it gain and again then it make some legal action.<br>
          5. Getting complain from buyer the author check it if the complain will right then seller will fill some penalty.</p>
        <p><b>Buyer:</b></p>
        <p>1. Invalid complain will be punishable guilty and we can take some legal action and make some penalty.</p>
        <p>2. Unethical comment will be also punishable and it can take some penalty and legal action.</p>
      </div>
      <div class="card-footer text-muted">
      </div>
    </div>
  </div>
  </div>
  </div>


  <?php
  $priceerror = $titleerror = $detailserror = $imageerror = $path = '';
  if (isset($_POST['save'])) {
    extract($_POST);
    //receive form data 
    $Title   = $_POST['ProTitle'];
    $Detalis = $_POST['ProDetalis'];
    $Detalis = str_replace("<", "&lt", $Detalis);
    $Detalis = str_replace(">", "&gt", $Detalis);
    $price   = $_POST['Proprice'];
    $Maincategory   = $_POST['Maincategory'];
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

    // if(!$path){
    //   $imageerror = 'Image requierd';
    //   $submit = false;
    // }


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

    //1) Connect to DB SERVER 
    //2) SELECT DB NAME 
    $ch = @mysqli_connect("localhost", 'root', '', 'nstumartdb') or die("Connection Failure");

    //3) SEND SQL query 
    if (count($errors) == 0 && $submit = true) {
      $result = mysqli_query($ch, "INSERT INTO `advertisments` (`AdsID`, `Date`, `Status`, `Details`, `Price`, `Image`, `Title`,
    `UserID`, `CategoryID`) VALUES (NULL, '$date', '0', '$Detalis', '$price', '$path', '$Title', '$UserID', '$Maincategory');
    ") or die("Cannot execute SQL - " . mysqli_error($ch));
      $successes[] = 'ADS has been successfully saved ';
      header("Location: profile.php");
    } else {
    }


    //Add errors & success messages to the session to be displayed on the other pae	
    $_SESSION['successes'] = $successes;
    $_SESSION['price'] = $price * 0.05;
  }
  ?>

  <section>

    <form class="form" action="./createads.php" method="post" enctype="multipart/form-data">
      <div class="commercial-asd container">
        <div class="  billing-address bg-gray">
          <div class="card text-center">
            <div class="card-header">
              <h4>Place an Ad</h4>
            </div>
            <div class=" card-body">

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Please write Your Product Title: </label>
                <input type="text" name="ProTitle" placeholder="Title" alt="wating" class="form-control" id="formGroupExampleInput2" value="<?php if (isset($ProTitle)) {
                                                                                                                                              echo $Title;
                                                                                                                                            } ?>" placeholder="" title="Pleaes write Your Title" required>
                <span style='color:red'><?php echo $titleerror; ?></span>
              </div>
              <label for="my-input" class="form-label">Please write Your Product Description: </label>
              <textarea placeholder="Detalis" name="ProDetalis" id="my-input" class="form-control " value="<?php if (isset($ProDetails)) {
                                                                                                              echo $Detalis;
                                                                                                            } ?>" rows="5" required></textarea>
              <span style='color:red'><?php echo $detailserror; ?></span>

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Please write Your Product price: </label>
                <input type="number" name="Proprice" placeholder="price" alt="wating" title="Pleaes write Your price" class="form-control" id="formGroupExampleInput2" value="<?php if (isset($Proprice)) {
                                                                                                                                                                                echo $price;
                                                                                                                                                                              } ?>" placeholder="" required>
                <span style='color:red'><?php echo $priceerror; ?></span>
              </div>

              <div class="form-group ">
                <label class="input-group-text" for="inputGroupFile02">Select Image</label>
                <input type="file" class="form-control" name="image" id="inputGroupFile02" required><br>

                <span style='color:red'><?php echo $imageerror; ?></span>
              </div>


              <label class="form-label" for="cat">Please Select Category:</label>
              <select class="form-select kolo" id="cat" name="Maincategory">
                <?php
                $resultcategories = mysqli_query($clink, "SELECT CategoryID , CategoryName FROM categories");
                while ($rowcategories = mysqli_fetch_assoc($resultcategories)) {
                  echo "<option value='{$rowcategories['CategoryID']}'>{$rowcategories['CategoryName']}</option>";
                }

                ?>
              </select>
              <input class="btn " name="save" type="submit" value="save">


            </div>
          </div>
        </div>

      </div>


    </form>




    </div>




  </section>

  <form style='margin:0 auto; text-align:center;' action="https://sandbox.aamarpay.com/index.php" method="post" name="form1">
    <table border="0" cellpadding="4" cellspacing="2" align="center" style="border-collapse:collapse;">
      <input type="hidden" name="store_id" value="aamarpay">
      <input type="hidden" name="signature_key" value="28c78bb1f45112f5d40b956fe104645a">


      <div style='border:2px' class="col-md-6 pay">
        <div class="col-md-12 billing-address bg-gray">
          <div style='background-color:#fff;' class="paym text-center">
            <div class="card-header">
              <h5><img src="img/amarpay.png" alt="amarpay-logo"></h5>
            </div>
            <div class="card-body">


              <input type="hidden" type="text" name="cus_add2" value="Dhaka">
              <input type="hidden" type="text" name="cus_city" value="Dhaka">
              <input type="hidden" type="text" name="cus_state" value="Dhaka">
              <input type="hidden" type="text" name="cus_postcode" value="1206">
              <input type="hidden" type="text" name="cus_country" value="Bangladesh">

              <input type="hidden" type="text" name="cus_fax" value="010000000">

              <input type="hidden" type="text" name="amount_vatratio" value="0">
              <input type="hidden" type="text" name="amount_vat" value="0">
              <input type="hidden" type="text" name="amount_taxratio" value="0">
              <input type="hidden" type="text" name="amount_tax" value="0">
              <input type="hidden" type="text" name="amount_processingfee_ratio" value="0">
              <input type="hidden" type="text" name="amount_processingfee" value="0">

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Merchant Transaction ID:</label>
                <input type="hidden" name="tran_id" value="WEP-<?php echo "$cur_random_value"; ?>">WEP-<?php echo "$cur_random_value"; ?>
              </div>

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Pay Amount: </label>
                <input type="text" name="amount" value="<?php echo ("{$_SESSION['price']}" . " "); ?>" class="form-control" id="formGroupExampleInput2" placeholder="" required>
              </div>

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Currency name: </label>
                <input type="text" name="currency" value="BDT" class="form-control" id="formGroupExampleInput2" placeholder="" required>
              </div>

              <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Seller Name: </label>
                <input type="text" name="cus_name" class="form-control" id="formGroupExampleInput" placeholder="Enter your name" required>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Seller Email Address:</label>
                <input type="text" name="cus_email" class="form-control" id="formGroupExampleInput2" placeholder="E-mail" required>
              </div>

              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Seller Address:</label>
                <input type="text" name="cus_add1" class="form-control" id="formGroupExampleInput2" placeholder="Address" required>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Seller Phone:</label>
                <input type="text" name="cus_phone" class="form-control" id="formGroupExampleInput2" placeholder="Mobile number" required>
              </div>
              <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Product Description:</label>
                <input type="text" name="desc" class="form-control" id="formGroupExampleInput2" placeholder="" required>
              </div>

              <input type="hidden" name="success_url" value="http://localhost/project2/success.php">
              <input type="hidden" name="fail_url" value="http://localhost/project2/fail.php">
              <input type="hidden" name="cancel_url" value="http://localhost/project2/cancel.php">
              <input type="submit" class='button btn-danger' value="Pay Now" name="pay">

            </div>
          </div>
        </div>
      </div>


  </form>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <?php
  include_once("footer.php");
  ?>

</body>

</html>