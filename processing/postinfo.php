<?php
include("../includes/connection.php");

session_start();
$postId = $_SESSION['postId'];

$query = "SELECT * FROM Posts WHERE postID = ?;";
$commentsQuery = "SELECT * FROM Comments WHERE postID = ?;";

try {
    $conn = connectToDB();

    // throw an error in case it can't connect to the db
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query to fetch posts
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();

    // Fetch posts
    $postsResult = $stmt->get_result();
    $posts = $postsResult->fetch_all(MYSQLI_ASSOC);

    // Prepare and execute the query to fetch comments
    $stmt = $conn->prepare($commentsQuery);
    $stmt->bind_param("i", $postId);
    $stmt->execute();

    // Fetch comments
    $commentsResult = $stmt->get_result();
    $comments = $commentsResult->fetch_all(MYSQLI_ASSOC);

    // Close the database connection
    $conn->close();

    // Combine posts and comments into a single array
    $data = array(
        'posts' => $posts,
        'comments' => $comments
    );

    // Convert the data to JSON format
    $json_data = json_encode($data);

    // Output the JSON data
    echo $json_data;
} catch (Exception $e) {
    // Show error message
    echo "Error: " . $e->getMessage();
}
include ("../includes/connection.php");

if (isset($_POST['postId'])) {
    $postId = $_POST['postId'];

    $query = "SELECT * FROM Posts WHERE postID = ?;";
    $commentsQuery = "SELECT * FROM Comments WHERE postID = ?;";

    try {
        $conn = connectToDB();

        // throw an error in case it can't connect to the db
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the query to fetch posts
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $postId);
        $stmt->execute();

        // Fetch posts
        $postsResult = $stmt->get_result();
        $posts = $postsResult->fetch_all(MYSQLI_ASSOC);

        // Prepare and execute the query to fetch comments
        $stmt = $conn->prepare($commentsQuery);
        $stmt->bind_param("i", $postId);
        $stmt->execute();

        // Fetch comments
        $commentsResult = $stmt->get_result();
        $comments = $commentsResult->fetch_all(MYSQLI_ASSOC);

        // Close the database connection
        $conn->close();

        // Combine posts and comments into a single array
        $data = array(
            'posts' => $posts,
            'comments' => $comments
        );

        // Convert the data to JSON format
        $json_data = json_encode($data);

        // Output the JSON data
        echo $json_data;
    } catch (Exception $e) {
        // Show error message
        echo "Error: " . $e->getMessage();
    }
}
