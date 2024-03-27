<?php
include ("../includes/connection.php");

session_start();
$input_data = file_get_contents('php://input');
// decode the data from js
$data = json_decode($input_data, true);

$content = $data['content'];
$postId = $data['postId'];

// get the user id from the session
if (isset($_SESSION['userID'])){
    $userId = $_SESSION['userID'];
    $isEnabled = $_SESSION['isEnabled'];
}  else{
    http_response_code(200); // Set HTTP response code to 200 so we dont catch the error improperly
    echo json_encode(array("error" => "You must login/signup to create a post"));
    exit; // Stop further execution
}

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
        http_response_code(200); // Set HTTP response code to 200
        echo json_encode(array("success" => "it seems", "redirect" => "$referrer"));
        exit; // Stop further execution

    } else {
        http_response_code(200); // Set HTTP response code to 200
        echo json_encode(array("error" => "You have been disabled by an admin and cannot comment on a post", "redirect" => $referrer));
        exit; // Stop further execution
    }
}catch(Exception $e){
    http_response_code(200); // Set HTTP response code to 200
    echo json_encode(array("error" => $e->getMessage(), "redirect" => "$referrer"));
    exit; // Stop further execution
}
