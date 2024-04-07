<?php
include ("../includes/connection.php");

$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
session_start();

$userid = $_SESSION['userID'];
$isEnabled = $_SESSION['isEnabled'];

if (!isset($_POST['courseName'])) {
    die("Missing information");
}


try {
    $coursename = $_POST['courseName'];
    // This query select the courses that this user isn't a part of 
    $query = "SELECT courseID, name FROM Course WHERE name LIKE ? AND courseID NOT IN (SELECT courseID FROM UserCourse WHERE userID = ?);";
    $conn = connectToDB();

    $stmt = $conn->prepare($query);

    $likeParameter = '%' . $coursename . '%';
    $stmt->bind_param("si", $likeParameter, $userid);
    $stmt->execute();

    $result = $stmt->get_result();
    $courseinfo = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(array("success" => "successful retrieval", "courses" => $courseinfo));
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}
