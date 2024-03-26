<?php
include ("../includes/connection.php");

session_start();
$input_data = file_get_contents('php://input');
// decode the data from js
$data = json_decode($input_data, true);

$content = $data['content'];
$postId = $data['postId'];

// get the user id from the session
$userId = $_SESSION['userID'];
$isEnabled = $_SESSION['isEnabled'];

// get the referrer info so that if it is set we can send the user back to the previous page upon completion of processing
$referrer = isset ($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// now insert the comment into the db
try{
    if ($isEnabled == 1) {
        $conn = connectToDB();
        $query = "INSERT INTO Comments (content, userID, postID) VALUES (?, ?, ?);";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $content, $userId, $postId);

        $stmt->execute();

        // close resources
        $stmt->close();
        close_db($conn);
        echo json_encode(array("success" => "it seems", "redirect" => "$referrer"));
    } else {
        echo json_encode(array("error" => "You have been disabled by an admin and cannot comment on a post", "redirect" => $referrer));
    }
}catch(Exception $e){
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
}