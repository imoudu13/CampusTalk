<?php

session_start();

require_once ('../includes/connection.php');

if (!isset($_POST['cid']))
    die("Missing information.");

$cid = $_POST['cid'];
$userid = $_SESSION['userID'];

try {
    $query = "SELECT commentID, content, cm.userID, cm.createdAt, username, profileimage FROM CourseMessage AS cm JOIN Users AS u ON cm.userID = u.userID WHERE courseID = ?;";
    $conn = connectToDB();

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cid);
    $stmt->execute();

    
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    
    // Log JSON data before echoing
    error_log("JSON Data: " . json_encode(['success' => "it worked", 'messages' => $messages]));

    echo json_encode(array("success" => "successful retrieval", "messages" => $messages[0]['commentID']));

} catch (Exception $e) {
    // Handle exception
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}