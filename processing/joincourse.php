<?php

include ("../includes/connection.php");

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
session_start();

if (!isset($_SESSION['userID']))
    die('missing userid');

if (!isset($_POST['cid']))
    die("missing course id");


$userid = $_SESSION['userID'];
$cid = $_POST['cid'];

try {
    $insertion = "INSERT INTO UserCourse (userID, courseID) VALUES (?, ?);";
    $conn = connectToDB();
    $stmt = $conn->prepare($insertion);

    $stmt->bind_param("ii", $userid, $cid);

    $stmt->execute();

    echo json_encode(array("success" => "succesful insertion", "redirect" => "$referrer"));
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}