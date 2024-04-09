<?php
include ("../includes/connection.php");

session_start();
$input_data = file_get_contents('php://input');

// decode the data from js
$data = json_decode($input_data, true);

$content = $data['content'];
$cid = $data['courseid'];

// end execution if not logged in
if (!isset($_SESSION['userID']))
    die("missing info");

$userId = $_SESSION['userID'];

try {
    $conn = connectToDB();
    $query = "INSERT INTO CourseMessage (content, userID, courseID) VALUES (?, ?, ?);";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $content, $userId, $cid);

    $stmt->execute();

    // close resources
    $stmt->close();
    close_db($conn);
    http_response_code(200); // Set HTTP response code to 200
    echo json_encode(array("success" => "it seems"));
} catch (Exception $e) {
    http_response_code(200); // Set HTTP response code to 200
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
    exit; // Stop further execution to prevent errors from catching incorrectly
}
