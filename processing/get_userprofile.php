<?php require_once('../includes/connection.php');
//checks if user is logged in
session_start();
if(!isset($_SESSION['username'])){
    //redirect the user to login page since user has not logged in
    header("Location: login.php");
    exit();
}

function getUserProfile() {
    $conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

$sqlquery = "SELECT * FROM users";
$result = $conn->query($sqlquery);
$userData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Fill the user array with user info
        $userInfo = [
            'userID' => $row['userID'], // Include the department name
            'userName' => $row['username'],
            'firstName' => $row['firstname'],
            'lastName' => $row['lastname'],
            'email' => $row['email'],
            'password' => $row['userpassword'],
            'imageprofile' => $row['imageprofile'],
            'createdAt' => $row['createdAt'],
            'isAdmin' => $row['isAdmin']

        ];
        $userData[] = $userInfo;
    }
}

close_db($conn);
return $userData;
}

//echo the json encoded string
echo json_encode(getUserProfile());
