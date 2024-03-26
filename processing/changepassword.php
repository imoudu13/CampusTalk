
<?php
include ("../includes/connection.php");

$conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents('php://input'), true);
$newPassword = $data['newPassword'];

// Validate and process the new password


if (strlen($newPassword) < 8) {
    $message = 'Password must be at least 8 characters long.';\
    alert($message);
    exit();
}


$username = $_SESSION['username'];
$hashpassword = password_hash($newPassword, PASSWORD_DEFAULT);

//Update old password to new password

$sqlquery = "UPDATE users SET userpassword = ? WHERE username = ?";
$stmt = $conn ->prepare($sqlquery);
$stmt ->bind_param("ss", $hashpassword, $username);

if($stmt -> execute()){
    //password updated success
    echo "Password has been updated!";
} else {
    echo "Error updating password: " . $conn -> error;
}

?>



