<?php
include_once("includes/functions.php");
?>
<?php
$ReceivedUserName = test_input(strtolower($_POST['UserName']));
$ReceivedEmail = test_input(strtolower($_POST['Email']));
$ReceivedPassword = test_input(strtolower($_POST['Password']));
$ReceivedConfirmPassword = test_input($_POST['ConfirmPassword']);
$ReceivedPhone = test_input($_POST['Phone']);
$Receivedtype = test_input(strtolower($_POST['type']));
$Receivedareas = test_input($_POST['areas']);
$errors = [];
$successes = [];

// if (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/', $ReceivedPassword)) {

//     $errors[] = "Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character.";
// }
if (preg_match('/^[0-9]{11}+$/', $mobile)) {

    $errors[] = "Mobile number must be valid and 11 digit.";
}

if (!preg_match("/^[a-zA-Z-' ]*$/", $ReceivedUserName)) {

    $errors[] = "Only letters and white space allowed.";
}

if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $ReceivedEmail)) {

    $errors[] = "The email address is incorrect";
}




function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Validate for Password 
if ($ReceivedPassword != $ReceivedConfirmPassword) {
    $errors[] = 'Password and confirm donot match.';
}
if (
    $ReceivedUserName == "" ||
    $ReceivedEmail == "" ||
    $ReceivedPassword == "" ||
    $ReceivedConfirmPassword == "" ||
    $ReceivedPhone == "" ||
    $Receivedtype == "" ||
    $Receivedareas == ""
) {
    $errors[] = 'Please Fill In All Data.';
}
//Validate for data 

//Check for user 
//Connect to DB [done from file functions]
//Seledct all users with the same data

$result = mysqli_query($clink, "SELECT * from users WHERE  Phone='{$ReceivedPhone}' ") or die(mysqli_error($clink));
if (mysqli_num_rows($result) > 0) {
    //DB found a user with this Phone
    $errors[] = 'Phone is not available, Please try a different one';
}
$result = mysqli_query($clink, "SELECT * from users WHERE  Email='{$ReceivedEmail}' ") or die(mysqli_error($clink));
if (mysqli_num_rows($result) > 0) {
    //DB found a user with this Email
    $errors[] = 'Email is not available, Please try a different one';
}
if (count($errors) == 0) {
    // $hash = password_hash($ReceivedPassword, PASSWORD_DEFAULT);

    $qq = "INSERT INTO `users` (`UserID`, `UserName`, `Email`, `Password`, `Phone`, `type`, `Status`,`areaID`) VALUES
	(NULL, '$ReceivedUserName', '$ReceivedEmail', '$ReceivedPassword', '$ReceivedPhone',  '$Receivedtype', 1 , '$Receivedareas')";
    $successes[] = 'User data has been successfully saved.';
    $result = mysqli_query($clink, $qq) or die(mysqli_error($clink));
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    $errors[] = "Please Follow The Instructions";
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
//Add errors & success messages to the session to be displayed on the other page
$_SESSION['errors'] = $errors;
$_SESSION['successes'] = $successes;

?>