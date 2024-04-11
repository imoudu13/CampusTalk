<?php

include ("../includes/connection.php");

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
session_start();

if (!isset($_SESSION['userID']))
    die('missing userid');

if (!isset($_GET['cid']))
    die("missing course id");


$userid = $_SESSION['userID'];
$cid = $_GET['cid'];

try {
    $delete = "DELETE FROM UserCourse WHERE userID = ? AND courseID = ?;";
    $conn = connectToDB();
    $stmt = $conn->prepare($delete);

    $stmt->bind_param("ii", $userid, $cid);

    $stmt->execute();

    header("Location: ../pages/index.php");
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}