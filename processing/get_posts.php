<?php
require_once('../includes/connection.php');

function getPosts() {
    $conn = connectToDB();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM Posts LIMIT 1000";
    $result = $conn->query($sql);
    $posts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Convert the binary image data to base64 encoding
            $imageData = base64_encode($row['postImage']);
            // Find department from department id
            $deptId = $row['departmentID'];
            $sql1 = "SELECT * FROM department WHERE departmentID = " . $deptId;
            $result1 = $conn->query($sql1);

            $departmentName = '';
            if ($result1->num_rows > 0) {
                $deptRow = $result1->fetch_assoc();
                $departmentName = $deptRow['name'];
            }

            // Construct the post object including image data and department name
            $post = [
                'postID' => $row['postID'],
                'title' => $row['title'],
                'content' => $row['content'],
                'userID' => $row['userID'],
                'departmentID' => $row['departmentID'],
                'departmentName' => $departmentName, // Include the department name
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