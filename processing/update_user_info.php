<?php

include_once ("../includes/connection.php");

session_start();

// these if blocks check if the some information is set, if not the script is terminated
if (!isset ($_SESSION['userID']))
    die ('user id is not set');

if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die ('having trouble getting data');

if (!isset ($_POST['new-username']) || !isset ($_POST['new-fname']) || !isset ($_POST['new-lname']) || !isset ($_POST['new-email']))
    die ('missing data');

$userid = $_SESSION['userID'];

// get the previous page that the user was at, it will be used to redirect them after a succesful update
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

try {
    $conn = connectToDB();

    // get some information from post
    $uname = $_POST['new-username'];
    $fname = $_POST['new-fname'];
    $lname = $_POST['new-lname'];
    $email = $_POST['new-email'];

    if (isset ($_FILES["new-profileimage"]) && $_FILES["new-profileimage"]["error"] == UPLOAD_ERR_OK) {
        $query = "UPDATE Users SET username = ?, firstname = ?, lastname = ?, email = ?, profileimage = ? WHERE userID = ?;";

        $image = $_FILES['new-profileimage']['name'];
        // Process and move the uploaded file to desired location
        $image = file_get_contents($_FILES['new-profileimage']['tmp_name']);

        $stmt = $conn->prepare($query);

        $stmt->bind_param("ssssbi", $uname, $fname, $lname, $email, $image, $userid);

        $stmt->send_long_data(4, $image);
        $stmt->execute();
        
    } else {
        $query = "UPDATE Users SET username = ?, firstname = ?, lastname = ?, email = ? WHERE userID = ?;";

        $stmt = $conn->prepare($query);

        $stmt->bind_param("ssssi", $uname, $fname, $lname, $email, $userid);

        $stmt->execute();
    }

    echo json_encode(array("success" => true, "redirect" => $referrer));
} catch (Exception $e) {
    // Handle any exceptions here
    echo json_encode(array("error" => "An error occurred". $e->getMessage(), "redirect" => "index.php"));
}