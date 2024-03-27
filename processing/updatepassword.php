<?php

session_start();

include_once('../includes/connection.php');

if(!isset($_SESSION['userID'])) die("user id is not set");

if($_SERVER['REQUEST_METHOD'] !== 'POST') die("Having trouble getting information");

if(!$_POST['new-password']) die("incomplete data");

$referrer = isset ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
try{
    $conn = connectToDB();

    $userid = $_SESSION['userID'];

    $pw = $_POST['new-password'];

    $query = "UPDATE Users SET userpassword = ? WHERE userID = ?;";

    // prepare query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $pw, $userID);

    $stmt->execute(); // execute obviously

    // close resources
    $stmt->close();
    $conn->close();
    echo json_encode(array("success" => "all good", "redirect" => "$referrer"));
}catch (Exception $e){
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}

