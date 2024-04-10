<?php

include ("../includes/connection.php");

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
session_start();

if (!isset($_POST['cid']))
    die("missing course id");


$cid = $_POST['cid'];

try {
    $delete = "DELETE FROM Course WHERE courseID = ?;";
    $conn = connectToDB();
    $stmt = $conn->prepare($delete);

    $stmt->bind_param("i", $cid);

    $stmt->execute();

    echo json_encode(array("success" => "succesful deletion", "redirect" => "$referrer"));
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}