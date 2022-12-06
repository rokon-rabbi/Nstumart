<?php
session_start();
include_once("includes/config.php");

################################################# DB CONNECTION

function dbConnect()
{
	global $dbHost, $dbUser, $dbPass, $dbName;

	$clink = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName) or die("Connection Failed");
	return $clink;
}
$clink = dbConnect();


################################################# Header
function drawHeader($s = 0)
{
	$value = '';
	if (isset($_GET['search'])) {
		$value = $_GET['search'];
	}
	echo "<div  class='sticky'>
	
	<div class='bar'></div>
	<header class='header'>
    <div class='container'>
        <a href='index.php' ><img  href='index.php' src='assets/img/logo.png'></a>
		<div class='search1'>
		<form class='form-inline my-2 my-lg-0' method='get' action='search.php' >
		<div class='form-group has-search'>
		<span class='fa fa-search form-control-feedback'></span>
		<input type='search' name='search' value='$value'class='form-control' placeholder='Search' required>
		<button class='btn btn-outline-success my-2 my-sm-0' type='submit'>Search</button>
	  </div>
    </form>


	
	</div>
		";


	if (isLogged() == 1) {
		logout();
		myaccount();
		echo "<div class='container control'>
	<a   class='btn btn-lg btn-block addads adds ' href='createads.php'>+ Place an Ad</a></div>";
		echoaddadslog($s);
		echo "<div class='container'>";


		if (isset($_SESSION['errors']) and count($_SESSION['errors'])) {
			$errors = implode("<br>", $_SESSION['errors']);
			outputMessage($errors, 'danger');
		}

		//Show success messages  if exists
		if (isset($_SESSION['successes']) and count($_SESSION['successes'])) {
			$successes = implode("<br>", $_SESSION['successes']);
			outputMessage($successes);
		}
		//Remove errors & successes from session 
		unset($_SESSION['errors']);
		unset($_SESSION['successes']);
		echo "</div>";
	} else if (isLogged() == 2) {
		logout();

		echo "<a  href='adminpannel.php' ><button type='button' class='btn button btnuserlogn' name='submitlogin'>
			Admin control Panel
			</button></a>
			</header>";
	} else {
		echologinform();
		echoRegisterform();

		echoaddadsnolog();
		echo "<div class='container'>";

		if (isset($_SESSION['errors']) and count($_SESSION['errors'])) {
			$errors = implode("<br>", $_SESSION['errors']);
			outputMessage($errors, 'danger');
		}

		//Show success messages  if exists
		if (isset($_SESSION['successes']) and count($_SESSION['successes'])) {
			$successes = implode("<br>", $_SESSION['successes']);
			outputMessage($successes);
		}
		//Remove errors & successes from session 
		unset($_SESSION['errors']);
		unset($_SESSION['successes']);
		//Show error messages  if exists
		if (isset($_SESSION['errorsLogin']) and count($_SESSION['errorsLogin'])) {
			$errors = implode("<br>", $_SESSION['errorsLogin']);
			outputMessage($errors, 'danger');
			unset($_SESSION['errorsLogin']);
		}
	}
	echo "</div>";
}



#################################################  buttons

function echologinform()
{

	echo "          
	<button type='button' class='btn button btnuserlogn'data-toggle='modal' data-target='#myModal' >
	login
	</button>

	<div class='modal' id='myModal'data-backdrop='false' style='background-color: rgba(0, 0, 0, 0.8);'>
			<div class='modal-dialog'>
				<div class='modal-content LogIn'>
					<div class='modal-header'>
						<h4 class='modal-title'>Login</h4>
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
					</div>


<div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>

  <div class='carousel-inner'  data-interval='500'>
    <div class='carousel-item active'>
	<div class='d-flex justify-content-center'>
	<img class=' h-25 w-25' src='img/1st.png' alt='First slide'>

</div>
<div class='d-flex justify-content-center'>
<p>Help us become one of the safest places to buy and sell.</p>
</div>

     
    </div>
    <div class='carousel-item'>

	<div class='d-flex justify-content-center'>
	<img class='d-block h-25 w-25' src='img/2nd.png' alt='Second slide'>
</div>
<div class='d-flex justify-content-center'>
<p>Close deals from the comfort of your place.</p>
</div>
    
    </div>
    <div class='carousel-item'>
	<div class='d-flex justify-content-center'>
	    
	<img class='d-block h-25 w-25' src='img/3rd.png' alt='Third slide'>
</div>
<div class='d-flex justify-content-center'>
<p>Keep all your favourites in one place.</p>
</div>

    </div>
	
  </div>
  <a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>
    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
    <span class='sr-only'>Previous</span>
  </a>
  <a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>
    <span class='carousel-control-next-icon' aria-hidden='true'></span>
    <span class='sr-only'>Next</span>
  </a>

</div>





				
					<div class='modal-body'>
						<div class='col-10 float-left'>

						<form class='flex-c' action='login.php' method='POST'>
						<div class='input-box'>
						  <span class='label'>E-mail</span>
						  <div class=' flex-r input'>
							<input type='text' placeholder='name@abc.com' name='usernamelogin' required>
							<i class='fas fa-at'></i>
						  </div>
						</div>
						
						<div class='input-box'>
						  <span class='label'>Password</span>
						  <div class='flex-r input'>
							<input type='password' placeholder='8+ (a, A, 1, #)' name='passwordlogin' required>
							<i class='fas fa-lock'></i>
						  </div>
						</div>
						
						<button style='margin-left:160px; border: 2px solid rgba(216, 216, 216, 1); ' type='submit' class='btn'>Login</button>

						</div >
						</form>
						<div style='text-align:center'>
						<h6><b> <u><a href='' data-dismiss='modal' data-toggle='modal' data-target='#myModal1'>Registration</a></u></b></h6>
						
						<h7>All your personal details are safe with us.
						</h7>
						<br>
						<br>
						<p style='font-size:14px;color: #7f88a6;'>If you continue, you are accepting <a href=''>@nstumart Terms and Conditions </a> <a href=''>and Privacy Policy </a> </p>
						</div>

					</div>
				</div>
			</div>
		</div>
	

	";
}

function echoRegisterform()
{

	echo "	
	
	<button type='button' class='btn btnuserlogn button' data-toggle='modal' data-target='#myModal1' name='submitlogin'>
	signup
	</button>
		<!-- The Modal Register -->
	<div class='modal' id='myModal1' data-backdrop='false' style='background-color: rgba(0, 0, 0, 0.8);'>
		<div class='modal-dialog'>
			<div class='modal-content Register'>
				<!-- Modal Header -->
				<div class='modal-header'>
						<h2>Register</h2>
	
					<button type='button' class='close' data-dismiss='modal'>&times;</button>
				</div>
				<!-- Modal body -->
				<div class='modal-body'>

					<form class='form-horizontal' action='signupsave.php' method='POST'>

					
						<div class='form-group'>
							<label class='control-label col-sm-5' >Name</label>
							<div class='col-sm-12'>
								<input type='text' class='form-control' placeholder='Name' name='UserName' required>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-sm-5' >Email:</label>
							<div class='col-sm-12'>
								<input type='email' class='form-control'  placeholder='Your Email' name='Email' required>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-sm-5' >Password:</label>
							<div class='col-sm-12'>
								<input type='password' class='form-control'  placeholder='password' name='Password' required>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-sm-5' for='pwd'>Confirm password:</label>
							<div class='col-sm-12'>
								<input type='password' class='form-control'  placeholder='Confirm password' name='ConfirmPassword' required>
							</div>
						</div>
						<div class='form-group'>
							<label class='control-label col-sm-5' for='pwd'>Phone Number</label>
							<div class='col-sm-12'>
								<input type='text' class='form-control'  placeholder='Phone Number' name='Phone' required>
							</div>
						</div>
						<div class='form-group'>
							<div class='col-sm-12'>
							<label>Upazila</label>
							<select class='form-control' onchange='getareas(this.value)' name='city'> ";
	$cities = getAllCities();
	for ($i = 0; $i < sizeof($cities); $i++) {
		echo " <option value='{$cities[$i][0]}'>{$cities[$i][1]}</option>";
	}
	echo "
							</select>
							</div>
						</div>
						<div class='form-group' >
							<div class='col-sm-12'>
							<label>Area</label>
							<select id='areaDiv'  name='areas' class='form-control' >";
	$areas = getCityAreas(1);
	for ($i = 0; $i < sizeof($areas); $i++) {
		echo " <option value='{$areas[$i][0]}'>{$areas[$i][1]}</option>";
	}
	echo "
							</select>
							</div>
						</div>
						<div class='form-group'>
							<div class='col-sm-12'>
								<select class='form-control' name='type'>
								<option value='1'>Male</option>
								<option value='2'>Female</option>
								</select>
							</div>
						</div>
						
						<div class='form-group'>
							<div class='col-sm-offset-3 col-sm-12'>
								<button style='margin-right:170px; border: 2px solid rgba(216, 216, 216, 1); 'type='submit' name='submitRegister' class='btn btn-default'>Submit</button>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	</div> ";
}


function echoaddadslog($s)
{
	if ($s == 0) {
		echo "
	<div class='container control'>
	<a   class='btn btn-lg btn-block addads adds ' href='createads.php'>+ Place an Ad</a></div>";
	} else {
		echo "</header>";
	}
}

function echoaddadsnolog()
{
	echo "</header>
	<div class='container control'>
	<a   class='btn btn-lg btn-block addads ' href='' data-toggle='modal' data-target='#myModal'>+ Place an Ad</a>
	</div>
	</div
	";
}

function myaccount()
{
	echo "
	<a  href='profile.php' ><button type='button' class='btn btnuserlogn'  name='submitlogin'>
	";
	echo $_SESSION['usernamelogin'];
	echo "</button></a>";
}

function logout()
{
	echo "<a  href='logout.php' ><button type='button' class='btn btnuserlogn' name='submitlogin'>
	logout
	</button></a>";
}

################################################# select city and area
function getAllCities()
{
	$cities = [];
	global $clink;
	$result = mysqli_query($clink, "SELECT cityID, cityName FROM cities ");
	while ($row = mysqli_fetch_row($result)) {
		$cities[] = $row;
	}
	return $cities;
}
function getCityAreas($cityID)
{
	$areas = [];
	global $clink;
	$result = mysqli_query($clink, "SELECT areaID, areaName FROM areas WHERE cityID=$cityID");
	while ($row = mysqli_fetch_row($result)) {
		$areas[] = $row;
	}
	return $areas;
}



################################################# Test user is logged or not 
/**
 * Check if there is a logged in user or not
 */
function isLogged()
{
	if (isset($_SESSION['LOGGEDIN'])) {
		//Logged in user
		return 1;
	} else if (isset($_SESSION['admin'])) {
		//Logged in  by admin
		return 2;
	} else {
		//NOT Logged in 
		return 3;
	}
}



################################################# get comments 

function getcomments()
{
	global $AdsID;
	global $clink;
	global $comments;
	$resultcomments = mysqli_query($clink, "SELECT users.UserName, comments.Date, comments.Details , comments.UserID ,comments.Status,comments.commentID
	from users , comments 
	WHERE comments.AdsID=$AdsID 
	and users.UserID=comments.UserID");
	while ($rowcomments = mysqli_fetch_assoc($resultcomments)) {
		$comments[] = $rowcomments;
	}
	return $comments;
}

function activeanddeactive($table, $where, $value)
{
	global $clink;
	$result = mysqli_query($clink, "SELECT Status from $table where $where={$value}");
	$row = mysqli_fetch_array($result);
	if ($row['Status'] == 1) {
		$result1 = mysqli_query($clink, "UPDATE $table set Status='0' WHERE $where = '$value'") or die("Cannot execute SQL - " . mysqli_error($clink));
		return $result1;
	} else {
		$result2 = mysqli_query($clink, "UPDATE $table set Status='1' WHERE $where = '$value'") or die("Cannot execute SQL - " . mysqli_error($clink));
		return $result2;
	}
}
function showandhide($table, $where, $value)
{
	global $clink;
	$result = mysqli_query($clink, "SELECT Status from $table where $where={$value}");
	$row = mysqli_fetch_array($result);
	if ($row['Status'] == 1) {
		$result1 = mysqli_query($clink, "UPDATE $table set Status='0' WHERE $where = '$value'") or die("Cannot execute SQL - " . mysqli_error($clink));
		return $result1;
	} else {
		$result2 = mysqli_query($clink, "UPDATE $table set Status='1' WHERE $where = '$value'") or die("Cannot execute SQL - " . mysqli_error($clink));
		return $result2;
	}
}

################################################# output messages

function outputMessage($message = '', $type = 'success')
{
	echo "<div class='alert alert-{$type}'>{$message}</div>";
}

######################################################image validation
function file_upload($file, $name)
{
	$status = true;
	$msg = "success";
	$file_name = $file[$name]['name'];
	$image_array = explode('.', $file_name);
	$imageFileType = $image_array[1];
	$rand = rand(100000, 99999999);
	$new_image_name = time() . $rand . '_' . $image_array[0];
	$new_image_name_with_format = $new_image_name . '.' . $image_array[1];
	$upload_path = $new_image_name_with_format;
	$image_size = getimagesize($file[$name]['tmp_name']);
	if ($image_size === false) {
		$status = false;
		$msg = "file is not an image";
	}

	if ($image_size[0] > 3000000) {
		$status = false;
		$msg = "file reach maximum width";
	}
	if (file_exists($upload_path)) {
		$status = false;
		$msg = "file is exist";
	}
	if ($file[$name]['size'] > 2000000) {
		$status = false;
		$msg = "file is largert then 2mb";
	}

	if (
		$imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif"
	) {
		//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";

		$status = false;
		$msg = "Sorry, only jpg, jpeg, png & gif files are allowed.";
	}

	//echo '<pre>';
	//print_r($file);
	if ($status) {
		move_uploaded_file($file[$name]['tmp_name'], 'assets/img/' . $upload_path);
	}

	$message['status'] = $status;
	$message['msg'] = $msg;
	if ($status) {
		$message['path'] = $upload_path;
	} else {
		$message['path'] = '';
	}

	return $message;
}
