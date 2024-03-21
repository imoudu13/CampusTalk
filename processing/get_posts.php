<?php
require_once('../includes/connection.php');

function getPosts() {
    $conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Posts";
    $result = $conn->query($sql);
    $posts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert the binary image data to base64 encoding
            $imageData = base64_encode($row['postImage']);
            // Construct the post object including image data
            $post = [
                'postID' => $row['postID'],
                'title' => $row['title'],
                'content' => $row['content'],
                'userID' => $row['userID'],
                'departmentID' => $row['departmentID'],
                'courseID' => $row['courseID'],
                'postImage' => $imageData, // Include the image data
                'createdAt' => $row['createdAt']
            ];
            $posts[] = $post;
        }
    }

    close_db($conn);
    return $posts;
}
//echo the json encoded string
echo json_encode(getPosts());

